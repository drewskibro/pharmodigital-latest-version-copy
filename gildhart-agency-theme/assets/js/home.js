/**
 * Gildhart Agency — Homepage scroll-trigger animations.
 *
 * Each section uses an IntersectionObserver to add a "visible" class when it
 * scrolls into view, which triggers staggered CSS reveal animations.
 *
 * Sections wired so far:
 *   - .featured-case-study  →  .fcs-visible
 *
 * More sections (split, shift, founder, revenue) are appended in B3-B5.
 */
(function () {
  'use strict';

  if ( ! ( 'IntersectionObserver' in window ) ) {
    // No-op fallback: ensure sections are visible.
    document.querySelectorAll( '.featured-case-study' ).forEach( function ( el ) {
      el.classList.add( 'fcs-visible' );
    } );
    return;
  }

  // Featured Case Study
  document.querySelectorAll( '.featured-case-study' ).forEach( function ( section ) {
    var observer = new IntersectionObserver( function ( entries ) {
      entries.forEach( function ( entry ) {
        if ( entry.isIntersecting ) {
          entry.target.classList.add( 'fcs-visible' );
          observer.unobserve( entry.target );
        }
      } );
    }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' } );
    observer.observe( section );
  } );
} )();
