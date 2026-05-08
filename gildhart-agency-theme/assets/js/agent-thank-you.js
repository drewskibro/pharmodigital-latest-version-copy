/**
 * Gildhart — Agent Thank-You page personalisation.
 *
 * Reads ?payment_intent=… from the redirect URL, calls the WP REST
 * endpoint /wp-json/gildhart/v1/payment-intent?id=…, and replaces any
 * [data-personalise="email"] / [data-personalise="plan_label"] node
 * with the customer's actual email + plan name from the PaymentIntent
 * metadata we wrote during checkout.
 *
 * Behaviour is intentionally fail-soft:
 *   - Direct visit (no payment_intent in URL) → page reads with the
 *     static fallback copy ("your inbox", "Your subscription")
 *   - API call fails / network down → silent fallback to static copy
 *   - PaymentIntent status != 'succeeded' → silent fallback
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

  var paymentIntentId = getQueryParam('payment_intent');
  var redirectStatus  = getQueryParam('redirect_status');

  // Bail silently if there's nothing to look up. The static fallback
  // copy in the template handles direct visits gracefully.
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
    paint('email',      data.email);
    paint('plan_label', data.plan_label);
  }).catch(function () {
    // Silent — the page already reads naturally with the fallback copy.
  });
})();
