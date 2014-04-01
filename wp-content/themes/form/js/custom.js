(function($){
	'use strict';
	/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */
	/*jshint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false, validthis: true */
	/*global jQuery */

	$(function(){

		var $window = $( window ),
			$body   = $( 'body' ),
			$nav    = $( 'body > nav > ul' ),
			isMobile = $( 'html.mobile' ).length;

		// contact form
		if ( $( '.peThemeContactForm' ).length > 0 ) {

			$( '.peThemeContactForm' ).peThemeContactForm();

		}

		// comments markup fix
		$( '.row-fluid' ).addClass( 'row' );

		var $comments_wrap = $( '#comments' );

		if ( $comments_wrap.length ) {

			$comments_wrap.find( '.span1' ).addClass( 'col-md-1' ).removeClass( 'span1' );
			$comments_wrap.find( '.span11' ).addClass( 'col-md-11' ).removeClass( 'span11' );
			$comments_wrap.find( '.span12' ).addClass( 'col-md-12' ).removeClass( 'span12' );
			$comments_wrap.find( '.row-fluid' ).addClass( 'row' ).removeClass( 'row-fluid' );
			$comments_wrap.find( '.pe-offset1' ).addClass( 'col-md-offset-1' ).removeClass( 'pe-offset1' );
			$comments_wrap.find( '.comment-meta' ).wrapInner( '<h6></h6>' );

		}
		
		$('.sidebar > .widget:first').addClass('clearfix');
		$('.sidebar > .widget').find('h3').replaceWith(function () {
			return '<h5>'+$(this).html()+'</h5>';
		}).end().each(function () {
			this.className = this.className.replace(/_/g,'-');
		});

		// video bg
		var $videoBg = $( '.ytVideo' );

		if ( $videoBg.length && ! isMobile ) {

			$videoBg.each( function() {

				var $this   = $( this ),
					video   = $this.data( 'video' ),
					$parent = $this.parent();

				$this.mb_YTPlayer({
					videoURL     : video,
					quality      : 'highres',
					mute         : true,
					containment  :$parent,
					showControls : false,
					onReady      : function() {
						setTimeout( function() {
							$parent.animate( 'background', 'none' );
						}, 1000 );
					}

				});

			});

		}

	});

	var $gmap = $( '.gmap' );

	function gmapInitialize() {

		if ( $gmap.length ) {

			$gmap.each( function() {

				var $this = $( this ),
					latitude = $this.data( 'latitude' ),
					longitude = $this.data( 'longitude' ),
					zoom = $this.data( 'zoom' );

				var myLatlng = new google.maps.LatLng(latitude,longitude);
				var mapOptions = {
				zoom: zoom,
				scrollwheel: false,
				center: myLatlng,
				styles: [{"stylers":[{"hue": "#2db4d8", "lightness" : 100}]}]
				};
				var map = new google.maps.Map($this[0], mapOptions);

				var marker = new google.maps.Marker({
					position: myLatlng,
					map: map,
					title: 'Form'
				});

			});

		}

	}

	google.maps.event.addDomListener(window, 'load', gmapInitialize);
	google.maps.event.addDomListener(window, 'resize', gmapInitialize);

})(jQuery);