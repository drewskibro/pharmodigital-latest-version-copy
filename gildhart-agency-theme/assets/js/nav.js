/**
 * Gildhart Agency — Navigation behaviour.
 *
 * - Mobile hamburger toggle (overlay drawer + body scroll lock)
 * - Mobile accordion sections (single-open behaviour)
 * - Desktop dropdown hover hand-off (force-close when leaving)
 * - Shrink-on-scroll: adds .nav-scrolled to the nav past 80px
 * - Escape key closes mobile menu
 */
(function () {
  'use strict';

  // ── Mobile hamburger ──────────────────────────────────────────
  var hamburger = document.querySelector('.nav-hamburger');
  var overlay   = document.getElementById('mobileNavOverlay');
  var navEl     = document.querySelector('.nav');
  var isOpen    = false;

  function openMenu() {
    isOpen = true;
    if (overlay) overlay.classList.add('mobile-open');
    if (hamburger) {
      hamburger.classList.add('nav-open');
      hamburger.setAttribute('aria-label', 'Close navigation menu');
      hamburger.setAttribute('aria-expanded', 'true');
    }
    if (navEl) navEl.classList.add('nav-border-hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    isOpen = false;
    if (overlay) overlay.classList.remove('mobile-open');
    if (hamburger) {
      hamburger.classList.remove('nav-open');
      hamburger.setAttribute('aria-label', 'Open navigation menu');
      hamburger.setAttribute('aria-expanded', 'false');
    }
    if (navEl) navEl.classList.remove('nav-border-hidden');
    document.body.style.overflow = '';

    if (overlay) {
      overlay.querySelectorAll('.mobile-dd-panel').forEach(function (p) {
        p.style.maxHeight = '0px';
        p.style.opacity = '0';
      });
      overlay.querySelectorAll('.mobile-dd-arrow').forEach(function (a) {
        a.style.transform = 'rotate(0deg)';
      });
    }
  }

  if (hamburger && overlay) {
    hamburger.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      isOpen ? closeMenu() : openMenu();
    });

    overlay.addEventListener('click', function (e) {
      if (e.target.closest('a')) closeMenu();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && isOpen) closeMenu();
    });

    // ── Mobile accordion ──
    var triggers = overlay.querySelectorAll('[data-accordion]');
    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var panel = this.nextElementSibling;
        var arrow = this.querySelector('.mobile-dd-arrow');
        if (!panel || !panel.classList.contains('mobile-dd-panel')) return;

        var isExpanded = parseInt(panel.style.maxHeight, 10) > 0;

        triggers.forEach(function (other) {
          if (other === trigger) return;
          var otherPanel = other.nextElementSibling;
          var otherArrow = other.querySelector('.mobile-dd-arrow');
          if (otherPanel && otherPanel.classList.contains('mobile-dd-panel')) {
            otherPanel.style.maxHeight = '0px';
            otherPanel.style.opacity = '0';
            if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
          }
        });

        if (isExpanded) {
          panel.style.maxHeight = '0px';
          panel.style.opacity = '0';
          if (arrow) arrow.style.transform = 'rotate(0deg)';
        } else {
          panel.style.maxHeight = panel.scrollHeight + 'px';
          panel.style.opacity = '1';
          if (arrow) arrow.style.transform = 'rotate(180deg)';
        }
      });
    });
  }

  // ── Desktop dropdown hand-off ─────────────────────────────────
  var dropdowns  = document.querySelectorAll('.nav-links .nav-dropdown, .nav-links-right .nav-dropdown');
  var plainLinks = document.querySelectorAll('.nav-links > a:not(.nav-dropdown), .nav-links-right > a:not(.nav-dropdown)');

  function closeAll() {
    dropdowns.forEach(function (dd) { dd.classList.add('dd-force-closed'); });
  }

  plainLinks.forEach(function (link) {
    link.addEventListener('mouseenter', closeAll);
    link.addEventListener('pointerenter', closeAll);
  });

  dropdowns.forEach(function (dd) {
    var trigger = dd.querySelector('.nav-dropdown-trigger');
    if (trigger) {
      trigger.addEventListener('mouseleave', function () {
        setTimeout(function () {
          var menu = dd.querySelector('.nav-dropdown-menu');
          if (menu && !menu.matches(':hover') && !dd.matches(':hover')) {
            dd.classList.add('dd-force-closed');
          }
        }, 80);
      });
    }
    dd.addEventListener('mouseenter', function () {
      dd.classList.remove('dd-force-closed');
    });
  });

  // ── Shrink-on-scroll ──────────────────────────────────────────
  var scrolled = false;
  function onScroll() {
    if (!navEl) return;
    var shouldScroll = window.scrollY > 80;
    if (shouldScroll && !scrolled) {
      navEl.classList.add('nav-scrolled');
      scrolled = true;
    } else if (!shouldScroll && scrolled) {
      navEl.classList.remove('nav-scrolled');
      scrolled = false;
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // ── Update nav-spacer height to match nav (so fixed nav doesn't overlap content)
  // Also expose nav height as --nav-h on the document root so hero sections can
  // extend their gradient up under the nav (the spacer is hidden on hero pages
  // — the hero's own padding-top covers the offset using --nav-h).
  var spacer = document.getElementById('navSpacer');
  function syncSpacer() {
    if (!navEl) return;
    var h = navEl.offsetHeight;
    if (spacer) {
      spacer.style.height = h + 'px';
    }
    document.documentElement.style.setProperty('--nav-h', h + 'px');
  }
  window.addEventListener('load', syncSpacer);
  window.addEventListener('resize', syncSpacer);
  syncSpacer();
})();
