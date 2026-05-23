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
  reveal('.svc-ps-narrative', 'is-visible', { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  reveal('.svc-ps-card', 'is-visible', { threshold: 0.2, rootMargin: '0px 0px -40px 0px' });

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

  // ── A6: Closing Offer pricing-card plan selector ──────────────
  // Pricing cards are rendered as <button role="radio" data-plan="…">
  // siblings inside a [role="radiogroup"]. Clicking (or activating
  // via Enter/Space) toggles the selected card and writes the
  // active plan slug into the hidden #svcClosingPlan input that
  // sits inside the lead form below. Phase 2's backend reads that
  // slug to pick the right Stripe price ID.
  var planCards = document.querySelectorAll('.svc-closing-card[data-plan]');
  var planInput = document.getElementById('svcClosingPlan');
  if (planCards.length) {
    var selectPlanCard = function (card) {
      planCards.forEach(function (c) {
        c.classList.remove('svc-closing-card--selected');
        c.setAttribute('aria-checked', 'false');
        c.setAttribute('tabindex', '-1');
      });
      card.classList.add('svc-closing-card--selected');
      card.setAttribute('aria-checked', 'true');
      card.setAttribute('tabindex', '0');
      if (planInput) planInput.value = card.getAttribute('data-plan') || '';
    };
    planCards.forEach(function (card) {
      card.addEventListener('click', function () { selectPlanCard(card); });
      card.addEventListener('keydown', function (e) {
        // Arrow-key navigation inside the radiogroup (a11y).
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
          e.preventDefault();
          var next = card.nextElementSibling;
          while (next && !next.matches('.svc-closing-card[data-plan]')) next = next.nextElementSibling;
          if (next) { selectPlanCard(next); next.focus(); }
        } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
          e.preventDefault();
          var prev = card.previousElementSibling;
          while (prev && !prev.matches('.svc-closing-card[data-plan]')) prev = prev.previousElementSibling;
          if (prev) { selectPlanCard(prev); prev.focus(); }
        }
      });
    });
    // Initial selection — popular card if present, otherwise first.
    var initialCard = document.querySelector('.svc-closing-card--popular[data-plan]')
      || planCards[0];
    if (initialCard) selectPlanCard(initialCard);
  }
})();

/* ────────────────────────────────────────────────────────────────
 * Playbook checkout — services multi-select.
 *
 * Searchable multi-select dropdown that lives between the Website URL
 * field and the closer line of the Playbook checkout form. Users can
 * pick up to five services from a fixed healthcare list; the special
 * "Other — please specify" option reveals a text input so they can add
 * up to two custom entries within the same five-slot limit. Selected
 * items render as gold pill tags above the search input, each with an
 * × button that removes it. Selections are mirrored into a hidden
 * input (name="services", pipe-separated) so the form payload picks
 * them up alongside the standard lead fields.
 *
 * Mobile (≤640px): the dropdown panel transforms into a fixed bottom
 * sheet covering ~70vh, with a backdrop overlay that closes it on tap.
 * Desktop: the dropdown sits absolutely below the search input.
 *
 * Self-initialising: only attaches when the section's container is in
 * the DOM. No-op on Service pages that aren't the Playbook.
 * ──────────────────────────────────────────────────────────────── */
