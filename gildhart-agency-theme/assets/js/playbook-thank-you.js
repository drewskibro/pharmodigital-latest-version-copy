/**
 * Gildhart — Playbook Thank-You page personalisation.
 *
 * Reads ?payment_intent=… from the redirect URL, calls the WP REST
 * endpoint /wp-json/gildhart/v1/payment-intent?id=…, and personalises
 * the hero with the customer's real data from Stripe:
 *
 *   [data-personalise="email"]            → customer email
 *   [data-personalise="plan_label"]       → "The AI Search Playbook"
 *   [data-personalise="amount_formatted"] → "£995"
 *   [data-personalise="title"]            → headline gets first-name swap
 *                                           "You're in." → "You're in, Drew."
 *
 * Same generic, fail-soft behaviour as the agent thank-you script:
 *   - Direct visit (no payment_intent) → static fallback copy
 *   - API call fails / network down → silent fallback
 *   - PaymentIntent status != 'succeeded' → silent fallback
 *   - Any one field missing → that field stays at its fallback, others
 *     still personalise (no all-or-nothing)
 *
 * Localised globals from PHP (see functions.php):
 *   GildhartThankYou.restUrl — e.g. https://site.com/wp-json/gildhart/v1/
 */
(function () {
  'use strict';

  if (typeof GildhartThankYou === 'undefined') return;

  function getQueryParam(name) {
    var match = window.location.search.match(new RegExp('[?&]' + name + '=([^&]+)'));
    return match ? decodeURIComponent(match[1]) : null;
  }

  function paint(field, value) {
    if (!value) return;
    var nodes = document.querySelectorAll('[data-personalise="' + field + '"]');
    Array.prototype.forEach.call(nodes, function (node) {
      node.textContent = value;
    });
  }

  // Headline first-name swap. Inserts ", FirstName" before the trailing
  // period (or appends if there's none). Keeps the static fallback
  // intact when first_name is empty.
  function personaliseTitle(firstName) {
    if (!firstName) return;
    var titleEl = document.querySelector('[data-personalise="title"]');
    if (!titleEl) return;
    var current = (titleEl.textContent || '').trim();
    if (!current) return;
    var personalised;
    if (current.charAt(current.length - 1) === '.') {
      personalised = current.slice(0, -1) + ', ' + firstName + '.';
    } else {
      personalised = current + ', ' + firstName;
    }
    titleEl.textContent = personalised;
  }

  var paymentIntentId = getQueryParam('payment_intent');
  var redirectStatus  = getQueryParam('redirect_status');

  if (!paymentIntentId) return;
  if (redirectStatus && redirectStatus !== 'succeeded') return;

  fetch(GildhartThankYou.restUrl + 'payment-intent?id=' + encodeURIComponent(paymentIntentId), {
    method: 'GET',
    headers: { 'Accept': 'application/json' }
  }).then(function (res) {
    if (!res.ok) throw new Error('Lookup failed (' + res.status + ').');
    return res.json();
  }).then(function (data) {
    if (!data || data.status !== 'succeeded') return;
    paint('email',            data.email);
    paint('plan_label',       data.plan_label);
    paint('amount_formatted', data.amount_formatted);
    personaliseTitle(data.first_name);
  }).catch(function () {
    // Silent — the page reads naturally with the fallback copy.
  });
})();
