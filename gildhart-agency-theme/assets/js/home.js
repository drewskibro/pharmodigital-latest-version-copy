/**
 * Gildhart Agency — Homepage scroll-trigger animations.
 *
 * Each section uses an IntersectionObserver to add a "visible" class when it
 * scrolls into view, which triggers staggered CSS reveal animations.
 *
 * Sections wired so far:
 *   - .featured-case-study  →  .fcs-visible
 *   - .split-section        →  .split-visible (also reveals the trailing .split-cta)
 *   - .shift-section        →  .shift-visible
 *
 * More sections (founder, revenue) are appended in B4-B5.
 */
(function () {
  'use strict';

  // Build a tiny helper for "add class when in view" observers.
  function reveal( selector, visibleClass, opts ) {
    var nodes = document.querySelectorAll( selector );
    if ( ! nodes.length ) {
      return;
    }

    if ( ! ( 'IntersectionObserver' in window ) ) {
      nodes.forEach( function ( el ) { el.classList.add( visibleClass ); } );
      return;
    }

    var observer = new IntersectionObserver( function ( entries ) {
      entries.forEach( function ( entry ) {
        if ( entry.isIntersecting ) {
          entry.target.classList.add( visibleClass );
          observer.unobserve( entry.target );
        }
      } );
    }, opts || { threshold: 0.15, rootMargin: '0px 0px -60px 0px' } );

    nodes.forEach( function ( el ) { observer.observe( el ); } );
  }

  reveal( '.featured-case-study', 'fcs-visible' );
  reveal( '.split-section',       'split-visible', { threshold: 0.12, rootMargin: '0px 0px -60px 0px' } );
  reveal( '.shift-section',       'shift-visible', { threshold: 0.08, rootMargin: '0px 0px -40px 0px' } );
  // Two-paths cards reveal individually (each card has its own .tp-visible)
  reveal( '.two-paths-card',      'tp-visible',    { threshold: 0.15, rootMargin: '0px 0px -60px 0px' } );

  // The CTA strip lives outside .split-section in the markup; piggy-back on
  // the same observer by adding .split-cta-visible at the same time.
  document.querySelectorAll( '.split-section' ).forEach( function ( section ) {
    if ( ! ( 'IntersectionObserver' in window ) ) {
      var siblingCta = section.parentElement && section.parentElement.querySelector( '.split-cta' );
      if ( siblingCta ) siblingCta.classList.add( 'split-cta-visible' );
      return;
    }
    var ctaObs = new IntersectionObserver( function ( entries ) {
      entries.forEach( function ( entry ) {
        if ( entry.isIntersecting ) {
          var cta = entry.target.parentElement && entry.target.parentElement.querySelector( '.split-cta' );
          if ( cta ) cta.classList.add( 'split-cta-visible' );
          ctaObs.unobserve( entry.target );
        }
      } );
    }, { threshold: 0.4, rootMargin: '0px 0px -40px 0px' } );
    ctaObs.observe( section );
  } );
} )();
