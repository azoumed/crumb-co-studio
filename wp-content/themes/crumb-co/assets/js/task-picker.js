/* Crumb & Co. home task picker: accessible tabs (WAI-ARIA tabs pattern), no dependencies.
 * Without this script each tab is a normal link to its product page. */
( function () {
	document.querySelectorAll( '[data-ccs-task-picker]' ).forEach( function ( root ) {
		var tabs = Array.prototype.slice.call( root.querySelectorAll( '[role="tab"]' ) );
		var rtl = document.documentElement.dir === 'rtl';

		function select( tab, focus ) {
			tabs.forEach( function ( t ) {
				var on = t === tab;
				var panel = document.getElementById( t.getAttribute( 'aria-controls' ) );
				t.setAttribute( 'aria-selected', on ? 'true' : 'false' );
				t.setAttribute( 'tabindex', on ? '0' : '-1' );
				if ( panel ) {
					panel.hidden = ! on;
					if ( on ) {
						panel.classList.remove( 'is-entering' );
						void panel.offsetWidth; // restart the row entrance
						panel.classList.add( 'is-entering' );
					}
				}
			} );
			if ( focus ) {
				tab.focus();
			}
		}

		tabs.forEach( function ( tab, i ) {
			tab.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				select( tab, false );
			} );
			tab.addEventListener( 'keydown', function ( e ) {
				var next = null;
				var fwd = rtl ? 'ArrowLeft' : 'ArrowRight';
				var back = rtl ? 'ArrowRight' : 'ArrowLeft';
				if ( e.key === fwd || e.key === 'ArrowDown' ) {
					next = tabs[ ( i + 1 ) % tabs.length ];
				} else if ( e.key === back || e.key === 'ArrowUp' ) {
					next = tabs[ ( i - 1 + tabs.length ) % tabs.length ];
				} else if ( e.key === 'Home' ) {
					next = tabs[ 0 ];
				} else if ( e.key === 'End' ) {
					next = tabs[ tabs.length - 1 ];
				} else if ( e.key === ' ' || e.key === 'Enter' ) {
					e.preventDefault();
					select( tab, false );
					return;
				}
				if ( next ) {
					e.preventDefault();
					select( next, true );
				}
			} );
		} );
	} );
} )();
