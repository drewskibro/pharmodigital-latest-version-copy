/**
 * WebPro Elite — Waitlist form handler.
 *
 * Wires #svcWpeWaitlistForm to POST to /wp-json/gildhart/v1/wpe-waitlist.
 * On 200 ok the form card swaps to an inline success state read from
 * the form's data-success-title / data-success-body attributes. On
 * validation errors (400) the per-field messages light up; on
 * network / 5xx errors a generic message renders into #svcWpeFormError.
 *
 * The REST URL is provided via window.GildhartWpeWaitlist.restUrl,
 * localised from functions.php.
 */
( function () {
  'use strict';

  var cfg = window.GildhartWpeWaitlist;
  if ( ! cfg || ! cfg.restUrl ) {
    return;
  }

  var form = document.getElementById( 'svcWpeWaitlistForm' );
  if ( ! form ) {
    return;
  }

  var errorEl  = document.getElementById( 'svcWpeFormError' );
  var submitEl = form.querySelector( '.svc-wpe-closing-form-submit' );
  var cardEl   = form.closest( '.svc-wpe-closing-form-card' );

  function showError ( message ) {
    if ( ! errorEl ) return;
    errorEl.textContent = message;
    errorEl.hidden = false;
  }

  function clearError () {
    if ( ! errorEl ) return;
    errorEl.hidden = true;
    errorEl.textContent = '';
  }

  function clearFieldErrors () {
    form.querySelectorAll( '.svc-wpe-closing-form-input--error, .svc-wpe-closing-form-select--error' )
      .forEach( function ( el ) {
        el.classList.remove( 'svc-wpe-closing-form-input--error' );
        el.classList.remove( 'svc-wpe-closing-form-select--error' );
      } );
  }

  function markFieldErrors ( errors ) {
    Object.keys( errors ).forEach( function ( name ) {
      var field = form.querySelector( '[name="' + name + '"]' );
      if ( ! field ) return;
      field.classList.add(
        field.tagName === 'SELECT'
          ? 'svc-wpe-closing-form-select--error'
          : 'svc-wpe-closing-form-input--error'
      );
    } );
  }

  function setLoading ( on ) {
    if ( ! submitEl ) return;
    submitEl.disabled = on;
    submitEl.classList.toggle( 'is-loading', on );
  }

  function renderSuccess () {
    if ( ! cardEl ) return;
    var title = form.getAttribute( 'data-success-title' ) || "You're on the waitlist.";
    var body  = form.getAttribute( 'data-success-body' )  || "We'll be in touch within 24 hours.";

    var wrap = document.createElement( 'div' );
    wrap.className = 'svc-wpe-closing-form-success';
    wrap.setAttribute( 'role', 'status' );
    wrap.setAttribute( 'aria-live', 'polite' );

    var icon = document.createElement( 'div' );
    icon.className = 'svc-wpe-closing-form-success-icon';
    icon.setAttribute( 'aria-hidden', 'true' );
    icon.textContent = '✓';

    var h = document.createElement( 'p' );
    h.className = 'svc-wpe-closing-form-success-title';
    h.textContent = title;

    var p = document.createElement( 'p' );
    p.className = 'svc-wpe-closing-form-success-body';
    p.textContent = body;

    wrap.appendChild( icon );
    wrap.appendChild( h );
    wrap.appendChild( p );

    cardEl.innerHTML = '';
    cardEl.appendChild( wrap );
    cardEl.scrollIntoView( { behavior: 'smooth', block: 'center' } );
  }

  form.addEventListener( 'submit', function ( e ) {
    e.preventDefault();
    clearError();
    clearFieldErrors();
    setLoading( true );

    var data = new FormData( form );
    var payload = {};
    data.forEach( function ( value, key ) {
      payload[ key ] = value;
    } );
    payload.page_url = window.location.href;

    fetch( cfg.restUrl + 'wpe-waitlist', {
      method:  'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body:    JSON.stringify( payload ),
    } )
      .then( function ( res ) {
        return res.json().then( function ( body ) {
          return { status: res.status, body: body };
        } );
      } )
      .then( function ( result ) {
        setLoading( false );

        if ( result.body && result.body.ok ) {
          renderSuccess();
          return;
        }

        if ( result.body && result.body.errors ) {
          markFieldErrors( result.body.errors );
        }
        showError( ( result.body && result.body.error ) || 'Something went wrong. Please try again.' );
      } )
      .catch( function () {
        setLoading( false );
        showError( "We couldn't reach the server. Please check your connection and try again." );
      } );
  } );
} )();
