/* Crumb & Co. — mobile navigation toggle (no dependencies). */
( function () {
	document.querySelectorAll( '.ccs-nav' ).forEach( function ( nav ) {
		var btn = nav.querySelector( '.ccs-nav__toggle' );
		if ( ! btn ) {
			return;
		}
		function close() {
			btn.setAttribute( 'aria-expanded', 'false' );
			nav.classList.remove( 'is-open' );
		}
		btn.addEventListener( 'click', function () {
			var open = btn.getAttribute( 'aria-expanded' ) === 'true';
			btn.setAttribute( 'aria-expanded', open ? 'false' : 'true' );
			nav.classList.toggle( 'is-open', ! open );
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
				close();
				btn.focus();
			}
		} );
	} );
} )();

/* Shop filters toggle on small screens. */
( function () {
	document.querySelectorAll( '.ccs-filters' ).forEach( function ( box ) {
		var btn = box.querySelector( '.ccs-filters__toggle' );
		if ( btn ) {
			btn.addEventListener( 'click', function () {
				var open = btn.getAttribute( 'aria-expanded' ) === 'true';
				btn.setAttribute( 'aria-expanded', open ? 'false' : 'true' );
				box.classList.toggle( 'is-open', ! open );
			} );
		}
	} );
} )();
