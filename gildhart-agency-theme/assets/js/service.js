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

  // ── S1: Problem Shift + Three Proof Cases reveals ──────────────
  // Headline / intro fade up as the section enters; rows have their own
  // staggered transition (the wrapper class triggers child opacity/transform).
  reveal('.svc-ps-label, .svc-ps-headline, .svc-ps-intro', 'is-visible');
  reveal('.svc-ps-row', 'is-visible', { threshold: 0.2, rootMargin: '0px 0px -40px 0px' });

  // ── S2: Method — reveal each step + sync active state ─────────
  // The first step is rendered .is-active by PHP. As the user scrolls,
  // whichever step's circle is closest to the top of the viewport (below
  // the nav) takes over .is-active, and the matching timeline block
  // mirrors it via data-week-block.
  reveal('.svc-method-step', 'is-visible', { threshold: 0.25 });

  var steps = document.querySelectorAll('.svc-method-step');
  var weekBlocks = document.querySelectorAll('.svc-method-week');
  if (steps.length && 'IntersectionObserver' in window) {
    function setActive(stepEl) {
      steps.forEach(function (s) { s.classList.remove('is-active'); });
      stepEl.classList.add('is-active');
      var wbIdx = stepEl.getAttribute('data-week-block');
      weekBlocks.forEach(function (wb) {
        wb.classList.toggle('is-active', wb.getAttribute('data-week') === wbIdx);
      });
    }

    // Find the step whose top is closest to (just past) the nav bottom.
    function syncActive() {
      var navOffset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--nav-h'), 10) || 130;
      var anchor = navOffset + 120;
      var current = steps[0];
      steps.forEach(function (s) {
        var rect = s.getBoundingClientRect();
        if (rect.top <= anchor) {
          current = s;
        }
      });
      if (current && !current.classList.contains('is-active')) {
        setActive(current);
      }
    }
    window.addEventListener('scroll', syncActive, { passive: true });
    syncActive();

    // Clicking a week-block jumps to the first step in that block.
    weekBlocks.forEach(function (wb) {
      wb.addEventListener('click', function () {
        var wbIdx = wb.getAttribute('data-week');
        var match;
        steps.forEach(function (s) {
          if (!match && s.getAttribute('data-week-block') === wbIdx) {
            match = s;
          }
        });
        if (match) {
          var navOffset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--nav-h'), 10) || 130;
          var top = match.getBoundingClientRect().top + window.pageYOffset - navOffset - 24;
          window.scrollTo({ top: top, behavior: 'smooth' });
        }
      });
    });
  }

  // ── S5: FAQ accordion ─────────────────────────────────────────
  // One-at-a-time toggle: clicking a question opens its answer and
  // closes any other open item. aria-expanded mirrors .is-open so
  // screen readers stay in sync.
  var faqItems = document.querySelectorAll('.svc-faq-item');
  faqItems.forEach(function (item) {
    var btn = item.querySelector('.svc-faq-question');
    if (!btn) return;
    btn.addEventListener('click', function () {
      var willOpen = !item.classList.contains('is-open');
      faqItems.forEach(function (other) {
        other.classList.remove('is-open');
        var otherBtn = other.querySelector('.svc-faq-question');
        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
      });
      if (willOpen) {
        item.classList.add('is-open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });
})();
