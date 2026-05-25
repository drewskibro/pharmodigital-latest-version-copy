/**
 * Gildhart — Playbook checkout flow.
 *
 * Two-step inline one-time checkout using Stripe's Payment Element.
 * No popups, no Checkout Session redirects — payment confirms in-place
 * on /the-playbook and Stripe redirects to the thank-you page only
 * after confirmation succeeds.
 *
 * Mirrors the agent closing-checkout.js flow, but the Playbook is a
 * single £995 charge (a PaymentIntent), not a subscription. There is
 * no plan toggle, and the form carries an extra `services` field
 * (pipe-separated, from the multi-select) which is posted to the
 * backend for the Make → Kartra hand-off.
 *
 * Step 1 (initiate): user fills lead fields → submit → JS POSTs to
 *   /wp-json/gildhart/v1/playbook-checkout → backend creates a
 *   Customer + PaymentIntent → returns client_secret + publishable_key
 *   + amount_formatted. JS initialises Stripe.js, mounts a Payment
 *   Element into #svcPbPaymentMount, locks the lead fields, and updates
 *   the submit button to "Pay £995".
 *
 * Step 2 (confirm): user enters card details → submit →
 *   stripe.confirmPayment() with return_url pointing at
 *   GildhartPlaybookCheckout.thankYouUrl. On success Stripe redirects
 *   there with payment_intent in the query string.
 *
 * Localised globals from PHP (see functions.php):
 *   GildhartPlaybookCheckout.restUrl     — .../wp-json/gildhart/v1/
 *   GildhartPlaybookCheckout.thankYouUrl — .../playbook-thank-you/
 */
(function () {
  'use strict';

  if (typeof Stripe === 'undefined' || typeof GildhartPlaybookCheckout === 'undefined') {
    return;
  }

  var form           = document.getElementById('svcPbCheckoutForm');
  var submitBtn      = form && form.querySelector('.svc-closing-form-submit');
  var paymentMount   = document.getElementById('svcPbPaymentMount');
  var paymentSection = document.getElementById('svcPbPaymentSection');
  var errorBanner    = document.getElementById('svcPbFormError');

  if (!form || !submitBtn || !paymentMount) return;

  // Step 1 state — null until /playbook-checkout has succeeded. Once a
  // client_secret has been issued the form transitions to step 2 and the
  // submit handler routes to confirmPayment instead of initiateCheckout.
  var stripe       = null;
  var elements     = null;
  var paymentEl    = null;
  var clientSecret = null;
  // Set true once the Payment Element fires its 'ready' event. Guards
  // against calling stripe.confirmPayment() before the element is
  // mounted/ready — the cause of the "elements should have a mounted
  // Payment Element" error if a user submits a beat too early.
  var paymentReady = false;

  // The ACF-driven label is already "Continue to Payment"; capture it so
  // retries after a card decline restore the right text.
  var step1Label = (submitBtn.textContent || 'Continue to Payment').replace(/\s*→\s*$/, '').trim() || 'Continue to Payment';

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

  // ── Form data ─────────────────────────────────────────────────
  function readForm() {
    var data = {};
    Array.prototype.forEach.call(form.elements, function (el) {
      if (!el.name) return;
      data[el.name] = (el.value || '').trim();
    });
    return data;
  }

  function validateLead(data) {
    var required = ['practice', 'first_name', 'last_name', 'email'];
    for (var i = 0; i < required.length; i++) {
      if (!data[required[i]]) {
        return 'Please fill in all required fields before continuing.';
      }
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
      return 'Please enter a valid email address.';
    }
    return null;
  }

  // ── Step 1: create the PaymentIntent, mount Payment Element ───
  function initiateCheckout(leadData) {
    setSubmitState('busy', 'Securing your access');

    return fetch(GildhartPlaybookCheckout.restUrl + 'playbook-checkout', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        first_name:    leadData.first_name,
        last_name:     leadData.last_name,
        email:         leadData.email,
        practice_name: leadData.practice,
        website:       leadData.website || '',
        services:      leadData.services || ''
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
            colorPrimary:    '#1E3D2F',
            colorBackground: '#ffffff',
            colorText:       '#0f172a',
            colorDanger:     '#b91c1c',
            fontFamily:      'Inter, system-ui, -apple-system, sans-serif',
            spacingUnit:     '4px',
            borderRadius:    '10px'
          },
          rules: {
            '.Input': { borderColor: 'rgba(15, 23, 42, 0.18)' },
            '.Label': { fontWeight: '600', color: '#0f172a' }
          }
        }
      });
      paymentEl = elements.create('payment', { layout: 'tabs' });

      // Track readiness — confirmPayment is blocked until this fires.
      paymentReady = false;
      paymentEl.on('ready', function () { paymentReady = true; });

      // Reveal the Card Payment section (hidden in the markup until
      // Step 1 succeeds) THEN mount — mounting into a hidden parent can
      // produce a zero-height iframe in some browsers.
      if (paymentSection) paymentSection.hidden = false;
      paymentEl.mount(paymentMount);

      lockLeadFields();
      setSubmitState('idle', 'Pay ' + (data.amount_formatted || ''));
      setError(null);

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
        return_url: GildhartPlaybookCheckout.thankYouUrl
      }
    }).then(function (result) {
      // confirmPayment only returns a result here on synchronous error.
      // On success the browser is already navigating to return_url.
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
      submitBtn.dataset.payLabel = submitBtn.textContent.replace(/\s*→\s*$/, '').trim();
    }).catch(function (err) {
      setError(err.message);
      setSubmitState('idle', step1Label);
    });
  });
})();
