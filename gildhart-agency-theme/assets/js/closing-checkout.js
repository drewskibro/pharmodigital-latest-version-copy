/**
 * Gildhart — Closing Offer checkout flow.
 *
 * Two-step inline subscription checkout using Stripe's Payment Element.
 * No popups, no Checkout Session redirects — payment confirms in-place
 * on /the-agent and Stripe redirects to /agent-thank-you only after
 * confirmation succeeds.
 *
 * Step 1 (initiate): user fills lead fields → submit → JS POSTs to
 *   /wp-json/gildhart/v1/agent-checkout → backend creates Customer +
 *   Subscription with payment_behavior=default_incomplete → returns
 *   client_secret + publishable_key + amount_formatted. JS then
 *   initialises Stripe.js, mounts a Payment Element into
 *   #svcClosingPaymentMount, locks the lead fields (read-only), and
 *   updates the submit button to "Pay £X" using the VAT-inclusive
 *   total Stripe Tax has computed.
 *
 * Step 2 (confirm): user enters card details into the Payment Element
 *   → submit → stripe.confirmPayment() with return_url pointing at
 *   GildhartCheckout.thankYouUrl. On success Stripe redirects there
 *   with payment_intent in the query string. On failure the error is
 *   surfaced inline and the user can retry.
 *
 * Localised globals from PHP (see functions.php):
 *   GildhartCheckout.restUrl     — e.g. https://site.com/wp-json/gildhart/v1/
 *   GildhartCheckout.thankYouUrl — e.g. https://site.com/agent-thank-you/
 */
