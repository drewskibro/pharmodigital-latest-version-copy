/**
 * Gildhart Service — page-level scroll-trigger wiring.
 *
 * Exposes window.svcReveal(selector, visibleClass, opts) for section-specific
 * IntersectionObserver hooks. Each section in S1+ wires its own reveal
 * triggers (e.g. svcReveal('.svc-method-step', 'svc-method-visible')).
 *
 * Falls back to immediately adding the visible class when IntersectionObserver
 * is unsupported, so no animations does not equal no content.
 */
(function () {
  'use strict';

  function reveal(selector, visibleClass, opts) {
    var nodes = document.querySelectorAll(selector);
    if (!nodes.length) {
      return;
    }

    if (!('IntersectionObserver' in window)) {
      nodes.forEach(function (el) { el.classList.add(visibleClass); });
      return;
    }

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add(visibleClass);
          observer.unobserve(entry.target);
        }
      });
    }, opts || { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

    nodes.forEach(function (el) { observer.observe(el); });
  }

  window.svcReveal = reveal;
})();
