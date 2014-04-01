jQuery( window ).load( function() {

	var showWhenAlternate = jQuery( '#pe_theme_meta_hero__title_, #pe_theme_meta_hero__subtitle_, #pe_theme_meta_hero__button_url_, #pe_theme_meta_hero__button_text_, #pe_theme_meta_hero__button_new_window__buttonset' ).closest( '.option' );

	if ( jQuery( 'label[for="pe_theme_meta_hero__alternate__0"]' ).hasClass( 'ui-state-active') ) { // image home

		showWhenAlternate.fadeIn(0);

	} else if ( jQuery( 'label[for="pe_theme_meta_hero__alternate__1"]' ).hasClass( 'ui-state-active') ) { // gallery homr

		showWhenAlternate.fadeOut(0);

	}

	jQuery( 'label[for="pe_theme_meta_hero__alternate__0"], label[for="pe_theme_meta_hero__alternate__1"]' ).on( 'click', function(e) {

		if ( jQuery( 'label[for="pe_theme_meta_hero__alternate__0"]' ).hasClass( 'ui-state-active') ) { // image home

			showWhenAlternate.fadeIn(0);

		} else if ( jQuery( 'label[for="pe_theme_meta_hero__alternate__1"]' ).hasClass( 'ui-state-active') ) { // gallery homr

			showWhenAlternate.fadeOut(0);

		}

	});

});