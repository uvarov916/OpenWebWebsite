/* =Main INIT Function
-------------------------------------------------------------- */
function initializeForm() {

	"use strict";

	var $window     = jQuery( window ),
		$wpadminbar = jQuery( '#wpadminbar' ),
		$body       = jQuery( 'body' ),
		$nav		= jQuery( 'body > nav > ul' );

	$nav
		.addClass( 'nav-content clearfix' )
		.find( '.current_page_item, .current-menu-item, .current-menu-parent, .current-menu-ancestor')
			.addClass( 'current-page' )
			.end()
		.children( 'li:first-child' )
			.addClass( 'first' )
			.end()
		.prepend( '<li id="magic-line"></li>' )
		.children( 'li' )
			.addClass( 'upper' )
			.end()
		.find( 'ul' )
			.addClass( 'drop-list' )
			.parent()
				.addClass( 'drop' )
				.children( 'a' )
					.addClass( 'drop-btn' )
					.end()
				.find( 'a > b' )
					.remove();

	//IE9 RECOGNITION
	if (jQuery.browser.msie && jQuery.browser.version == 9) {

		jQuery('html').addClass('ie9');
	}

	//NAVIGATION DETECT
	(function() {
		function navDetect(){

			var windowWidth = $window.width();
				
			if ( windowWidth > 1199 ) {
				jQuery('nav, header').removeClass('mobile');
				jQuery('nav, header').addClass('desktop');
			} else {
				jQuery('nav, header').removeClass('desktop');
				jQuery('nav, header').addClass('mobile');
			}
			
		}

		$window.on("resize", navDetect);
		jQuery(document).on("ready", navDetect);
	})();

	//NAVIGATION CUSTOM FUNCTION
	(function() {
		function navigationInit(){

			//MOBILE BUTTON
			jQuery('.nav-button').click(function() {
				if(jQuery('nav').is(":visible")) {
					jQuery('nav').slideUp();
					jQuery('.nav-button').removeClass('open');
				} 
				else {
					jQuery('nav').slideDown();
					jQuery('.nav-button').addClass('open');
				}
			});

			//DROPDOWNS
			jQuery('li.drop a.drop-btn').click(function() {
				jQuery('.drop-list').slideUp();
				jQuery('li.drop a.open').removeClass('open');

				if(jQuery(this).next('ul.drop-list').is(':visible')) {
					jQuery(this).next('ul.drop-list').slideUp();
					jQuery(this).removeClass('open');
				}

				else {
					jQuery(this).next('ul.drop-list').slideDown();
					jQuery(this).addClass('open');
				}

				return false;
				
			});

			//MAGIC LINE
			jQuery(function() {

			var $el, leftPos, newWidth,
				$mainNav     = jQuery(".nav-content"),
				$currentPage = jQuery(".current-page");

			var $magicLine = jQuery("#magic-line");

			if ( ! $magicLine.length || ! $currentPage.length ) {

				return;

			}

			$magicLine
				.width(jQuery("nav.desktop .current-page").width() - 35 + "px")
				.css("left", jQuery(".current-page").position().left)
				.data("origLeft", $magicLine.position().left)
				.data("origWidth", jQuery(".current-page").width());
				
			jQuery(".nav-content li.upper").hover(function() {
				$el = jQuery(this);
				leftPos = $el.position().left;
				newWidth = $el.width();
				$magicLine.stop().animate({
					left: leftPos,
					width: newWidth
				});
			}, function() {
				$magicLine.stop().animate({
					left: $magicLine.data("origLeft"),
					width: $magicLine.data("origWidth")
				});	
			});

				$window.scroll(function() {
					$magicLine.width(jQuery("nav.desktop .current-page").width() - 35 + "px").css("left", jQuery(".current-page").position().left); 
				});

			});

			//SEARCH TRIGGER
			jQuery('.search-trigger').click(function() {
				if(jQuery('.search-form').hasClass('disabled')) {
					jQuery(".search-form").fadeIn();
					jQuery('nav.desktop .nav-content').fadeOut();
					jQuery('.search-trigger').addClass('open');
					jQuery('.search-form').removeClass('disabled');
				} 
				else {
					jQuery(".search-form").fadeOut();
					jQuery('nav.desktop .nav-content').fadeIn();
					jQuery('.search-trigger').removeClass('open');
					jQuery('.search-trigger:before').fadeOut();
					jQuery('.search-form').addClass('disabled');
				}
			});

		}

		jQuery(document).on("ready", navigationInit);
	})();

	(function() {
		function navigationSticky(){
			var scrollTop = $window.scrollTop(),
				offsetTop = $wpadminbar.length ? 15 + $wpadminbar.height() : 15;

			if (scrollTop > 550 ) {   
				jQuery('nav, header').addClass('sticky');
				jQuery('.sticky-head').slideDown();
				jQuery('header.desktop.sticky, nav.desktop.sticky').stop().animate({
					top: offsetTop
				});
			} else {
				jQuery('header.desktop.sticky, nav.desktop.sticky').stop().animate({
					top: 0,},
					1, function() {
						jQuery('nav, header').removeClass('sticky');
						jQuery('.sticky-head').fadeOut('slow'); 
				}); 
			}
		
		}

		$window.on("scroll", navigationSticky);
		$window.on("resize", navigationSticky);
	})();

	//HERO DIMENSTION AND CENTER
	(function() {
		function heroInit(){

			var heroContent = jQuery('.hero-content'),
				contentHeight = heroContent.height(),
				parentHeight = jQuery('.hero').height(),
				topMargin = (parentHeight - contentHeight) / 2,
				heroContentSmall = jQuery('.hero.small .hero-content'),
				contentSmallHeight = heroContentSmall.height(),
				topMagrinSmall = (parentHeight - contentSmallHeight) / 2;

			heroContent.css({
				"margin-top" : topMargin+"px"
			});

			if ( $window.width() > 767 ) {

				heroContentSmall.css({
					"margin-top" : topMagrinSmall+ 75 + "px"
				});

			} else {

				heroContentSmall.css({
					"margin-top" : topMagrinSmall + 35 +  "px"
				});
			}
		}

		$window.on("resize load", heroInit);
		jQuery(document).on("ready", heroInit);
	})();

	//ANIMATIONS
	jQuery('.animated').appear();

	jQuery(document.body).on('appear', '.fade', function() {
		jQuery(this).each(function(){ jQuery(this).addClass('ae-animation-fade'); });
	});
	jQuery(document.body).on('appear', '.slide', function() {
		jQuery(this).each(function(){ jQuery(this).addClass('ae-animation-slide'); });
	});
	jQuery(document.body).on('appear', '.hatch', function() {
		jQuery(this).each(function(){ jQuery(this).addClass('ae-animation-hatch'); });
	});
	jQuery(document.body).on('appear', '.entrance', function() {
		jQuery(this).each(function(){ jQuery(this).addClass('ae-animation-entrance'); });
	});

	//PARALLAX EFFECTS
	jQuery('.parallax').each(function() {
		jQuery(this).parallax("50%", 0.1);
	});

	//TESTIMONIALS
	jQuery('.testimonials').bxSlider({
		touchEnabled: true,
		slideWidth: 1400,
		controls: false,
		pager: true,
		pagerSelector: ".testimonial-pager",
		adaptiveHeight: true
	});

	//RECENT WORK SLIDER
	jQuery(document).ready(function($) {
		var si = jQuery('#recent-gallery').royalSlider({
			addActiveClass: true,
			arrowsNav: false,
			controlNavigation: 'none',
			autoScaleSlider: true, 
			autoScaleSliderWidth: 1200,	 
			autoScaleSliderHeight: 475,
			loop: true,
			fadeinLoadedSlide: false,
			keyboardNavEnabled: true,
			globalCaptionInside: false,

			visibleNearby: {
			enabled: true,
			centerArea: 0.4,
			center: true,
			breakpoint: 1199,
			breakpointCenterArea: 0.6,
			navigateByCenterClick: true
		}
		
		}).data('royalSlider');
	});

	//HOVERS
	jQuery('.thumbnail a').hover(function() {
		jQuery(this).children('.projectinfo').fadeIn('fast', function(){
			jQuery(this).children('.meta').animate({
				bottom: 55 + "px"
			});
		});
	}, function() {
		jQuery(this).children('.projectinfo').fadeOut('fast', function(){
			jQuery(this).children('.meta').animate({
				bottom: - 55 + "px"
			}, 1);
		});
	});

	//TIMER
	jQuery('.timer').appear();
	jQuery(document.body).on('appear', '.timer', function() {
		jQuery(this).countTo();
	});

	jQuery(document.body).on('disappear', '.timer', function() {
		jQuery(this).removeClass('timer');
	});

	//VIDEO
	jQuery(function() {
		var videobackground = new jQuery.backgroundVideo(jQuery('.bgVideo'), {
			"align" : "centerXY",
			"path" : "video/",
			"width": 854,
			"height": 480,
			"filename" : "startup",
			"types" : ["mp4", "ogg"]
		});
	});

	//PORTFOLIO FILTER
	jQuery(function(){
		jQuery('.portfolio-block').each( function() {

			var $this = jQuery( this );

			jQuery( this ).mixitup({
				effects: ['fade','scale', 'rotateX'],
				easing: 'smooth',
				layoutMode: 'list',
				filterSelector: $this.find( '.filter' )
			});

		})
	});

	//PROJECT SLIDER
	jQuery('.project-slider').bxSlider({
		touchEnabled: true,
		nextSelector: ".project-next",
		prevSelector: ".project-prev",
		pager: true,
		pagerSelector: ".project-controls",
		adaptiveHeight: true,
		onSliderLoad: function () {
			BackgroundCheck.init({
				targets: '.bx-prev, .bx-next, .bx-pager-link',
				images: '.project-slider img'
			});
		},
		onSlideAfter: function () {
			BackgroundCheck.refresh();
		}
	});

	//GALLERY
	jQuery('.lightbox').iLightBox({
		skin: 'dark'
	});

	//CONTACT-FORM
	jQuery('#contact-open').click(function (e) {
		e.preventDefault();
		if ( jQuery('#contact-form').is(':hidden') ) {
			jQuery('#contact-form').slideDown();
			jQuery('html, body').delay(200).animate({ 
				scrollTop: jQuery('#contact-form').offset().top 
			}, 1000);
		} else {
			jQuery('#contact-form').slideUp();
		}
	});

	//RESPONSIVE VIDEO
	jQuery(".container, .vendor").fitVids();
	

}
/* END ------------------------------------------------------- */

/* =Document Ready Trigger
-------------------------------------------------------------- */
jQuery(document).ready(function(){

	initializeForm();

});
/* END ------------------------------------------------------- */