(function () {
  var container = document.querySelector('[data-services-multiselect]');
  if (!container) return;

  // Fixed option list. "Other — please specify" handled specially below.
  var OPTIONS = [
    'Travel Health & Vaccinations',
    'HPV Vaccination',
    'Flu Vaccination',
    'Shingles Vaccination',
    'Whooping Cough Vaccine',
    'Mpox Vaccination',
    'Weight Loss — Mounjaro & Wegovy',
    'Diabetes Management',
    'Thyroid & Metabolic Health',
    'Blood Testing',
    'Pregnancy Testing',
    'STI Testing',
    'Health MOT & Screening',
    'Ear Wax Removal',
    'B12 Injections',
    'Hair Loss Treatment',
    'Aesthetic Treatments — Botox & Fillers',
    'IV Drip Therapy',
    'Erectile Dysfunction',
    'Contraception',
    'Menopause & HRT',
    'Minor Ailment Service',
    'Smoking Cessation',
    'Mental Health & Anxiety',
    'Dermatology & Skin Conditions',
    'Podiatry & Foot Care',
  ];
  var OTHER_LABEL  = 'Other — please specify';
  var MAX_TOTAL    = 5;
  var MAX_CUSTOM   = 2;

  var pillsEl     = container.querySelector('[data-services-pills]');
  var searchEl    = container.querySelector('.svc-pb-services-search');
  var dropdownEl  = container.querySelector('[data-services-dropdown]');
  var customWrap  = container.querySelector('[data-services-custom]');
  var customInput = container.querySelector('[data-services-custom-input]');
  var customAdd   = container.querySelector('[data-services-custom-add]');
  var maxMsg      = container.querySelector('[data-services-max-msg]');
  var hiddenInput = container.querySelector('[data-services-value]');
  var backdrop    = container.querySelector('[data-services-sheet-close]');

  // selected = [{ label, custom }]  — `custom: true` for free-form entries
  var selected = [];

  function customCount() {
    var n = 0;
    for (var i = 0; i < selected.length; i++) if (selected[i].custom) n++;
    return n;
  }

  function isStockSelected(label) {
    for (var i = 0; i < selected.length; i++) {
      if (!selected[i].custom && selected[i].label === label) return true;
    }
    return false;
  }

  function syncHidden() {
    hiddenInput.value = selected.map(function (s) { return s.label; }).join('|');
  }

  function showMaxMsg() {
    maxMsg.hidden = false;
    clearTimeout(showMaxMsg._t);
    showMaxMsg._t = setTimeout(function () { maxMsg.hidden = true; }, 3500);
  }

  function renderPills() {
    pillsEl.innerHTML = '';
    selected.forEach(function (s, idx) {
      var pill = document.createElement('span');
      pill.className = 'svc-pb-services-pill';
      pill.setAttribute('role', 'listitem');

      var label = document.createElement('span');
      label.className = 'svc-pb-services-pill-label';
      label.textContent = s.label;
      pill.appendChild(label);

      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'svc-pb-services-pill-remove';
      btn.setAttribute('aria-label', 'Remove ' + s.label);
      btn.innerHTML = '&times;';
      btn.addEventListener('click', function () {
        selected.splice(idx, 1);
        renderPills();
        renderDropdown(searchEl.value);
        syncHidden();
        maxMsg.hidden = true;
      });
      pill.appendChild(btn);

      pillsEl.appendChild(pill);
    });
  }

  function renderDropdown(filterText) {
    var q = (filterText || '').trim().toLowerCase();
    var list = OPTIONS
      .filter(function (label) { return !isStockSelected(label); })
      .filter(function (label) { return !q || label.toLowerCase().indexOf(q) !== -1; });

    dropdownEl.innerHTML = '';

    if (!list.length && customCount() >= MAX_CUSTOM && q) {
      var empty = document.createElement('div');
      empty.className = 'svc-pb-services-dropdown-empty';
      empty.textContent = 'No matching services.';
      dropdownEl.appendChild(empty);
    }

    list.forEach(function (label) {
      var item = document.createElement('button');
      item.type = 'button';
      item.className = 'svc-pb-services-option';
      item.setAttribute('role', 'option');
      item.textContent = label;
      item.addEventListener('mousedown', function (e) { e.preventDefault(); });
      item.addEventListener('click', function () { addStock(label); });
      dropdownEl.appendChild(item);
    });

    // "Other — please specify" always at the bottom, until two custom
    // entries have been committed.
    if (customCount() < MAX_CUSTOM) {
      var other = document.createElement('button');
      other.type = 'button';
      other.className = 'svc-pb-services-option svc-pb-services-option--other';
      other.setAttribute('role', 'option');
      other.textContent = OTHER_LABEL;
      other.addEventListener('mousedown', function (e) { e.preventDefault(); });
      other.addEventListener('click', openCustomEntry);
      dropdownEl.appendChild(other);
    }
  }

  function addStock(label) {
    if (selected.length >= MAX_TOTAL) { showMaxMsg(); return; }
    selected.push({ label: label, custom: false });
    renderPills();
    syncHidden();
    searchEl.value = '';
    // Keep the dropdown open after a pick so the user can chain
    // selections without re-clicking the input — standard multi-select
    // UX pattern. Re-render with no filter so the just-picked option
    // disappears from the visible list immediately.
    renderDropdown('');
    searchEl.focus();
  }

  function openCustomEntry() {
    if (selected.length >= MAX_TOTAL) { showMaxMsg(); return; }
    if (customCount() >= MAX_CUSTOM) return;
    closeDropdown();
    customWrap.hidden = false;
    customInput.value = '';
    customInput.focus();
  }

  function commitCustom() {
    var value = (customInput.value || '').trim();
    if (!value) {
      customWrap.hidden = true;
      return;
    }
    if (selected.length >= MAX_TOTAL) { showMaxMsg(); return; }
    selected.push({ label: value, custom: true });
    renderPills();
    syncHidden();
    customInput.value = '';
    customWrap.hidden = true;
    searchEl.focus();
  }

  function openDropdown() {
    if (selected.length >= MAX_TOTAL && customCount() >= MAX_CUSTOM) {
      showMaxMsg();
      return;
    }
    dropdownEl.hidden = false;
    searchEl.setAttribute('aria-expanded', 'true');
    container.classList.add('is-open');
    if (backdrop) backdrop.hidden = false;
    renderDropdown(searchEl.value);
  }

  function closeDropdown() {
    dropdownEl.hidden = true;
    searchEl.setAttribute('aria-expanded', 'false');
    container.classList.remove('is-open');
    if (backdrop) backdrop.hidden = true;
  }

  // Events
  searchEl.addEventListener('focus', openDropdown);
  // Click in addition to focus — without this, clicking the search
  // input while it's already focused (e.g. immediately after picking
  // an option) wouldn't reopen the dropdown, because the focus event
  // only fires on focus transitions, not on every interaction.
  searchEl.addEventListener('click', openDropdown);
  searchEl.addEventListener('input', function () {
    if (dropdownEl.hidden) openDropdown();
    renderDropdown(searchEl.value);
  });
  searchEl.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeDropdown(); searchEl.blur(); }
  });
  document.addEventListener('click', function (e) {
    if (!container.contains(e.target)) closeDropdown();
  });
  if (backdrop) backdrop.addEventListener('click', closeDropdown);

  customAdd.addEventListener('click', commitCustom);
  customInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); commitCustom(); }
    if (e.key === 'Escape') { customWrap.hidden = true; searchEl.focus(); }
  });

  // Initial render
  renderPills();
  renderDropdown('');
  syncHidden();
})();
