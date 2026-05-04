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

  // ── A1: Live Clients carousel ─────────────────────────────────
  // Native horizontal scroll on the track; arrow buttons + dots step
  // the scroll one card at a time. Active dot/disabled arrow updates
  // mirror the scroll position so dragging or trackpad scroll stays
  // in sync. Mobile collapses to a stacked column and CSS hides the
  // arrow nav, so the JS becomes a no-op there.
  var carouselTrack = document.getElementById('liveCarouselTrack');
  if (carouselTrack) {
    var carouselCards = carouselTrack.querySelectorAll('.svc-live-card');
    var carouselPrev  = document.getElementById('carouselPrev');
    var carouselNext  = document.getElementById('carouselNext');
    var carouselDots  = document.getElementById('carouselDots');

    if (carouselCards.length && carouselDots) {
      carouselCards.forEach(function (_, i) {
        var dot = document.createElement('button');
        dot.className = 'svc-carousel-dot';
        dot.type = 'button';
        dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        dot.addEventListener('click', function () { scrollToCard(i); });
        carouselDots.appendChild(dot);
      });
    }
    var carouselDotEls = carouselDots ? carouselDots.querySelectorAll('.svc-carousel-dot') : [];

    function getActiveIndex() {
      var trackLeft = carouselTrack.getBoundingClientRect().left;
      var bestIdx   = 0;
      var bestDist  = Infinity;
      carouselCards.forEach(function (card, i) {
        var dist = Math.abs(card.getBoundingClientRect().left - trackLeft);
        if (dist < bestDist) { bestDist = dist; bestIdx = i; }
      });
      return bestIdx;
    }
    function scrollToCard(i) {
      var card = carouselCards[i];
      if (!card) return;
      var trackLeft = carouselTrack.getBoundingClientRect().left;
      var offset    = card.getBoundingClientRect().left - trackLeft + carouselTrack.scrollLeft;
      // 32px back-padding so the card sits flush with the track padding edge.
      carouselTrack.scrollTo({ left: Math.max(0, offset - 32), behavior: 'smooth' });
    }
    function syncCarouselNav() {
      var idx = getActiveIndex();
      carouselDotEls.forEach(function (d, i) { d.classList.toggle('is-active', i === idx); });
      if (carouselPrev) carouselPrev.disabled = idx === 0;
      if (carouselNext) carouselNext.disabled = idx === carouselCards.length - 1;
    }
    if (carouselPrev) {
      carouselPrev.addEventListener('click', function () {
        scrollToCard(Math.max(0, getActiveIndex() - 1));
      });
    }
    if (carouselNext) {
      carouselNext.addEventListener('click', function () {
        scrollToCard(Math.min(carouselCards.length - 1, getActiveIndex() + 1));
      });
    }
    carouselTrack.addEventListener('scroll', syncCarouselNav, { passive: true });
    syncCarouselNav();
  }

  // ── A1: Screenshot lightbox ───────────────────────────────────
  // Any element with .svc-lightbox-trigger opens the shared overlay
  // (rendered inside section-live-clients.php). data-src + data-caption
  // attributes drive the displayed image; Escape or close button or
  // backdrop click dismiss.
  var lightbox        = document.getElementById('saLightbox');
  var lightboxImg     = document.getElementById('saLightboxImg');
  var lightboxCaption = document.getElementById('saLightboxCaption');
  var lightboxClose   = document.getElementById('saLightboxClose');
  if (lightbox && lightboxImg) {
    function openLightbox(src, alt, caption) {
      lightboxImg.src = src;
      lightboxImg.alt = alt || '';
      if (lightboxCaption) lightboxCaption.textContent = caption || '';
      lightbox.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
      lightbox.classList.remove('is-open');
      document.body.style.overflow = '';
      // Defer src clear so the close transition doesn't flash a blank image.
      setTimeout(function () { lightboxImg.src = ''; }, 350);
    }
    document.querySelectorAll('.svc-lightbox-trigger').forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        var src     = trigger.getAttribute('data-src');
        var caption = trigger.getAttribute('data-caption') || '';
        var img     = trigger.querySelector('img');
        var alt     = img ? img.alt : '';
        if (src) openLightbox(src, alt, caption);
      });
    });
    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
  }
  // ── A5: How It Works timeline reveal ──────────────────────────
  // The .svc-how-timeline track has a width-animated green fill. Add
  // .is-visible when the bar enters the viewport so the CSS
  // transition kicks in. One-shot reveal.
  reveal('.svc-how-timeline', 'is-visible', { threshold: 0.5 });

  // ── A2: SalesAgent Pro comparison-bar reveals ─────────────────
  // Each compare-fill bar has a data-fill-pct attribute. Once its
  // parent stat card scrolls into view, set the width to the real
  // percentage — the CSS transition (1.2s cubic-bezier) handles the
  // animation from 0. Reveal triggers once per bar; re-scrolling
  // doesn't re-animate.
  var compareBars = document.querySelectorAll('.svc-sa-pro-stat-compare-fill');
  if (compareBars.length && 'IntersectionObserver' in window) {
    var barObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var pct = entry.target.getAttribute('data-fill-pct');
          if (pct) entry.target.style.width = pct + '%';
          barObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });
    compareBars.forEach(function (bar) { barObserver.observe(bar); });
  } else if (compareBars.length) {
    // No IO support → render bars immediately at full width.
    compareBars.forEach(function (bar) {
      var pct = bar.getAttribute('data-fill-pct');
      if (pct) bar.style.width = pct + '%';
    });
  }
})();
