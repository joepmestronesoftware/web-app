/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	$(document).ready(function ($) {
        $('input[data-input-type]').on('input change', function () {
            var val = $(this).val();
            $(this).prev('.cs-range-value').html(val);
            $(this).val(val);
        });
    })
	
	
	
	/**
	 * Logo Width
	 */
	wp.customize( 'logo_width', function( value ) {
		value.bind( function( logo_width ) {
			jQuery( '.logo img' ).css( 'max-width', logo_width + 'px' );
		} );
	} );
	
	/**
	 * Breadcrumb
	 */
	wp.customize( 'breadcrumb_min_height', function( value ) {
		value.bind( function( breadcrumb_min_height ) {
			jQuery( '#breadcrumb-area' ).css( 'padding-top', breadcrumb_min_height + 'px' );
			jQuery( '#breadcrumb-area' ).css( 'padding-bottom', breadcrumb_min_height + 'px' );
		} );
	} );
	
	
	//header_phone_number
	wp.customize(
		'header_phone_number', function( value ) {
			value.bind(
				function( newval ) {
					$( '#header-top .tlh-phone' ).text( newval );
				}
			);
		}
	);
	//header_email
	wp.customize(
		'header_email', function( value ) {
			value.bind(
				function( newval ) {
					$( '#header-top .tlh-email' ).text( newval );
				}
			);
		}
	);
	//header_faq (Ask your Question)
	wp.customize(
		'header_faq', function( value ) {
			value.bind(
				function( newval ) {
					$( '#header-top .tlh-faq' ).text( newval );
				}
			);
		}
	);
	//header_get (header get button)
	wp.customize(
		'header_get', function( value ) {
			value.bind(
				function( newval ) {
					$( '#navigate .boxed-btn' ).text( newval );
				}
			);
		}
	);
	
	//info_title
	wp.customize(
		'info_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '#contact-info .info-first h5' ).text( newval );
				}
			);
		}
	);
	//info_description
	wp.customize(
		'info_description', function( value ) {
			value.bind(
				function( newval ) {
					$( '#contact-info .info-first p' ).text( newval );
				}
			);
		}
	);
	//info_title2
	wp.customize(
		'info_title2', function( value ) {
			value.bind(
				function( newval ) {
					$( '#contact-info .info-second h5' ).text( newval );
				}
			);
		}
	);
	//info_description2
	wp.customize(
		'info_description2', function( value ) {
			value.bind(
				function( newval ) {
					$( '#contact-info .info-second p' ).text( newval );
				}
			);
		}
	);
	//info_title3
	wp.customize(
		'info_title3', function( value ) {
			value.bind(
				function( newval ) {
					$( '#contact-info .info-third h5' ).text( newval );
				}
			);
		}
	);
	//info_description3
	wp.customize(
		'info_description3', function( value ) {
			value.bind(
				function( newval ) {
					$( '#contact-info .info-third p' ).text( newval );
				}
			);
		}
	);
	//service_title
	wp.customize(
		'service_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.home-service .section-title h2' ).text( newval );
				}
			);
		}
	);
	//service_description
	wp.customize(
		'service_description', function( value ) {
			value.bind(
				function( newval ) {
					$( '.home-service .section-title p' ).text( newval );
				}
			);
		}
	);
	//features_title
	wp.customize(
		'features_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.home-feature .section-title h2' ).text( newval );
				}
			);
		}
	);
	//features_description
	wp.customize(
		'features_description', function( value ) {
			value.bind(
				function( newval ) {
					$( '.home-feature .section-title p' ).text( newval );
				}
			);
		}
	);
	//call_to_action_title
	wp.customize(
		'call_to_action_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '#cta h3' ).text( newval );
				}
			); 
		}
	);
	//call_to_action_description
	wp.customize(
		'call_to_action_description', function( value ) {
			value.bind(
				function( newval ) {
					$( '#cta p' ).text( newval );
				}
			);
		}
	);
	//call_action_button_label
	wp.customize(
		'call_action_button_label', function( value ) {
			value.bind(
				function( newval ) {
					$( '#cta-btn .purchase-btn' ).text( newval );
				}
			);
		}
	);
	
	//blog_title
	wp.customize(
		'blog_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '#latest-news .section-title h2' ).text( newval );
				}
			); 
		}
	);
	//blog_description
	wp.customize(
		'blog_description', function( value ) {
			value.bind(
				function( newval ) {
					$( '#latest-news .section-title p' ).text( newval );
				}
			);
		}
	);
	//copyright_content
	wp.customize(
		'copyright_content', function( value ) {
			value.bind(
				function( newval ) {
					$( '#footer-copyright .copyright-text p' ).text( newval );
				}
			); 
		}
	);
	
} )( jQuery );