(function () {
  'use strict';

  if (typeof Stripe === 'undefined' || typeof GildhartCheckout === 'undefined') {
    return;
  }

  var form          = document.getElementById('svcClosingForm');
  var submitBtn     = form && form.querySelector('.svc-closing-form-submit');
  var paymentMount  = document.getElementById('svcClosingPaymentMount');
  var paymentSection = document.getElementById('svcClosingPaymentSection');
  var errorBanner   = document.getElementById('svcClosingFormError');

  if (!form || !submitBtn || !paymentMount) return;

  // Step 1 state — null until /agent-checkout has succeeded. Once a
  // client_secret has been issued the form transitions to step 2 and
  // submit handler routes to confirmPayment instead of initiateCheckout.
  var stripe        = null;
  var elements      = null;
  var paymentEl     = null;
  var clientSecret  = null;
  // Set true once the Payment Element fires its 'ready' event. Guards
  // against calling stripe.confirmPayment() before the element is
  // mounted/ready — the cause of the "elements should have a mounted
  // Payment Element" error if a user submits a beat too early.
  var paymentReady  = false;

  // Override the ACF-driven "Deploy The Agent" label on page load so the
  // initial button text reflects the actual Step 1 action. After Step 1
  // succeeds the label is rewritten again to "Pay £X →" using the
  // VAT-inclusive total returned by the WP REST endpoint.
  var step1Label = 'Continue to Payment';
  submitBtn.innerHTML = step1Label + ' <span aria-hidden="true">→</span>';

  // ── UI helpers ────────────────────────────────────────────────
  function setError(msg) {
    if (!errorBanner) return;
    if (msg) {
      errorBanner.textContent = msg;
      errorBanner.hidden = false;
    } else {
      errorBanner.textContent = '';
      errorBanner.hidden = true;
    }
  }

  function setSubmitState(state, label) {
    submitBtn.disabled = (state === 'busy');
    if (label) {
      // Preserve the trailing arrow span if the original button had one.
      submitBtn.innerHTML = label + ' <span aria-hidden="true">→</span>';
    }
  }

  function lockLeadFields() {
    Array.prototype.forEach.call(form.querySelectorAll('input'), function (input) {
      if (input.type === 'hidden') return;
      input.readOnly = true;
      input.classList.add('svc-closing-form-input--locked');
    });
  }

  // ── Form data + validation ────────────────────────────────────
  function readForm() {
    var data = {};
    Array.prototype.forEach.call(form.elements, function (el) {
      if (!el.name) return;
      data[el.name] = (el.value || '').trim();
    });
    return data;
  }

  function validateLead(data) {
    var required = ['plan', 'practice', 'first_name', 'last_name', 'email'];
    for (var i = 0; i < required.length; i++) {
      if (!data[required[i]]) {
        return 'Please fill in all required fields before continuing.';
      }
    }
    // Light email shape check — backend does the authoritative check.
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
      return 'Please enter a valid email address.';
    }
    if (!/^(monthly|annual)$/.test(data.plan)) {
      return 'Please select a billing plan above.';
    }
    return null;
  }

  // ── Step 1: create the Subscription, mount Payment Element ────
  function initiateCheckout(leadData) {
    setSubmitState('busy', 'Securing your spot');

    return fetch(GildhartCheckout.restUrl + 'agent-checkout', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      // Send only the fields the backend expects — strips the form's
      // own internal fields (e.g. plan stays, but stale form keys go).
      body: JSON.stringify({
        plan:          leadData.plan,
        first_name:    leadData.first_name,
        last_name:     leadData.last_name,
        email:         leadData.email,
        practice_name: leadData.practice,
        website:       leadData.website || ''
      })
    }).then(function (res) {
      return res.json().then(function (json) {
        if (!res.ok) {
          throw new Error(json && json.message ? json.message : 'Checkout could not be initialised. Please try again.');
        }
        return json;
      });
    }).then(function (data) {
      clientSecret = data.client_secret;
      stripe = Stripe(data.publishable_key);
      elements = stripe.elements({
        clientSecret: clientSecret,
        appearance: {
          theme: 'stripe',
          variables: {
            colorPrimary:        '#1E3D2F',
            colorBackground:     '#ffffff',
            colorText:           '#0f172a',
            colorDanger:         '#b91c1c',
            fontFamily:          'Inter, system-ui, -apple-system, sans-serif',
            spacingUnit:         '4px',
            borderRadius:        '10px'
          },
          rules: {
            '.Input':  { borderColor: 'rgba(15, 23, 42, 0.18)' },
            '.Label':  { fontWeight: '600', color: '#0f172a' }
          }
        }
      });
      paymentEl = elements.create('payment', { layout: 'tabs' });

      // Track readiness — confirmPayment is blocked until this fires.
      paymentReady = false;
      paymentEl.on('ready', function () { paymentReady = true; });

      // Reveal the Card Payment section (hidden in the markup until
      // Step 1 succeeds), THEN mount — mounting into a hidden parent
      // can produce a zero-height iframe in some browsers.
      if (paymentSection) paymentSection.hidden = false;
      paymentEl.mount(paymentMount);

      lockLeadFields();
      setSubmitState('idle', 'Pay ' + (data.amount_formatted || ''));
      setError(null);

      // Smoothly scroll the new card section into view so the user sees
      // it without having to hunt — the form might be tall on mobile.
      if (paymentSection && typeof paymentSection.scrollIntoView === 'function') {
        paymentSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  }

  // ── Step 2: confirm the payment via the Payment Element ───────
  function confirmPayment() {
    setSubmitState('busy', 'Processing payment');
    setError(null);

    return stripe.confirmPayment({
      elements: elements,
      confirmParams: {
        return_url: GildhartCheckout.thankYouUrl
      }
    }).then(function (result) {
      // confirmPayment only returns a result here on synchronous error
      // (validation, network, declined). On success the browser is
      // already navigating to return_url — this code never runs.
      if (result && result.error) {
        throw new Error(result.error.message || 'Payment could not be completed. Please try again.');
      }
    });
  }

  // ── Submit dispatcher ─────────────────────────────────────────
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    setError(null);

    var data = readForm();

    // Step 2 path: client_secret already exists → confirm card.
    if (clientSecret) {
      // Don't confirm until the Payment Element has fired 'ready' — calling
      // confirmPayment against an unmounted/not-ready element throws Stripe's
      // "elements should have a mounted Payment Element" error.
      if (!paymentReady) {
        setError('Just a moment — the card form is still loading.');
        return;
      }
      confirmPayment().catch(function (err) {
        setError(err.message);
        // Reset to "Pay £X" so the user can retry. Use the original
        // computed total — pull it from the button's last-known label
        // by storing it elsewhere if needed; simplest is to stay on
        // the same label format Stripe gave us.
        setSubmitState('idle', submitBtn.dataset.payLabel || 'Pay');
      });
      return;
    }

    // Step 1 path: validate locally then call the WP endpoint.
    var validationError = validateLead(data);
    if (validationError) {
      setError(validationError);
      return;
    }

    initiateCheckout(data).then(function () {
      // Cache the "Pay £X" label so retries after a card decline
      // restore the right button text rather than "Pay" alone.
      submitBtn.dataset.payLabel = submitBtn.textContent.replace(/\s*→\s*$/, '').trim();
    }).catch(function (err) {
      setError(err.message);
      setSubmitState('idle', step1Label);
    });
  });
})();
