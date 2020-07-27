(function ($) {
    "use strict";

    $(function () { // start: document ready

        /**
         *  Set Global Vars
         */
        certy.initGlobalVars();

        /**
         *  Navigation
         */
        if (certy.vars.body.hasClass('crt-nav-on')) { // Check If Nav Exists
            // Scrolled Navigation ( large screens )
            if ( Modernizr.mq('(min-width: '+certy.vars.screenMd+')') && certy.nav.height !== 'auto' ) {
                certy.nav.initScroll( $('#crtNavScroll') );
            }

            // Sticky Navigation
            certy.nav.makeSticky();

            // Navigation Tooltips
            if(certy.nav.tooltip.active){
                $('#crtNav a').hover(function () {
                    certy.nav.tooltip.show( $(this) );
                },function () {
                    certy.nav.tooltip.hide();
                });
            };

            // Anchor Navigation
            $('#crtNav').onePageNav({
                changeHash: true,
                scrollThreshold: 0.5,
                filter: ':not(.external)'
            });
        }

        /**
         *  Fixed Side Box
         */
        certy.sideBox.makeSticky();

        /** Portfolio */
        var pf_grid = $('.pf-grid');

        // check if grid exists than do action
        if (pf_grid.length > 0) {

            // init portfolio grid
            for (var i = 0; i < pf_grid.length; i++) {
                certy.portfolio.initGrid( $(pf_grid[i]) );
            }

            // open portfolio popup
            $(document).on('click', '.pf-project', function() {
                var id = $(this).attr('href');

                certy.portfolio.openPopup( $(id) );

                return false;
            });

            $(document).on('click', '.pf-rel-href', function() {
                var href = $(this).attr('href');

                // if contain anchor, open project popup
                if( href.indexOf("#") != -1 ) {
                    // close already opened popup
                    certy.portfolio.closePopup();

                    // open new one after timeout
                    setTimeout(function(){
                        certy.portfolio.openPopup( $(href) );
                    }, 500);

                    return false;
                }
            });
			
			$(document).on('click', '#pf-popup-close', function() {				
                certy.portfolio.closePopup();
			});

            // close portfolio popup
            $(document).on('touchstart click', '.crt-pf-popup-opened #pf-popup-wrap', function (e) {
                var container = $('#pf-popup-content');

                // if the target of the click isn't the container... nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    certy.portfolio.closePopup();
                }
            });
        }

        /** Components */
        // init sliders
        certy.slider( $(".cr-slider") );

        // init carousel
        certy.carousel( $(".cr-carousel") );
		
		/** Window Scroll Top Button */
        var $btnScrollTop = $('#crtBtnUp');
		
		if($btnScrollTop.length > 0) {
            if ($(window).scrollTop() > 100) {
                $btnScrollTop.show(0);
            } else {
                $btnScrollTop.hide(0);
            }

			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					$btnScrollTop.show(0);
				} else {
					$btnScrollTop.hide(0);
				}
			});

			$btnScrollTop.on('click', function () {
				$('html, body').animate({scrollTop: 0}, 800);
				return false;
			});
		}
    }); // end: document ready



    $(window).on('resize', function () { // start: window resize

        // Re Init Vars
        certy.vars.windowW = $(window).width();
        certy.vars.windowH = $(window).height();
        certy.vars.windowScrollTop = $(window).scrollTop();

        // Sticky Navigation
        certy.nav.makeSticky();

        // Sticky Side Box
        certy.sideBox.makeSticky();

    }); // end: window resize



    $(window).on('scroll', function () { // start: window scroll

        // Re Init Vars
        certy.vars.windowScrollTop = $(window).scrollTop();

        // Sticky Navigation
        certy.nav.makeSticky();

        // Sticky Side Box
        certy.sideBox.makeSticky();

        // Remove Tooltip
        if(certy.nav.tooltip.el.length > 0){
            certy.nav.tooltip.el.remove();
        }

    }); // end: window scroll



    $(window).on('load', function () { // start: window load

    }); // end: window load

})(jQuery);