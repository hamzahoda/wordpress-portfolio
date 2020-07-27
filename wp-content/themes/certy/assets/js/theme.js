/**
 * Certy Options
 */

var navStiky = false;
if(certy_vars_from_WP.enable_sticky == 1) { navStiky = true; }


var certy = {
    vars: {
        // Set theme rtl mode
        rtl: false,

        // Set theme primary color
        themeColor: certy_vars_from_WP.themeColor,

        // Set middle screen size, must have the same value as in the _variables.scss
        screenMd: '992px'
    },

    nav: {
        height: 'auto', // use 'auto' or some fixed value, for example 480px
        arrow: false, // activate arrow to scroll down menu items,
        sticky: {
            top: "-1px", // sticky position from top
            active: navStiky // activate sticky property on window scroll
        },
        tooltip: {
            active: true
        }
    },

    sideBox: {
        sticky: {
            top: "20px", // sticky position from top
            active: false // activate sticky property on window scroll
        }
    },

    progress: {
        animation: true, // animate on window scroll
        textColor: 'inherit', // set text color
        trailColor: 'rgba(0,0,0,0.07)' // set trail color
    }
};
/*
 * jQuery One Page Nav Plugin
 * http://github.com/davist11/jQuery-One-Page-Nav
 *
 * Copyright (c) 2010 Trevor Davis (http://trevordavis.net)
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://jquery.org/license
 *
 * @version 3.0.0
 *
 * Example usage:
 * $('#nav').onePageNav({
 *   currentClass: 'current',
 *   changeHash: false,
 *   scrollSpeed: 750
 * });
 */

;(function($, window, document, undefined){

    // our plugin constructor
    var OnePageNav = function(elem, options){
        this.elem = elem;
        this.$elem = $(elem);
        this.options = options;
        this.metadata = this.$elem.data('plugin-options');
        this.$win = $(window);
        this.sections = {};
        this.didScroll = false;
        this.$doc = $(document);
        this.docHeight = this.$doc.height();
    };

    // the plugin prototype
    OnePageNav.prototype = {
        defaults: {
            navItems: 'a',
            currentClass: 'current',
            changeHash: false,
            easing: 'swing',
            filter: '',
            scrollSpeed: 750,
            scrollThreshold: 0.5,
            begin: false,
            end: false,
            scrollChange: false
        },

        init: function() {
            // Introduce defaults that can be extended either
            // globally or using an object literal.
            this.config = $.extend({}, this.defaults, this.options, this.metadata);

            this.$nav = this.$elem.find(this.config.navItems);

            //Filter any links out of the nav
            if(this.config.filter !== '') {
                this.$nav = this.$nav.filter(this.config.filter);
            }

            //Handle clicks on the nav
            this.$nav.on('click.onePageNav', $.proxy(this.handleClick, this));

            //Get the section positions
            this.getPositions();

            //Handle scroll changes
            this.bindInterval();

            //Update the positions on resize too
            this.$win.on('resize.onePageNav', $.proxy(this.getPositions, this));

            return this;
        },

        adjustNav: function(self, $parent) {
            self.$elem.find('.' + self.config.currentClass).removeClass(self.config.currentClass);
            $parent.addClass(self.config.currentClass);
        },

        bindInterval: function() {
            var self = this;
            var docHeight;

            self.$win.on('scroll.onePageNav', function() {
                self.didScroll = true;
            });

            self.t = setInterval(function() {
                docHeight = self.$doc.height();

                //If it was scrolled
                if(self.didScroll) {
                    self.didScroll = false;
                    self.scrollChange();
                }

                //If the document height changes
                if(docHeight !== self.docHeight) {
                    self.docHeight = docHeight;
                    self.getPositions();
                }
            }, 250);
        },

        getHash: function($link) {
            return $link.attr('href').split('#')[1];
        },

        getPositions: function() {
            var self = this;
            var linkHref;
            var topPos;
            var $target;

            self.$nav.each(function() {
                linkHref = self.getHash($(this));
                $target = $('#' + linkHref);

                if($target.length) {
                    topPos = $target.offset().top;
                    self.sections[linkHref] = Math.round(topPos);
                }
            });
        },

        getSection: function(windowPos) {
            var returnValue = null;
            var windowHeight = Math.round(this.$win.height() * this.config.scrollThreshold);

            for(var section in this.sections) {
                if((this.sections[section] - windowHeight) < windowPos) {
                    returnValue = section;
                }
            }

            return returnValue;
        },

        handleClick: function(e) {
            var self = this;
            var $link = $(e.currentTarget);
            var $parent = $link.parent();
            var newLoc = '#' + self.getHash($link);

            if(!$parent.hasClass(self.config.currentClass)) {
                //Start callback
                if(self.config.begin) {
                    self.config.begin();
                }

                //Change the highlighted nav item
                self.adjustNav(self, $parent);

                //Removing the auto-adjust on scroll
                self.unbindInterval();

                //Scroll to the correct position
                self.scrollTo(newLoc, function() {
                    //Do we need to change the hash?
                    if(self.config.changeHash) {
                        if(history.pushState) {
                            history.pushState(null, null, newLoc);
                        }
                        else {
                            window.location.hash = newLoc;
                        }
                    }

                    //Add the auto-adjust on scroll back in
                    self.bindInterval();

                    //End callback
                    if(self.config.end) {
                        self.config.end();
                    }
                });
            }

            e.preventDefault();
        },

        scrollChange: function() {
            var windowTop = this.$win.scrollTop();
            var position = this.getSection(windowTop);
            var $parent;

            //If the position is set
            if(position !== null) {
                $parent = this.$elem.find('a[href$="#' + position + '"]').parent();

                //If it's not already the current section
                if(!$parent.hasClass(this.config.currentClass)) {
                    //Change the highlighted nav item
                    this.adjustNav(this, $parent);

                    //If there is a scrollChange callback
                    if(this.config.scrollChange) {
                        this.config.scrollChange($parent);
                    }
                }
            }
        },

        scrollTo: function(target, callback) {
            var self = this;
            var offset = $(target).offset().top;

            if( $(target).closest('.crt-paper-layers').hasClass('crt-animate') ){
                offset = offset - 145;
            } else {
                offset = offset - 45;
            }

            // Scroll to offset
            $('html, body').animate({
                scrollTop: offset
            }, this.config.scrollSpeed, this.config.easing, callback);
        },

        unbindInterval: function() {
            clearInterval(this.t);
            this.$win.unbind('scroll.onePageNav');
        }
    };

    OnePageNav.defaults = OnePageNav.prototype.defaults;

    $.fn.onePageNav = function(options) {
        return this.each(function() {
            new OnePageNav(this, options).init();
        });
    };

})( jQuery, window , document );
/**
 * Certy Functions
 */

/* Init Global Variables */
certy.initGlobalVars = function(){
    // get document <html>
    this.vars.html = jQuery('html');

    // get document <body>
    this.vars.body = jQuery('body');

    // get document #footer
    this.vars.footer = jQuery('#crtFooter');

    // get window Width
    this.vars.windowW = jQuery(window).width();

    // get window height
    this.vars.windowH = jQuery(window).height();

    // get window scroll top
    this.vars.windowScrollTop = jQuery(window).scrollTop();

    // detect device type
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        this.vars.mobile = true;
        this.vars.html.addClass('mobile');
    } else {
        this.vars.mobile = false;
        this.vars.html.addClass('desktop');
    }
};

/* Lock Window Scroll */
certy.lockScroll = function(){
    var initWidth = certy.vars.html.outerWidth();
    var initHeight = certy.vars.body.outerHeight();

    var scrollPosition = [
        self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
        self.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
    ];

    certy.vars.html.data('scroll-position', scrollPosition);
    certy.vars.html.data('previous-overflow', certy.vars.html.css('overflow'));
    certy.vars.html.css('overflow', 'hidden');
    window.scrollTo(scrollPosition[0], scrollPosition[1]);

    var marginR = certy.vars.body.outerWidth() - initWidth;
    var marginB = certy.vars.body.outerHeight() - initHeight;
    certy.vars.body.css({'margin-right': marginR, 'margin-bottom': marginB});
    certy.vars.html.addClass('lock-scroll');
};

/* Unlock Window Scroll */
certy.unlockScroll = function(){
    certy.vars.html.css('overflow', certy.vars.html.data('previous-overflow'));
    var scrollPosition = certy.vars.html.data('scroll-position');
    window.scrollTo(scrollPosition[0], scrollPosition[1]);

    certy.vars.body.css({'margin-right': 0, 'margin-bottom': 0});
    certy.vars.html.removeClass('lock-scroll');
};

/* Detect Device Type */
function ace_detect_device_type() {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        ace.mobile = true;
        ace.html.addClass('crt-mobile');
    } else {
        ace.mobile = false;
        ace.html.addClass('crt-desktop');
    }
}

/* Certy Overlay */
function ace_append_overlay() {
    ace.body.append(ace.overlay.obj);

    // Make the element fully transparent
    ace.overlay.obj[0].style.opacity = 0;

    // Make sure the initial state is applied
    window.getComputedStyle(ace.overlay.obj[0]).opacity;

    // Fade it in
    ace.overlay.obj[0].style.opacity = 1;
}

function ace_remove_overlay() {
    // Fade it out
    ace.overlay.obj[0].style.opacity = 0;

    // Remove overlay
    ace.overlay.obj.remove();
}

/* Certy Lock Scroll */
function ace_lock_scroll() {
    var initWidth = ace.html.outerWidth();
    var initHeight = ace.body.outerHeight();

    var scrollPosition = [
        self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
        self.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
    ];

    ace.html.data('scroll-position', scrollPosition);
    ace.html.data('previous-overflow', ace.html.css('overflow'));
    ace.html.css('overflow', 'hidden');
    window.scrollTo(scrollPosition[0], scrollPosition[1]);

    var marginR = ace.body.outerWidth() - initWidth;
    var marginB = ace.body.outerHeight() - initHeight;
    ace.body.css({'margin-right': marginR, 'margin-bottom': marginB});
    ace.html.addClass('crt-lock-scroll');
}

/* Certy Unlock Scroll */
function ace_unlock_scroll() {
    ace.html.css('overflow', ace.html.data('previous-overflow'));
    var scrollPosition = ace.html.data('scroll-position');
    window.scrollTo(scrollPosition[0], scrollPosition[1]);

    ace.body.css({'margin-right': 0, 'margin-bottom': 0});
    ace.html.removeClass('crt-lock-scroll');
}

/* Certy Close Sidebar */
function ace_open_sidebar() {
    ace.html.addClass('crt-sidebar-opened');
    ace_append_overlay();
    ace_lock_scroll();
}

function ace_close_sidebar() {
    ace.html.removeClass('crt-sidebar-opened');
    ace_remove_overlay();
    ace_unlock_scroll();
}

/* Certy Progress Circle */
function ace_progress_chart(element, text, value, duration) {
    // We have undefined text when user didntn fill text field from admin
    if (typeof text === "undefined") { text = ""; }

    var circle = new ProgressBar.Circle(element, {
        color: certy.vars.themeColor,
        strokeWidth: 5,
        trailWidth: 0,
        text: {
            value: text,
            className: 'progress-text',
            style: {
                top: '50%',
                left: '50%',
                color: certy.progress.textColor,
                position: 'absolute',
                margin: 0,
                padding: 0,
                transform: {
                    prefix: true,
                    value: 'translate(-50%, -50%)'
                }
            },
            autoStyleContainer: true,
            alignToBottom: true
        },
        svgStyle: {
            display: 'block',
            width: '100%'
        },
        duration: duration,
        easing: 'easeOut'
    });

    circle.animate(value); // Number from 0.0 to 1.0
}

/* Certy Progress Line */
function ace_progress_line(element, text, value, duration) {
    // We have undefined text when user didntn fill text field from admin
    if (typeof text === "undefined") { text = ""; }
    
    var line = new ProgressBar.Line(element, {
        strokeWidth: 4,
        easing: 'easeInOut',
        duration: duration,
        color: certy.vars.themeColor,
        trailColor: certy.progress.trailColor,
        trailWidth: 4,
        svgStyle: {
            width: '100%',
            height: '100%'
        },
        text: {
            value: text,
            className: 'progress-text',
            style: {
                top: '-25px',
                right: '0',
                color: certy.progress.textColor,
                position: 'absolute',
                margin: 0,
                padding: 0,
                transform: {
                    prefix: true,
                    value: 'translate(0, 0)'
                }
            },
            autoStyleContainer: true
        }
    });

    line.animate(value);  // Number from 0.0 to 1.0
}

/* Certy Element In Viewport */
function ace_is_elem_in_viewport(el, vpart) {
    var rect = el[0].getBoundingClientRect();

    return (
    rect.bottom >= 0 &&
    rect.right >= 0 &&
    rect.top + vpart <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.left <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function ace_is_elems_in_viewport(elems, vpart) {
    for (var i = 0; i < elems.length; i++) {
        var item = jQuery(elems[i]);

        if (item.hasClass('crt-animate') && ace_is_elem_in_viewport(item, vpart)) {
            item.removeClass('crt-animate').addClass('crt-animated');

            // Animate Circle Chart
            if(item.hasClass('progress-chart')){
                var chart = item.find('.progress-bar');
                ace_progress_chart(chart[0], chart.data('text'), chart.data('value'), 1000);
            }

            // Animate Line Chart
            if(item.hasClass('progress-line')){
                var line = item.find('.progress-bar');
                ace_progress_line(line[0], line.data('text'), line.data('value'), 1000);
            }
        }
    }
}

function ace_appear_elems(elems, vpart) {
    ace_is_elems_in_viewport(elems, vpart);

    jQuery(window).scroll(function () {
        ace_is_elems_in_viewport(elems, vpart);
    });

    jQuery(window).resize(function () {
        ace_is_elems_in_viewport(elems, vpart);
    });
}

/* Certy Google Map */
function initialiseGoogleMap(mapStyles) {
    var latlng;
    var lat = 44.5403;
    var lng = -78.5463;
    var map = jQuery('#map');
    var mapCanvas = map.get(0);
    var map_styles = jQuery.parseJSON(mapStyles);

    if (map.data("latitude")) lat = map.data("latitude");
    if (map.data("longitude")) lng = map.data("longitude");

    latlng = new google.maps.LatLng(lat, lng);

    // Map Options
    var mapOptions = {
        zoom: 14,
        center: latlng,
        scrollwheel: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: map_styles
    };

    // Create the Map
    map = new google.maps.Map(mapCanvas, mapOptions);

    var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        icon: {
            path: 'M125 410 c-56 -72 -111 -176 -120 -224 -7 -36 11 -83 49 -124 76 -85 223 -67 270 31 28 60 29 88 6 150 -19 51 -122 205 -148 221 -6 3 -32 -21 -57 -54z m110 -175 c35 -34 33 -78 -4 -116 -35 -35 -71 -37 -105 -7 -40 35 -43 78 -11 116 34 41 84 44 120 7z',
            fillColor: certy_vars_from_WP.themeColor,
            fillOpacity: 1,
            scale: 0.1,
            strokeColor: certy_vars_from_WP.themeColor,
            strokeWeight: 1,
            anchor: new google.maps.Point(185, 500)
        },
        title: 'Hello World!'
    });

    /*var marker = new Marker({
     map: map,
     position: latlng,
     icon: {
     path: SQUARE_PIN,
     fillColor: '',
     fillOpacity: 0,
     strokeColor: '',
     strokeWeight: 0
     },
     map_icon_label: '<span class="map-icon map-icon-postal-code"></span>'
     });*/

    // Keep Marker in Center
    google.maps.event.addDomListener(window, 'resize', function () {
        map.setCenter(latlng);
    });
}
/**
 * Certy Navigation
 */

// Navigation With Scroll and Arrow
certy.nav.initScroll = function( el ){
    // Set Nav Height
    // certy.nav.scroll = el;

    el.height(el.height()).animate({height: certy.nav.height}, 700, function(){

        // Mouse Scroll
        el.mCustomScrollbar({
            axis: "y",
            scrollbarPosition: "outside"
        });
    });

    // Arrow Scroll
    if (certy.nav.arrow){
        jQuery("#crtNavTools").removeClass('hidden');

        jQuery("#crtNavArrow").on("click", function () {
            el.mCustomScrollbar('scrollTo', '-='+certy.nav.height);
        });
    }
};

// Sticky Navigation
certy.nav.exists = false;
certy.nav.makeSticky = function(){

    // check sticky option, device type and screen size
    if ( this.sticky.active && !certy.vars.mobile && Modernizr.mq('(min-width: ' + certy.vars.screenMd + ')') ) {

        // check if nav nodes exists
        if ( this.exists ){

            // check if window scroll pass element
            if ( certy.vars.windowScrollTop > this.wrap.offset().top ) {
                this.el.css({
                    'top': this.sticky.top,
                    'left': this.wrap.offset().left,
                    'width': this.wrap.width(),
                    'bottom': 'auto',
                    'position': 'fixed'
                });
            } else {
                this.el.css({
                    'top': '0',
                    'left': 'auto',
                    'width': 'auto',
                    'bottom': 'auto',
                    'position': 'relative'
                });
            }
        } else {
            this.el = jQuery('#crtNavInner');
            this.wrap = jQuery('#crtNavWrap');

            if ( this.el.length > 0 && this.wrap.length > 0 ) {
                this.exists = true;
            }
        }
    }
};

// Navigation Tooltips
certy.nav.tooltip.el = '';
certy.nav.tooltip.timer = 0;

certy.nav.tooltip.show = function(current){
    certy.nav.tooltip.timer = setTimeout(function () {

        certy.nav.tooltip.el = jQuery('<div class="crt-tooltip"></div>');

        // Init vars
        var top = current.offset().top;
        var left = current.offset().left;
        var right = left + current.outerWidth();
        var width = current.outerWidth();
        var height = 4;

        // Append tooltip
        certy.vars.body.append( certy.nav.tooltip.el );

        // Set tooltip text
        certy.nav.tooltip.el.text( current.data('tooltip') );

        // Positioning tooltip
        if (right + certy.nav.tooltip.el.outerWidth() < certy.vars.windowW) {
            certy.nav.tooltip.el.addClass('arrow-left').css({"left": right + "px", "top": (top + height) + "px"});
        } else {
            certy.nav.tooltip.el.addClass('arrow-right text-right').css({
                "left": (left - certy.nav.tooltip.el.outerWidth() - 10) + "px",
                "top": (top + height) + "px"
            });
        }

        // Show Tooltip
        certy.nav.tooltip.el.fadeIn(150);

    }, 150);
};

certy.nav.tooltip.hide = function(){
    clearTimeout(certy.nav.tooltip.timer);
    if (certy.nav.tooltip.el.length > 0) {
        certy.nav.tooltip.el.fadeOut(150, function () {
            certy.nav.tooltip.el.remove();
        });
    }
};
/**
 * Certy Side Box
 */
certy.sideBox.exists = false;
certy.sideBox.makeSticky = function(){

    // check sticky option, device type and screen size
    if ( this.sticky.active && !certy.vars.mobile && Modernizr.mq('(min-width: ' + certy.vars.screenMd + ')') ) {

        // check if nav nodes exists
        if ( this.exists ){

            // check if window scroll pass element
            if ( certy.vars.windowScrollTop > this.wrap.offset().top ) {
                this.el.css({
                    'top': this.sticky.top,
                    'left': this.wrap.offset().left,
                    'width': this.wrap.width(),
                    'bottom': 'auto',
                    'position': 'fixed'
                });
            } else {
                this.el.css({
                    'top': '0',
                    'left': 'auto',
                    'width': 'auto',
                    'bottom': 'auto',
                    'position': 'relative'
                });
            }
        } else {
            this.el = jQuery('#crtSideBox');
            this.wrap = jQuery('#crtSideBoxWrap');

            if ( this.el.length > 0 && this.wrap.length > 0 ) {
                this.exists = true;
            }
        }
    }
};
/**
 * Certy Slider
 */

// Slider
certy.slider = function(slider){
    for (var i = 0; i < slider.length; i++) {

       if( jQuery(slider[i]).data("init") != "none" ){
           jQuery(slider[i]).slick();
       }
    }
};

// Carousel
certy.carousel = function(carousel){
    for (var i = 0; i < carousel.length; i++) {
        if( jQuery(carousel[i]).data("init") !== "none" ){
            jQuery(carousel[i]).slick({
                "dots" : true
            });
        }
    }
};


/**
 * Certy Portfolio
 */

certy.portfolio = {
    popupSlider: '',
    popupCarousel: '',
    currentEmbed: false,
    currentEmbedType: false,

    initGrid: function(el){
        // isotope initialization
        var grid = el.isotope({
            isOriginLeft: !certy.vars.rtl,
            itemSelector: '.pf-grid-item',
            percentPosition: true,
            masonry: {
                columnWidth: '.pf-grid-sizer'
            }
        });

        // layout isotope after each image loads
        grid.imagesLoaded().progress( function() {
            grid.isotope('layout');
        });

        // isotope filter
        var filter = el.closest('.pf-wrap').find('.pf-filter');
        if (filter.length > 0) {
            var filter_btn = filter.find('button');
            var filter_btn_first = jQuery('.pf-filter button:first-child');

            filter_btn_first.addClass('active');

            filter_btn.on('click', function () {
                filter_btn.removeClass('active');
                jQuery(this).addClass('active');

                var filterValue = jQuery(this).attr('data-filter');
                grid.isotope({ filter: filterValue });
            });
        }
    },

    openPopup: function(el){
        // add opened class on html
        certy.vars.html.addClass('crt-pf-popup-opened');

        // append portfolio popup
        this.popup_wrapper = jQuery('<div id="pf-popup-wrap">'+
			'<button id="pf-popup-close"><i class="crt-icon crt-icon-close"></i></button>'+
            '<div class="pf-popup-inner">'+
            '<div class="pf-popup-middle">'+
            '<div class="pf-popup-container">'+
            '<button id="pf-popup-close"><i class="rsicon rsicon-close"></i></button>'+
            '<div id="pf-popup-content" class="pf-popup-content"></div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>');

        certy.vars.body.append( this.popup_wrapper );

        // add portfolio popup content
        this.popup_content = jQuery('#pf-popup-content');
        this.popup_content.append( el.clone() );

        // popup slider
        this.popupSlider = jQuery('#pf-popup-content .pf-popup-media');

        // popup slider: on init
        this.popupSlider.on('init', function(event, slick) {
            certy.portfolio.loadEmbed(0);

            // Make Portfolio Popup Visible
            jQuery(window).trigger('resize');
        });

        // popup slider: before change
        this.popupSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {

            // Stop current slide iframe/video play
            if( certy.portfolio.currentEmbed && certy.portfolio.currentEmbedType ){
                switch (certy.portfolio.currentEmbedType) {
                    case "iframe":

                        var iframe = certy.portfolio.currentEmbed.find('iframe');
                        iframe.attr('src', iframe.attr('src'));

                        break;

                    case "video":
                        var video = certy.portfolio.currentEmbed.find('video');
                        video[0].pause();

                        break;
                }
            }

            // Load next slide embed
            certy.portfolio.loadEmbed(nextSlide);
        });

        // popup slider: initialize
        this.popupSlider.slick({
            speed: 500,
            dots: false,
            arrow: true,
            infinite: false,
            slidesToShow: 1,
            adaptiveHeight: true
        });

        // popup carousel
        this.popupCarousel = jQuery('#pf-popup-content .pf-rel-carousel');

        // popup carousel: initialize
        this.popupCarousel.slick({
            dots: false,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            lazyLoad: 'ondemand'
        });

        // make portfolio popup visible
        this.popup_wrapper.addClass('pf-opened');

        // lock window scroll
        certy.lockScroll();
    },

    closePopup: function(el) {
        // remove opened class from html
        certy.vars.html.removeClass('cr-portfolio-opened');

        // make portfolio popup invisible
        this.popup_wrapper.removeClass('pf-opened');

        setTimeout(function(){
            certy.portfolio.popup_wrapper.remove();
            certy.unlockScroll();
        }, 500);
    },

    loadEmbed: function (slideIndex) {
        var currentEmbed = jQuery('#pf-popup-content .pf-popup-slide[data-slick-index="' + slideIndex + '"]').find('.pf-popup-embed');
        var currentEmbedType = jQuery.trim(currentEmbed.data('type'));
        var curentEmbedUrl = jQuery.trim(currentEmbed.data('url'));

        certy.portfolio.currentEmbed = currentEmbed;
        certy.portfolio.currentEmbedType = currentEmbedType;

        // Check if 'currentEmbed' still not loaded then do actions
        if (!currentEmbed.hasClass('pf-embed-loaded')) {

            // Check if 'currentEmbed' url and type are provided
            if (typeof currentEmbedType !== typeof undefined && currentEmbedType !== false && currentEmbedType !== "" && typeof curentEmbedUrl !== typeof undefined && curentEmbedUrl !== false && curentEmbedUrl !== "") {

                // Set embed dimensions if provided
                var embedW = jQuery.trim(currentEmbed.data('width'));
                var embedH = jQuery.trim(currentEmbed.data('height'));
                if (typeof embedW !== typeof undefined && embedW !== false && embedW !== "" && typeof embedH !== typeof undefined && embedH !== false && embedH !== "") {
                    currentEmbed.css({'padding-top': (embedH/embedW*100)+'%'});
                }

                // Load appropriate embed
                switch (currentEmbedType) {
                    case "image":
                        // Add embed type class
                        currentEmbed.addClass('pf-embed-image');

                        // Append embed
                        var img = jQuery('<img/>',{
                            src: curentEmbedUrl,
                            style: 'display:none'
                        }).load(function(){
                            jQuery(this).fadeIn(500);
                            currentEmbed.addClass('pf-embed-loaded');
                        }).error(function(){
                            currentEmbed.addClass('pf-embed-error');
                        });

                        currentEmbed.empty().append(img);

                        break;

                    case "iframe":
                        // Add embed type class
                        currentEmbed.addClass('pf-embed-iframe');

                        // Append Embed
                        var iframe = jQuery('<iframe/>', {
                            src: curentEmbedUrl,
                            style: 'display:none',
                            allowfullscreen: ''
                        }).load(function(){
                            jQuery(this).fadeIn(500);
                            currentEmbed.addClass('pf-embed-loaded');
                        }).error(function(){
                            currentEmbed.addClass('pf-embed-error');
                        });

                        currentEmbed.empty().append(iframe);

                        break;

                    case "video":
                        // Add embed type class
                        currentEmbed.addClass('pf-embed-video');

                        // Append Embed
                        var videoOptions = this.parseOptions(curentEmbedUrl);
                        var video = '<video ';
                        if(videoOptions.poster) video += 'poster="'+videoOptions.poster+'" ';
                        video += 'controls="controls" preload="yes">';
                        if(videoOptions.mp4) video += '<source type="video/mp4" src="'+videoOptions.mp4+'"/>';
                        if(videoOptions.webm) video += '<source type="video/webm" src="'+videoOptions.webm+'"/>';
                        if(videoOptions.ogv) video += '<source type="video/ogg" src="'+videoOptions.ogv+'"/>';
                        video += 'Your browser does not support the video tag.</video>';

                        currentEmbed.empty().append( jQuery(video) );

                        break;
                }
            }
        }
    },

    parseOptions: function (str) {
        var obj = {};
        var delimiterIndex;
        var option;
        var prop;
        var val;
        var arr;
        var len;
        var i;

        // Remove spaces around delimiters and split
        arr = str.replace(/\s*:\s*/g, ':').replace(/\s*,\s*/g, ',').split(',');

        // Parse a string
        for (i = 0, len = arr.length; i < len; i++) {
            option = arr[i];

            // Ignore urls and a string without colon delimiters
            if (
                option.search(/^(http|https|ftp):\/\//) !== -1 ||
                option.search(':') === -1
            ) {
                break;
            }

            delimiterIndex = option.indexOf(':');
            prop = option.substring(0, delimiterIndex);
            val = option.substring(delimiterIndex + 1);

            // If val is an empty string, make it undefined
            if (!val) {
                val = undefined;
            }

            // Convert a string value if it is like a boolean
            if (typeof val === 'string') {
                val = val === 'true' || (val === 'false' ? false : val);
            }

            // Convert a string value if it is like a number
            if (typeof val === 'string') {
                val = !isNaN(val) ? +val : val;
            }

            obj[prop] = val;
        }

        // If nothing is parsed
        if (prop == null && val == null) {
            return str;
        }

        return obj;
    }
};

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
// Theme Variables
var ace = {
    html: '',
    body: '',
    mobile: '',

    sidebar: {
        obj: '',
        btn: ''
    },

    nav: {
        obj: '',
        tooltip: jQuery('<div class="crt-tooltip"></div>')
    },

    overlay: {
        obj: jQuery('<div id="crtOverlay"></div>')
    },

    progress: {
        lines: '',
        charts: '',
        bullets: ''
    }
};

(function ($) {
    "use strict";
	
	$(function () { // start: document ready

		/**
		 * Certy Init Main Vars
		 */
		ace.html = $('html');
		ace.body = $('body');

		/**
		 * Certy Detect Device Type
		 */
		ace_detect_device_type();

		/**
		 * Certy Mobile Navigation
		 */
		$('#crtMainNavSm .menu-item-has-children > a').on('click touchstart', function(){
			if( $(this).hasClass('hover') ){
				return true;
			} else {
				$(this).addClass('hover');
				$(this).next().slideDown(500);
				return false;
			}
		});

		/**
		 * Certy Sidebar
		 */
		ace.sidebar.obj = $('#crtSidebar');
		ace.sidebar.btn = $('#crtSidebarBtn');

		// Open Sidebar
		ace.sidebar.btn.on('touchstart click', function () {
			ace_open_sidebar();
		});

		// Close Sidebar Through Overlay
		$(document).on('touchstart click', '.crt-sidebar-opened #crtOverlay', function (e) {
			var container = ace.sidebar.obj;
			// if the target of the click isn't the container... nor a descendant of the container
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				ace_close_sidebar();
			}
		});

		// Close Sidebar Using Button
		$('#crtSidebarClose').on('click', function () {
			ace_close_sidebar();
		});

		// Sidebar Custom Scroll
		$("#crtSidebarInner").mCustomScrollbar({
			axis: "y",
			theme: "minimal-dark",
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});

		/**
		 * Certy Circle & Line Charts
		 */
		if(!certy.progress.animation || ace.mobile) {
			// Circle Chart
			ace.progress.charts = $('.progress-chart .progress-bar');
			for (var i = 0; i < ace.progress.charts.length; i++) {
				var chart = $(ace.progress.charts[i]);

				ace_progress_chart(chart[0], chart.data('text'), chart.data('value'), 1);
			}

			// Line Chart
			ace.progress.lines = $('.progress-line .progress-bar');
			for (var i = 0; i < ace.progress.lines.length; i++) {
				var line = $(ace.progress.lines[i]);

				ace_progress_line(line[0], line.data('text'), line.data('value'), 1);
			}
		}

		/**
		 * Certy Animate Elements
		 */
		if(certy.progress.animation && !ace.mobile) {
			ace_appear_elems($('.crt-animate'), 0);
		}

		/**
		 * Code Highlight
		 */
		$('pre').each(function (i, block) {
			hljs.highlightBlock(block);
		});

		/**
		 * Certy Alerts
		 */
		$('.alert .close').on('click', function () {
			var alert = $(this).parent();

			alert.fadeOut(500, function () {
				alert.remove();
			});
		});

		/**
		 * Certy Slider
		 */
		$('.slider').slick({
			dots: true
		});

		/**
		 * Certy Google Map Initialisation
		 */
		if ($('#map').length > 0) {
			initialiseGoogleMap( certy_vars_from_WP.mapStyles );
		}

		/**
		 *  Tabs
		 */
		var tabActive = $('.tabs-menu>li.active');
		if( tabActive.length > 0 ){
			for (var i = 0; i < tabActive.length; i++) {
				var tab_id = $(tabActive[i]).children().attr('href');

				$(tab_id).addClass('active').show();
			}
		}

		$('.tabs-menu a').on('click', function(e){
			var tab = $(this);
			var tab_id = tab.attr('href');
			var tab_wrap = tab.closest('.tabs');
			var tab_content = tab_wrap.find('.tab-content');

			tab.parent().addClass("active");
			tab.parent().siblings().removeClass('active');
			tab_content.not(tab_id).removeClass('active').hide();
			$(tab_id).addClass('active').fadeIn(500);

			e.preventDefault();
		});

		/**
		 * ToggleBox
		 */
		var toggleboxActive = $('.togglebox>li.active');
		if( toggleboxActive.length > 0 ){
			toggleboxActive.find('.togglebox-content').show();
		}

		$('.togglebox-header').on('click', function(){
			var toggle_head = $(this);

			toggle_head.next('.togglebox-content').slideToggle(300);
			toggle_head.parent().toggleClass('active');
		});


		/**
		 * Accordeon
		 */
		var accordeonActive = $('.accordion>li.active');
		if( accordeonActive.length > 0 ){
			accordeonActive.find('.accordion-content').show();
		}

		$('.accordion-header').on('click', function(){
			var acc_head = $(this);
			var acc_section = acc_head.parent();
			var acc_content = acc_head.next();
			var acc_all_contents = acc_head.closest('.accordion').find('.accordion-content');

			if(acc_section.hasClass('active')){
				acc_section.removeClass('active');
				acc_content.slideUp();
			}else{
				acc_section.siblings().removeClass('active');
				acc_section.addClass('active');
				acc_all_contents.slideUp(300);
				acc_content.slideDown(300);
			}
		});

		/**
		 * Comments Open/Close
		 */
		$('.comment-replys-link').on('click', function(){
			$(this).closest('.comment').toggleClass('show-replies');

			return false;
		});

		/**
		 * Portfolio Popup
		 */
		var pf_popup = {};
		pf_popup.wrapper = null;
		pf_popup.content = null;
		pf_popup.slider = null;

		pf_popup.open = function ( el ){
			// Append Portfolio Popup
			this.wrapper = $('<div id="pf-popup-wrap" class="pf-popup-wrap">'+
			'<div class="pf-popup-inner">'+
			'<div class="pf-popup-middle">'+
			'<div class="pf-popup-container">'+
			'<button id="pf-popup-close"><i class="rsicon rsicon-close"></i></button>'+
			'<div id="pf-popup-content" class="pf-popup-content"></div>'+
			'</div>'+
			'</div>'+
			'</div>');

			ace.body.append(this.wrapper);

			// Add Portfolio Popup Items
			this.content = $('#pf-popup-content');
			this.content.append( el.clone() );

			// Make Portfolio Popup Visible
			pf_popup.wrapper.addClass('opened');
			ace_lock_scroll();
		};

		pf_popup.close = function(){
			this.wrapper.removeClass('opened');
			setTimeout(function(){
				pf_popup.wrapper.remove();
				ace_unlock_scroll();
			}, 500);
		};

		// Open Portfolio Popup
		$(document).on('click', '.pf-btn-view', function() {
			var id = $(this).attr('href');
			pf_popup.open( $(id) );

			ace.html.addClass('crt-portfolio-opened');

			return false;
		});

		// Close Portfolio Popup
		$(document).on('touchstart click', '.crt-portfolio-opened #pf-popup-wrap', function (e) {
			var container = $('#pf-popup-content');

			// if the target of the click isn't the container... nor a descendant of the container
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				pf_popup.close();
				ace.html.removeClass('crt-portfolio-opened');
			}
		});

		/**
		 * Show Code <pre>
		 */
		$('.toggle-link').on('click', function(){
			var id = $(this).attr('href');

			if($(this).hasClass('opened')){
				$(id).slideUp(500);
				$(this).removeClass('opened');
			} else {
				$(id).slideDown(500);
				$(this).addClass('opened');
			}

			return false;
		});

		/**
		 * Share Button
		 */
		$('.share-btn').on( "mouseenter", function(){
			$(this).parent().addClass('hovered');
		});

		$('.share-box').on( "mouseleave", function(){
			var share_box = $(this);

			if(share_box.hasClass('hovered')){
				share_box.addClass('closing');
				setTimeout(function() {
					share_box.removeClass('hovered');
					share_box.removeClass('closing');
				},300);
			}
		});

	}); // end: document ready
})(jQuery);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm9wdGlvbnMuanMiLCJvbmUtcGFnZS1uYXYuanMiLCJfZnVuY3Rpb25zLmpzIiwiX25hdi5qcyIsIl9zaWRlLWJveC5qcyIsIl9zbGlkZXIuanMiLCJfcG9ydGZvbGlvLmpzIiwibWFpbi5qcyIsInRoZW1lLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQzVDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FDM09BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUNsVUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQ2hIQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQ3ZDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FDekJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQzVSQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQzNLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6InRoZW1lLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLyoqXHJcbiAqIENlcnR5IE9wdGlvbnNcclxuICovXHJcblxyXG52YXIgbmF2U3Rpa3kgPSBmYWxzZTtcclxuaWYoY2VydHlfdmFyc19mcm9tX1dQLmVuYWJsZV9zdGlja3kgPT0gMSkgeyBuYXZTdGlreSA9IHRydWU7IH1cclxuXHJcblxyXG52YXIgY2VydHkgPSB7XHJcbiAgICB2YXJzOiB7XHJcbiAgICAgICAgLy8gU2V0IHRoZW1lIHJ0bCBtb2RlXHJcbiAgICAgICAgcnRsOiBmYWxzZSxcclxuXHJcbiAgICAgICAgLy8gU2V0IHRoZW1lIHByaW1hcnkgY29sb3JcclxuICAgICAgICB0aGVtZUNvbG9yOiBjZXJ0eV92YXJzX2Zyb21fV1AudGhlbWVDb2xvcixcclxuXHJcbiAgICAgICAgLy8gU2V0IG1pZGRsZSBzY3JlZW4gc2l6ZSwgbXVzdCBoYXZlIHRoZSBzYW1lIHZhbHVlIGFzIGluIHRoZSBfdmFyaWFibGVzLnNjc3NcclxuICAgICAgICBzY3JlZW5NZDogJzk5MnB4J1xyXG4gICAgfSxcclxuXHJcbiAgICBuYXY6IHtcclxuICAgICAgICBoZWlnaHQ6ICdhdXRvJywgLy8gdXNlICdhdXRvJyBvciBzb21lIGZpeGVkIHZhbHVlLCBmb3IgZXhhbXBsZSA0ODBweFxyXG4gICAgICAgIGFycm93OiBmYWxzZSwgLy8gYWN0aXZhdGUgYXJyb3cgdG8gc2Nyb2xsIGRvd24gbWVudSBpdGVtcyxcclxuICAgICAgICBzdGlja3k6IHtcclxuICAgICAgICAgICAgdG9wOiBcIi0xcHhcIiwgLy8gc3RpY2t5IHBvc2l0aW9uIGZyb20gdG9wXHJcbiAgICAgICAgICAgIGFjdGl2ZTogbmF2U3Rpa3kgLy8gYWN0aXZhdGUgc3RpY2t5IHByb3BlcnR5IG9uIHdpbmRvdyBzY3JvbGxcclxuICAgICAgICB9LFxyXG4gICAgICAgIHRvb2x0aXA6IHtcclxuICAgICAgICAgICAgYWN0aXZlOiB0cnVlXHJcbiAgICAgICAgfVxyXG4gICAgfSxcclxuXHJcbiAgICBzaWRlQm94OiB7XHJcbiAgICAgICAgc3RpY2t5OiB7XHJcbiAgICAgICAgICAgIHRvcDogXCIyMHB4XCIsIC8vIHN0aWNreSBwb3NpdGlvbiBmcm9tIHRvcFxyXG4gICAgICAgICAgICBhY3RpdmU6IGZhbHNlIC8vIGFjdGl2YXRlIHN0aWNreSBwcm9wZXJ0eSBvbiB3aW5kb3cgc2Nyb2xsXHJcbiAgICAgICAgfVxyXG4gICAgfSxcclxuXHJcbiAgICBwcm9ncmVzczoge1xyXG4gICAgICAgIGFuaW1hdGlvbjogdHJ1ZSwgLy8gYW5pbWF0ZSBvbiB3aW5kb3cgc2Nyb2xsXHJcbiAgICAgICAgdGV4dENvbG9yOiAnaW5oZXJpdCcsIC8vIHNldCB0ZXh0IGNvbG9yXHJcbiAgICAgICAgdHJhaWxDb2xvcjogJ3JnYmEoMCwwLDAsMC4wNyknIC8vIHNldCB0cmFpbCBjb2xvclxyXG4gICAgfVxyXG59OyIsIi8qXHJcbiAqIGpRdWVyeSBPbmUgUGFnZSBOYXYgUGx1Z2luXHJcbiAqIGh0dHA6Ly9naXRodWIuY29tL2RhdmlzdDExL2pRdWVyeS1PbmUtUGFnZS1OYXZcclxuICpcclxuICogQ29weXJpZ2h0IChjKSAyMDEwIFRyZXZvciBEYXZpcyAoaHR0cDovL3RyZXZvcmRhdmlzLm5ldClcclxuICogRHVhbCBsaWNlbnNlZCB1bmRlciB0aGUgTUlUIGFuZCBHUEwgbGljZW5zZXMuXHJcbiAqIFVzZXMgdGhlIHNhbWUgbGljZW5zZSBhcyBqUXVlcnksIHNlZTpcclxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxyXG4gKlxyXG4gKiBAdmVyc2lvbiAzLjAuMFxyXG4gKlxyXG4gKiBFeGFtcGxlIHVzYWdlOlxyXG4gKiAkKCcjbmF2Jykub25lUGFnZU5hdih7XHJcbiAqICAgY3VycmVudENsYXNzOiAnY3VycmVudCcsXHJcbiAqICAgY2hhbmdlSGFzaDogZmFsc2UsXHJcbiAqICAgc2Nyb2xsU3BlZWQ6IDc1MFxyXG4gKiB9KTtcclxuICovXHJcblxyXG47KGZ1bmN0aW9uKCQsIHdpbmRvdywgZG9jdW1lbnQsIHVuZGVmaW5lZCl7XHJcblxyXG4gICAgLy8gb3VyIHBsdWdpbiBjb25zdHJ1Y3RvclxyXG4gICAgdmFyIE9uZVBhZ2VOYXYgPSBmdW5jdGlvbihlbGVtLCBvcHRpb25zKXtcclxuICAgICAgICB0aGlzLmVsZW0gPSBlbGVtO1xyXG4gICAgICAgIHRoaXMuJGVsZW0gPSAkKGVsZW0pO1xyXG4gICAgICAgIHRoaXMub3B0aW9ucyA9IG9wdGlvbnM7XHJcbiAgICAgICAgdGhpcy5tZXRhZGF0YSA9IHRoaXMuJGVsZW0uZGF0YSgncGx1Z2luLW9wdGlvbnMnKTtcclxuICAgICAgICB0aGlzLiR3aW4gPSAkKHdpbmRvdyk7XHJcbiAgICAgICAgdGhpcy5zZWN0aW9ucyA9IHt9O1xyXG4gICAgICAgIHRoaXMuZGlkU2Nyb2xsID0gZmFsc2U7XHJcbiAgICAgICAgdGhpcy4kZG9jID0gJChkb2N1bWVudCk7XHJcbiAgICAgICAgdGhpcy5kb2NIZWlnaHQgPSB0aGlzLiRkb2MuaGVpZ2h0KCk7XHJcbiAgICB9O1xyXG5cclxuICAgIC8vIHRoZSBwbHVnaW4gcHJvdG90eXBlXHJcbiAgICBPbmVQYWdlTmF2LnByb3RvdHlwZSA9IHtcclxuICAgICAgICBkZWZhdWx0czoge1xyXG4gICAgICAgICAgICBuYXZJdGVtczogJ2EnLFxyXG4gICAgICAgICAgICBjdXJyZW50Q2xhc3M6ICdjdXJyZW50JyxcclxuICAgICAgICAgICAgY2hhbmdlSGFzaDogZmFsc2UsXHJcbiAgICAgICAgICAgIGVhc2luZzogJ3N3aW5nJyxcclxuICAgICAgICAgICAgZmlsdGVyOiAnJyxcclxuICAgICAgICAgICAgc2Nyb2xsU3BlZWQ6IDc1MCxcclxuICAgICAgICAgICAgc2Nyb2xsVGhyZXNob2xkOiAwLjUsXHJcbiAgICAgICAgICAgIGJlZ2luOiBmYWxzZSxcclxuICAgICAgICAgICAgZW5kOiBmYWxzZSxcclxuICAgICAgICAgICAgc2Nyb2xsQ2hhbmdlOiBmYWxzZVxyXG4gICAgICAgIH0sXHJcblxyXG4gICAgICAgIGluaXQ6IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAvLyBJbnRyb2R1Y2UgZGVmYXVsdHMgdGhhdCBjYW4gYmUgZXh0ZW5kZWQgZWl0aGVyXHJcbiAgICAgICAgICAgIC8vIGdsb2JhbGx5IG9yIHVzaW5nIGFuIG9iamVjdCBsaXRlcmFsLlxyXG4gICAgICAgICAgICB0aGlzLmNvbmZpZyA9ICQuZXh0ZW5kKHt9LCB0aGlzLmRlZmF1bHRzLCB0aGlzLm9wdGlvbnMsIHRoaXMubWV0YWRhdGEpO1xyXG5cclxuICAgICAgICAgICAgdGhpcy4kbmF2ID0gdGhpcy4kZWxlbS5maW5kKHRoaXMuY29uZmlnLm5hdkl0ZW1zKTtcclxuXHJcbiAgICAgICAgICAgIC8vRmlsdGVyIGFueSBsaW5rcyBvdXQgb2YgdGhlIG5hdlxyXG4gICAgICAgICAgICBpZih0aGlzLmNvbmZpZy5maWx0ZXIgIT09ICcnKSB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLiRuYXYgPSB0aGlzLiRuYXYuZmlsdGVyKHRoaXMuY29uZmlnLmZpbHRlcik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vSGFuZGxlIGNsaWNrcyBvbiB0aGUgbmF2XHJcbiAgICAgICAgICAgIHRoaXMuJG5hdi5vbignY2xpY2sub25lUGFnZU5hdicsICQucHJveHkodGhpcy5oYW5kbGVDbGljaywgdGhpcykpO1xyXG5cclxuICAgICAgICAgICAgLy9HZXQgdGhlIHNlY3Rpb24gcG9zaXRpb25zXHJcbiAgICAgICAgICAgIHRoaXMuZ2V0UG9zaXRpb25zKCk7XHJcblxyXG4gICAgICAgICAgICAvL0hhbmRsZSBzY3JvbGwgY2hhbmdlc1xyXG4gICAgICAgICAgICB0aGlzLmJpbmRJbnRlcnZhbCgpO1xyXG5cclxuICAgICAgICAgICAgLy9VcGRhdGUgdGhlIHBvc2l0aW9ucyBvbiByZXNpemUgdG9vXHJcbiAgICAgICAgICAgIHRoaXMuJHdpbi5vbigncmVzaXplLm9uZVBhZ2VOYXYnLCAkLnByb3h5KHRoaXMuZ2V0UG9zaXRpb25zLCB0aGlzKSk7XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gdGhpcztcclxuICAgICAgICB9LFxyXG5cclxuICAgICAgICBhZGp1c3ROYXY6IGZ1bmN0aW9uKHNlbGYsICRwYXJlbnQpIHtcclxuICAgICAgICAgICAgc2VsZi4kZWxlbS5maW5kKCcuJyArIHNlbGYuY29uZmlnLmN1cnJlbnRDbGFzcykucmVtb3ZlQ2xhc3Moc2VsZi5jb25maWcuY3VycmVudENsYXNzKTtcclxuICAgICAgICAgICAgJHBhcmVudC5hZGRDbGFzcyhzZWxmLmNvbmZpZy5jdXJyZW50Q2xhc3MpO1xyXG4gICAgICAgIH0sXHJcblxyXG4gICAgICAgIGJpbmRJbnRlcnZhbDogZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICAgICAgdmFyIGRvY0hlaWdodDtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuJHdpbi5vbignc2Nyb2xsLm9uZVBhZ2VOYXYnLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuZGlkU2Nyb2xsID0gdHJ1ZTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLnQgPSBzZXRJbnRlcnZhbChmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgIGRvY0hlaWdodCA9IHNlbGYuJGRvYy5oZWlnaHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL0lmIGl0IHdhcyBzY3JvbGxlZFxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5kaWRTY3JvbGwpIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmRpZFNjcm9sbCA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuc2Nyb2xsQ2hhbmdlKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgLy9JZiB0aGUgZG9jdW1lbnQgaGVpZ2h0IGNoYW5nZXNcclxuICAgICAgICAgICAgICAgIGlmKGRvY0hlaWdodCAhPT0gc2VsZi5kb2NIZWlnaHQpIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmRvY0hlaWdodCA9IGRvY0hlaWdodDtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmdldFBvc2l0aW9ucygpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9LCAyNTApO1xyXG4gICAgICAgIH0sXHJcblxyXG4gICAgICAgIGdldEhhc2g6IGZ1bmN0aW9uKCRsaW5rKSB7XHJcbiAgICAgICAgICAgIHJldHVybiAkbGluay5hdHRyKCdocmVmJykuc3BsaXQoJyMnKVsxXTtcclxuICAgICAgICB9LFxyXG5cclxuICAgICAgICBnZXRQb3NpdGlvbnM6IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgICAgIHZhciBsaW5rSHJlZjtcclxuICAgICAgICAgICAgdmFyIHRvcFBvcztcclxuICAgICAgICAgICAgdmFyICR0YXJnZXQ7XHJcblxyXG4gICAgICAgICAgICBzZWxmLiRuYXYuZWFjaChmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgIGxpbmtIcmVmID0gc2VsZi5nZXRIYXNoKCQodGhpcykpO1xyXG4gICAgICAgICAgICAgICAgJHRhcmdldCA9ICQoJyMnICsgbGlua0hyZWYpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCR0YXJnZXQubGVuZ3RoKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdG9wUG9zID0gJHRhcmdldC5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5zZWN0aW9uc1tsaW5rSHJlZl0gPSBNYXRoLnJvdW5kKHRvcFBvcyk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0sXHJcblxyXG4gICAgICAgIGdldFNlY3Rpb246IGZ1bmN0aW9uKHdpbmRvd1Bvcykge1xyXG4gICAgICAgICAgICB2YXIgcmV0dXJuVmFsdWUgPSBudWxsO1xyXG4gICAgICAgICAgICB2YXIgd2luZG93SGVpZ2h0ID0gTWF0aC5yb3VuZCh0aGlzLiR3aW4uaGVpZ2h0KCkgKiB0aGlzLmNvbmZpZy5zY3JvbGxUaHJlc2hvbGQpO1xyXG5cclxuICAgICAgICAgICAgZm9yKHZhciBzZWN0aW9uIGluIHRoaXMuc2VjdGlvbnMpIHtcclxuICAgICAgICAgICAgICAgIGlmKCh0aGlzLnNlY3Rpb25zW3NlY3Rpb25dIC0gd2luZG93SGVpZ2h0KSA8IHdpbmRvd1Bvcykge1xyXG4gICAgICAgICAgICAgICAgICAgIHJldHVyblZhbHVlID0gc2VjdGlvbjtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHJldHVyblZhbHVlO1xyXG4gICAgICAgIH0sXHJcblxyXG4gICAgICAgIGhhbmRsZUNsaWNrOiBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICAgICAgdmFyICRsaW5rID0gJChlLmN1cnJlbnRUYXJnZXQpO1xyXG4gICAgICAgICAgICB2YXIgJHBhcmVudCA9ICRsaW5rLnBhcmVudCgpO1xyXG4gICAgICAgICAgICB2YXIgbmV3TG9jID0gJyMnICsgc2VsZi5nZXRIYXNoKCRsaW5rKTtcclxuXHJcbiAgICAgICAgICAgIGlmKCEkcGFyZW50Lmhhc0NsYXNzKHNlbGYuY29uZmlnLmN1cnJlbnRDbGFzcykpIHtcclxuICAgICAgICAgICAgICAgIC8vU3RhcnQgY2FsbGJhY2tcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuY29uZmlnLmJlZ2luKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb25maWcuYmVnaW4oKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL0NoYW5nZSB0aGUgaGlnaGxpZ2h0ZWQgbmF2IGl0ZW1cclxuICAgICAgICAgICAgICAgIHNlbGYuYWRqdXN0TmF2KHNlbGYsICRwYXJlbnQpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vUmVtb3ZpbmcgdGhlIGF1dG8tYWRqdXN0IG9uIHNjcm9sbFxyXG4gICAgICAgICAgICAgICAgc2VsZi51bmJpbmRJbnRlcnZhbCgpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vU2Nyb2xsIHRvIHRoZSBjb3JyZWN0IHBvc2l0aW9uXHJcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFRvKG5ld0xvYywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9EbyB3ZSBuZWVkIHRvIGNoYW5nZSB0aGUgaGFzaD9cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmNvbmZpZy5jaGFuZ2VIYXNoKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGhpc3RvcnkucHVzaFN0YXRlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBoaXN0b3J5LnB1c2hTdGF0ZShudWxsLCBudWxsLCBuZXdMb2MpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgd2luZG93LmxvY2F0aW9uLmhhc2ggPSBuZXdMb2M7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vQWRkIHRoZSBhdXRvLWFkanVzdCBvbiBzY3JvbGwgYmFjayBpblxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuYmluZEludGVydmFsKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vRW5kIGNhbGxiYWNrXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5jb25maWcuZW5kKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuY29uZmlnLmVuZCgpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgfSxcclxuXHJcbiAgICAgICAgc2Nyb2xsQ2hhbmdlOiBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgdmFyIHdpbmRvd1RvcCA9IHRoaXMuJHdpbi5zY3JvbGxUb3AoKTtcclxuICAgICAgICAgICAgdmFyIHBvc2l0aW9uID0gdGhpcy5nZXRTZWN0aW9uKHdpbmRvd1RvcCk7XHJcbiAgICAgICAgICAgIHZhciAkcGFyZW50O1xyXG5cclxuICAgICAgICAgICAgLy9JZiB0aGUgcG9zaXRpb24gaXMgc2V0XHJcbiAgICAgICAgICAgIGlmKHBvc2l0aW9uICE9PSBudWxsKSB7XHJcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gdGhpcy4kZWxlbS5maW5kKCdhW2hyZWYkPVwiIycgKyBwb3NpdGlvbiArICdcIl0nKS5wYXJlbnQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL0lmIGl0J3Mgbm90IGFscmVhZHkgdGhlIGN1cnJlbnQgc2VjdGlvblxyXG4gICAgICAgICAgICAgICAgaWYoISRwYXJlbnQuaGFzQ2xhc3ModGhpcy5jb25maWcuY3VycmVudENsYXNzKSkge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vQ2hhbmdlIHRoZSBoaWdobGlnaHRlZCBuYXYgaXRlbVxyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuYWRqdXN0TmF2KHRoaXMsICRwYXJlbnQpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL0lmIHRoZXJlIGlzIGEgc2Nyb2xsQ2hhbmdlIGNhbGxiYWNrXHJcbiAgICAgICAgICAgICAgICAgICAgaWYodGhpcy5jb25maWcuc2Nyb2xsQ2hhbmdlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMuY29uZmlnLnNjcm9sbENoYW5nZSgkcGFyZW50KTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9LFxyXG5cclxuICAgICAgICBzY3JvbGxUbzogZnVuY3Rpb24odGFyZ2V0LCBjYWxsYmFjaykge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgICAgIHZhciBvZmZzZXQgPSAkKHRhcmdldCkub2Zmc2V0KCkudG9wO1xyXG5cclxuICAgICAgICAgICAgaWYoICQodGFyZ2V0KS5jbG9zZXN0KCcuY3J0LXBhcGVyLWxheWVycycpLmhhc0NsYXNzKCdjcnQtYW5pbWF0ZScpICl7XHJcbiAgICAgICAgICAgICAgICBvZmZzZXQgPSBvZmZzZXQgLSAxNDU7XHJcbiAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICBvZmZzZXQgPSBvZmZzZXQgLSA0NTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy8gU2Nyb2xsIHRvIG9mZnNldFxyXG4gICAgICAgICAgICAkKCdodG1sLCBib2R5JykuYW5pbWF0ZSh7XHJcbiAgICAgICAgICAgICAgICBzY3JvbGxUb3A6IG9mZnNldFxyXG4gICAgICAgICAgICB9LCB0aGlzLmNvbmZpZy5zY3JvbGxTcGVlZCwgdGhpcy5jb25maWcuZWFzaW5nLCBjYWxsYmFjayk7XHJcbiAgICAgICAgfSxcclxuXHJcbiAgICAgICAgdW5iaW5kSW50ZXJ2YWw6IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICBjbGVhckludGVydmFsKHRoaXMudCk7XHJcbiAgICAgICAgICAgIHRoaXMuJHdpbi51bmJpbmQoJ3Njcm9sbC5vbmVQYWdlTmF2Jyk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuXHJcbiAgICBPbmVQYWdlTmF2LmRlZmF1bHRzID0gT25lUGFnZU5hdi5wcm90b3R5cGUuZGVmYXVsdHM7XHJcblxyXG4gICAgJC5mbi5vbmVQYWdlTmF2ID0gZnVuY3Rpb24ob3B0aW9ucykge1xyXG4gICAgICAgIHJldHVybiB0aGlzLmVhY2goZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgIG5ldyBPbmVQYWdlTmF2KHRoaXMsIG9wdGlvbnMpLmluaXQoKTtcclxuICAgICAgICB9KTtcclxuICAgIH07XHJcblxyXG59KSggalF1ZXJ5LCB3aW5kb3cgLCBkb2N1bWVudCApOyIsIi8qKlxyXG4gKiBDZXJ0eSBGdW5jdGlvbnNcclxuICovXHJcblxyXG4vKiBJbml0IEdsb2JhbCBWYXJpYWJsZXMgKi9cclxuY2VydHkuaW5pdEdsb2JhbFZhcnMgPSBmdW5jdGlvbigpe1xyXG4gICAgLy8gZ2V0IGRvY3VtZW50IDxodG1sPlxyXG4gICAgdGhpcy52YXJzLmh0bWwgPSBqUXVlcnkoJ2h0bWwnKTtcclxuXHJcbiAgICAvLyBnZXQgZG9jdW1lbnQgPGJvZHk+XHJcbiAgICB0aGlzLnZhcnMuYm9keSA9IGpRdWVyeSgnYm9keScpO1xyXG5cclxuICAgIC8vIGdldCBkb2N1bWVudCAjZm9vdGVyXHJcbiAgICB0aGlzLnZhcnMuZm9vdGVyID0galF1ZXJ5KCcjY3J0Rm9vdGVyJyk7XHJcblxyXG4gICAgLy8gZ2V0IHdpbmRvdyBXaWR0aFxyXG4gICAgdGhpcy52YXJzLndpbmRvd1cgPSBqUXVlcnkod2luZG93KS53aWR0aCgpO1xyXG5cclxuICAgIC8vIGdldCB3aW5kb3cgaGVpZ2h0XHJcbiAgICB0aGlzLnZhcnMud2luZG93SCA9IGpRdWVyeSh3aW5kb3cpLmhlaWdodCgpO1xyXG5cclxuICAgIC8vIGdldCB3aW5kb3cgc2Nyb2xsIHRvcFxyXG4gICAgdGhpcy52YXJzLndpbmRvd1Njcm9sbFRvcCA9IGpRdWVyeSh3aW5kb3cpLnNjcm9sbFRvcCgpO1xyXG5cclxuICAgIC8vIGRldGVjdCBkZXZpY2UgdHlwZVxyXG4gICAgaWYgKC9BbmRyb2lkfHdlYk9TfGlQaG9uZXxpUGFkfGlQb2R8QmxhY2tCZXJyeXxJRU1vYmlsZXxPcGVyYSBNaW5pL2kudGVzdChuYXZpZ2F0b3IudXNlckFnZW50KSkge1xyXG4gICAgICAgIHRoaXMudmFycy5tb2JpbGUgPSB0cnVlO1xyXG4gICAgICAgIHRoaXMudmFycy5odG1sLmFkZENsYXNzKCdtb2JpbGUnKTtcclxuICAgIH0gZWxzZSB7XHJcbiAgICAgICAgdGhpcy52YXJzLm1vYmlsZSA9IGZhbHNlO1xyXG4gICAgICAgIHRoaXMudmFycy5odG1sLmFkZENsYXNzKCdkZXNrdG9wJyk7XHJcbiAgICB9XHJcbn07XHJcblxyXG4vKiBMb2NrIFdpbmRvdyBTY3JvbGwgKi9cclxuY2VydHkubG9ja1Njcm9sbCA9IGZ1bmN0aW9uKCl7XHJcbiAgICB2YXIgaW5pdFdpZHRoID0gY2VydHkudmFycy5odG1sLm91dGVyV2lkdGgoKTtcclxuICAgIHZhciBpbml0SGVpZ2h0ID0gY2VydHkudmFycy5ib2R5Lm91dGVySGVpZ2h0KCk7XHJcblxyXG4gICAgdmFyIHNjcm9sbFBvc2l0aW9uID0gW1xyXG4gICAgICAgIHNlbGYucGFnZVhPZmZzZXQgfHwgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNjcm9sbExlZnQgfHwgZG9jdW1lbnQuYm9keS5zY3JvbGxMZWZ0LFxyXG4gICAgICAgIHNlbGYucGFnZVlPZmZzZXQgfHwgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnNjcm9sbFRvcCB8fCBkb2N1bWVudC5ib2R5LnNjcm9sbFRvcFxyXG4gICAgXTtcclxuXHJcbiAgICBjZXJ0eS52YXJzLmh0bWwuZGF0YSgnc2Nyb2xsLXBvc2l0aW9uJywgc2Nyb2xsUG9zaXRpb24pO1xyXG4gICAgY2VydHkudmFycy5odG1sLmRhdGEoJ3ByZXZpb3VzLW92ZXJmbG93JywgY2VydHkudmFycy5odG1sLmNzcygnb3ZlcmZsb3cnKSk7XHJcbiAgICBjZXJ0eS52YXJzLmh0bWwuY3NzKCdvdmVyZmxvdycsICdoaWRkZW4nKTtcclxuICAgIHdpbmRvdy5zY3JvbGxUbyhzY3JvbGxQb3NpdGlvblswXSwgc2Nyb2xsUG9zaXRpb25bMV0pO1xyXG5cclxuICAgIHZhciBtYXJnaW5SID0gY2VydHkudmFycy5ib2R5Lm91dGVyV2lkdGgoKSAtIGluaXRXaWR0aDtcclxuICAgIHZhciBtYXJnaW5CID0gY2VydHkudmFycy5ib2R5Lm91dGVySGVpZ2h0KCkgLSBpbml0SGVpZ2h0O1xyXG4gICAgY2VydHkudmFycy5ib2R5LmNzcyh7J21hcmdpbi1yaWdodCc6IG1hcmdpblIsICdtYXJnaW4tYm90dG9tJzogbWFyZ2luQn0pO1xyXG4gICAgY2VydHkudmFycy5odG1sLmFkZENsYXNzKCdsb2NrLXNjcm9sbCcpO1xyXG59O1xyXG5cclxuLyogVW5sb2NrIFdpbmRvdyBTY3JvbGwgKi9cclxuY2VydHkudW5sb2NrU2Nyb2xsID0gZnVuY3Rpb24oKXtcclxuICAgIGNlcnR5LnZhcnMuaHRtbC5jc3MoJ292ZXJmbG93JywgY2VydHkudmFycy5odG1sLmRhdGEoJ3ByZXZpb3VzLW92ZXJmbG93JykpO1xyXG4gICAgdmFyIHNjcm9sbFBvc2l0aW9uID0gY2VydHkudmFycy5odG1sLmRhdGEoJ3Njcm9sbC1wb3NpdGlvbicpO1xyXG4gICAgd2luZG93LnNjcm9sbFRvKHNjcm9sbFBvc2l0aW9uWzBdLCBzY3JvbGxQb3NpdGlvblsxXSk7XHJcblxyXG4gICAgY2VydHkudmFycy5ib2R5LmNzcyh7J21hcmdpbi1yaWdodCc6IDAsICdtYXJnaW4tYm90dG9tJzogMH0pO1xyXG4gICAgY2VydHkudmFycy5odG1sLnJlbW92ZUNsYXNzKCdsb2NrLXNjcm9sbCcpO1xyXG59O1xyXG5cclxuLyogRGV0ZWN0IERldmljZSBUeXBlICovXHJcbmZ1bmN0aW9uIGFjZV9kZXRlY3RfZGV2aWNlX3R5cGUoKSB7XHJcbiAgICBpZiAoL0FuZHJvaWR8d2ViT1N8aVBob25lfGlQYWR8aVBvZHxCbGFja0JlcnJ5fElFTW9iaWxlfE9wZXJhIE1pbmkvaS50ZXN0KG5hdmlnYXRvci51c2VyQWdlbnQpKSB7XHJcbiAgICAgICAgYWNlLm1vYmlsZSA9IHRydWU7XHJcbiAgICAgICAgYWNlLmh0bWwuYWRkQ2xhc3MoJ2NydC1tb2JpbGUnKTtcclxuICAgIH0gZWxzZSB7XHJcbiAgICAgICAgYWNlLm1vYmlsZSA9IGZhbHNlO1xyXG4gICAgICAgIGFjZS5odG1sLmFkZENsYXNzKCdjcnQtZGVza3RvcCcpO1xyXG4gICAgfVxyXG59XHJcblxyXG4vKiBDZXJ0eSBPdmVybGF5ICovXHJcbmZ1bmN0aW9uIGFjZV9hcHBlbmRfb3ZlcmxheSgpIHtcclxuICAgIGFjZS5ib2R5LmFwcGVuZChhY2Uub3ZlcmxheS5vYmopO1xyXG5cclxuICAgIC8vIE1ha2UgdGhlIGVsZW1lbnQgZnVsbHkgdHJhbnNwYXJlbnRcclxuICAgIGFjZS5vdmVybGF5Lm9ialswXS5zdHlsZS5vcGFjaXR5ID0gMDtcclxuXHJcbiAgICAvLyBNYWtlIHN1cmUgdGhlIGluaXRpYWwgc3RhdGUgaXMgYXBwbGllZFxyXG4gICAgd2luZG93LmdldENvbXB1dGVkU3R5bGUoYWNlLm92ZXJsYXkub2JqWzBdKS5vcGFjaXR5O1xyXG5cclxuICAgIC8vIEZhZGUgaXQgaW5cclxuICAgIGFjZS5vdmVybGF5Lm9ialswXS5zdHlsZS5vcGFjaXR5ID0gMTtcclxufVxyXG5cclxuZnVuY3Rpb24gYWNlX3JlbW92ZV9vdmVybGF5KCkge1xyXG4gICAgLy8gRmFkZSBpdCBvdXRcclxuICAgIGFjZS5vdmVybGF5Lm9ialswXS5zdHlsZS5vcGFjaXR5ID0gMDtcclxuXHJcbiAgICAvLyBSZW1vdmUgb3ZlcmxheVxyXG4gICAgYWNlLm92ZXJsYXkub2JqLnJlbW92ZSgpO1xyXG59XHJcblxyXG4vKiBDZXJ0eSBMb2NrIFNjcm9sbCAqL1xyXG5mdW5jdGlvbiBhY2VfbG9ja19zY3JvbGwoKSB7XHJcbiAgICB2YXIgaW5pdFdpZHRoID0gYWNlLmh0bWwub3V0ZXJXaWR0aCgpO1xyXG4gICAgdmFyIGluaXRIZWlnaHQgPSBhY2UuYm9keS5vdXRlckhlaWdodCgpO1xyXG5cclxuICAgIHZhciBzY3JvbGxQb3NpdGlvbiA9IFtcclxuICAgICAgICBzZWxmLnBhZ2VYT2Zmc2V0IHx8IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zY3JvbGxMZWZ0IHx8IGRvY3VtZW50LmJvZHkuc2Nyb2xsTGVmdCxcclxuICAgICAgICBzZWxmLnBhZ2VZT2Zmc2V0IHx8IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3AgfHwgZG9jdW1lbnQuYm9keS5zY3JvbGxUb3BcclxuICAgIF07XHJcblxyXG4gICAgYWNlLmh0bWwuZGF0YSgnc2Nyb2xsLXBvc2l0aW9uJywgc2Nyb2xsUG9zaXRpb24pO1xyXG4gICAgYWNlLmh0bWwuZGF0YSgncHJldmlvdXMtb3ZlcmZsb3cnLCBhY2UuaHRtbC5jc3MoJ292ZXJmbG93JykpO1xyXG4gICAgYWNlLmh0bWwuY3NzKCdvdmVyZmxvdycsICdoaWRkZW4nKTtcclxuICAgIHdpbmRvdy5zY3JvbGxUbyhzY3JvbGxQb3NpdGlvblswXSwgc2Nyb2xsUG9zaXRpb25bMV0pO1xyXG5cclxuICAgIHZhciBtYXJnaW5SID0gYWNlLmJvZHkub3V0ZXJXaWR0aCgpIC0gaW5pdFdpZHRoO1xyXG4gICAgdmFyIG1hcmdpbkIgPSBhY2UuYm9keS5vdXRlckhlaWdodCgpIC0gaW5pdEhlaWdodDtcclxuICAgIGFjZS5ib2R5LmNzcyh7J21hcmdpbi1yaWdodCc6IG1hcmdpblIsICdtYXJnaW4tYm90dG9tJzogbWFyZ2luQn0pO1xyXG4gICAgYWNlLmh0bWwuYWRkQ2xhc3MoJ2NydC1sb2NrLXNjcm9sbCcpO1xyXG59XHJcblxyXG4vKiBDZXJ0eSBVbmxvY2sgU2Nyb2xsICovXHJcbmZ1bmN0aW9uIGFjZV91bmxvY2tfc2Nyb2xsKCkge1xyXG4gICAgYWNlLmh0bWwuY3NzKCdvdmVyZmxvdycsIGFjZS5odG1sLmRhdGEoJ3ByZXZpb3VzLW92ZXJmbG93JykpO1xyXG4gICAgdmFyIHNjcm9sbFBvc2l0aW9uID0gYWNlLmh0bWwuZGF0YSgnc2Nyb2xsLXBvc2l0aW9uJyk7XHJcbiAgICB3aW5kb3cuc2Nyb2xsVG8oc2Nyb2xsUG9zaXRpb25bMF0sIHNjcm9sbFBvc2l0aW9uWzFdKTtcclxuXHJcbiAgICBhY2UuYm9keS5jc3MoeydtYXJnaW4tcmlnaHQnOiAwLCAnbWFyZ2luLWJvdHRvbSc6IDB9KTtcclxuICAgIGFjZS5odG1sLnJlbW92ZUNsYXNzKCdjcnQtbG9jay1zY3JvbGwnKTtcclxufVxyXG5cclxuLyogQ2VydHkgQ2xvc2UgU2lkZWJhciAqL1xyXG5mdW5jdGlvbiBhY2Vfb3Blbl9zaWRlYmFyKCkge1xyXG4gICAgYWNlLmh0bWwuYWRkQ2xhc3MoJ2NydC1zaWRlYmFyLW9wZW5lZCcpO1xyXG4gICAgYWNlX2FwcGVuZF9vdmVybGF5KCk7XHJcbiAgICBhY2VfbG9ja19zY3JvbGwoKTtcclxufVxyXG5cclxuZnVuY3Rpb24gYWNlX2Nsb3NlX3NpZGViYXIoKSB7XHJcbiAgICBhY2UuaHRtbC5yZW1vdmVDbGFzcygnY3J0LXNpZGViYXItb3BlbmVkJyk7XHJcbiAgICBhY2VfcmVtb3ZlX292ZXJsYXkoKTtcclxuICAgIGFjZV91bmxvY2tfc2Nyb2xsKCk7XHJcbn1cclxuXHJcbi8qIENlcnR5IFByb2dyZXNzIENpcmNsZSAqL1xyXG5mdW5jdGlvbiBhY2VfcHJvZ3Jlc3NfY2hhcnQoZWxlbWVudCwgdGV4dCwgdmFsdWUsIGR1cmF0aW9uKSB7XHJcbiAgICAvLyBXZSBoYXZlIHVuZGVmaW5lZCB0ZXh0IHdoZW4gdXNlciBkaWRudG4gZmlsbCB0ZXh0IGZpZWxkIGZyb20gYWRtaW5cclxuICAgIGlmICh0eXBlb2YgdGV4dCA9PT0gXCJ1bmRlZmluZWRcIikgeyB0ZXh0ID0gXCJcIjsgfVxyXG5cclxuICAgIHZhciBjaXJjbGUgPSBuZXcgUHJvZ3Jlc3NCYXIuQ2lyY2xlKGVsZW1lbnQsIHtcclxuICAgICAgICBjb2xvcjogY2VydHkudmFycy50aGVtZUNvbG9yLFxyXG4gICAgICAgIHN0cm9rZVdpZHRoOiA1LFxyXG4gICAgICAgIHRyYWlsV2lkdGg6IDAsXHJcbiAgICAgICAgdGV4dDoge1xyXG4gICAgICAgICAgICB2YWx1ZTogdGV4dCxcclxuICAgICAgICAgICAgY2xhc3NOYW1lOiAncHJvZ3Jlc3MtdGV4dCcsXHJcbiAgICAgICAgICAgIHN0eWxlOiB7XHJcbiAgICAgICAgICAgICAgICB0b3A6ICc1MCUnLFxyXG4gICAgICAgICAgICAgICAgbGVmdDogJzUwJScsXHJcbiAgICAgICAgICAgICAgICBjb2xvcjogY2VydHkucHJvZ3Jlc3MudGV4dENvbG9yLFxyXG4gICAgICAgICAgICAgICAgcG9zaXRpb246ICdhYnNvbHV0ZScsXHJcbiAgICAgICAgICAgICAgICBtYXJnaW46IDAsXHJcbiAgICAgICAgICAgICAgICBwYWRkaW5nOiAwLFxyXG4gICAgICAgICAgICAgICAgdHJhbnNmb3JtOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgcHJlZml4OiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgIHZhbHVlOiAndHJhbnNsYXRlKC01MCUsIC01MCUpJ1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBhdXRvU3R5bGVDb250YWluZXI6IHRydWUsXHJcbiAgICAgICAgICAgIGFsaWduVG9Cb3R0b206IHRydWVcclxuICAgICAgICB9LFxyXG4gICAgICAgIHN2Z1N0eWxlOiB7XHJcbiAgICAgICAgICAgIGRpc3BsYXk6ICdibG9jaycsXHJcbiAgICAgICAgICAgIHdpZHRoOiAnMTAwJSdcclxuICAgICAgICB9LFxyXG4gICAgICAgIGR1cmF0aW9uOiBkdXJhdGlvbixcclxuICAgICAgICBlYXNpbmc6ICdlYXNlT3V0J1xyXG4gICAgfSk7XHJcblxyXG4gICAgY2lyY2xlLmFuaW1hdGUodmFsdWUpOyAvLyBOdW1iZXIgZnJvbSAwLjAgdG8gMS4wXHJcbn1cclxuXHJcbi8qIENlcnR5IFByb2dyZXNzIExpbmUgKi9cclxuZnVuY3Rpb24gYWNlX3Byb2dyZXNzX2xpbmUoZWxlbWVudCwgdGV4dCwgdmFsdWUsIGR1cmF0aW9uKSB7XHJcbiAgICAvLyBXZSBoYXZlIHVuZGVmaW5lZCB0ZXh0IHdoZW4gdXNlciBkaWRudG4gZmlsbCB0ZXh0IGZpZWxkIGZyb20gYWRtaW5cclxuICAgIGlmICh0eXBlb2YgdGV4dCA9PT0gXCJ1bmRlZmluZWRcIikgeyB0ZXh0ID0gXCJcIjsgfVxyXG4gICAgXHJcbiAgICB2YXIgbGluZSA9IG5ldyBQcm9ncmVzc0Jhci5MaW5lKGVsZW1lbnQsIHtcclxuICAgICAgICBzdHJva2VXaWR0aDogNCxcclxuICAgICAgICBlYXNpbmc6ICdlYXNlSW5PdXQnLFxyXG4gICAgICAgIGR1cmF0aW9uOiBkdXJhdGlvbixcclxuICAgICAgICBjb2xvcjogY2VydHkudmFycy50aGVtZUNvbG9yLFxyXG4gICAgICAgIHRyYWlsQ29sb3I6IGNlcnR5LnByb2dyZXNzLnRyYWlsQ29sb3IsXHJcbiAgICAgICAgdHJhaWxXaWR0aDogNCxcclxuICAgICAgICBzdmdTdHlsZToge1xyXG4gICAgICAgICAgICB3aWR0aDogJzEwMCUnLFxyXG4gICAgICAgICAgICBoZWlnaHQ6ICcxMDAlJ1xyXG4gICAgICAgIH0sXHJcbiAgICAgICAgdGV4dDoge1xyXG4gICAgICAgICAgICB2YWx1ZTogdGV4dCxcclxuICAgICAgICAgICAgY2xhc3NOYW1lOiAncHJvZ3Jlc3MtdGV4dCcsXHJcbiAgICAgICAgICAgIHN0eWxlOiB7XHJcbiAgICAgICAgICAgICAgICB0b3A6ICctMjVweCcsXHJcbiAgICAgICAgICAgICAgICByaWdodDogJzAnLFxyXG4gICAgICAgICAgICAgICAgY29sb3I6IGNlcnR5LnByb2dyZXNzLnRleHRDb2xvcixcclxuICAgICAgICAgICAgICAgIHBvc2l0aW9uOiAnYWJzb2x1dGUnLFxyXG4gICAgICAgICAgICAgICAgbWFyZ2luOiAwLFxyXG4gICAgICAgICAgICAgICAgcGFkZGluZzogMCxcclxuICAgICAgICAgICAgICAgIHRyYW5zZm9ybToge1xyXG4gICAgICAgICAgICAgICAgICAgIHByZWZpeDogdHJ1ZSxcclxuICAgICAgICAgICAgICAgICAgICB2YWx1ZTogJ3RyYW5zbGF0ZSgwLCAwKSdcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgYXV0b1N0eWxlQ29udGFpbmVyOiB0cnVlXHJcbiAgICAgICAgfVxyXG4gICAgfSk7XHJcblxyXG4gICAgbGluZS5hbmltYXRlKHZhbHVlKTsgIC8vIE51bWJlciBmcm9tIDAuMCB0byAxLjBcclxufVxyXG5cclxuLyogQ2VydHkgRWxlbWVudCBJbiBWaWV3cG9ydCAqL1xyXG5mdW5jdGlvbiBhY2VfaXNfZWxlbV9pbl92aWV3cG9ydChlbCwgdnBhcnQpIHtcclxuICAgIHZhciByZWN0ID0gZWxbMF0uZ2V0Qm91bmRpbmdDbGllbnRSZWN0KCk7XHJcblxyXG4gICAgcmV0dXJuIChcclxuICAgIHJlY3QuYm90dG9tID49IDAgJiZcclxuICAgIHJlY3QucmlnaHQgPj0gMCAmJlxyXG4gICAgcmVjdC50b3AgKyB2cGFydCA8PSAod2luZG93LmlubmVySGVpZ2h0IHx8IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5jbGllbnRIZWlnaHQpICYmXHJcbiAgICByZWN0LmxlZnQgPD0gKHdpbmRvdy5pbm5lcldpZHRoIHx8IGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5jbGllbnRXaWR0aClcclxuICAgICk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIGFjZV9pc19lbGVtc19pbl92aWV3cG9ydChlbGVtcywgdnBhcnQpIHtcclxuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgZWxlbXMubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICB2YXIgaXRlbSA9IGpRdWVyeShlbGVtc1tpXSk7XHJcblxyXG4gICAgICAgIGlmIChpdGVtLmhhc0NsYXNzKCdjcnQtYW5pbWF0ZScpICYmIGFjZV9pc19lbGVtX2luX3ZpZXdwb3J0KGl0ZW0sIHZwYXJ0KSkge1xyXG4gICAgICAgICAgICBpdGVtLnJlbW92ZUNsYXNzKCdjcnQtYW5pbWF0ZScpLmFkZENsYXNzKCdjcnQtYW5pbWF0ZWQnKTtcclxuXHJcbiAgICAgICAgICAgIC8vIEFuaW1hdGUgQ2lyY2xlIENoYXJ0XHJcbiAgICAgICAgICAgIGlmKGl0ZW0uaGFzQ2xhc3MoJ3Byb2dyZXNzLWNoYXJ0Jykpe1xyXG4gICAgICAgICAgICAgICAgdmFyIGNoYXJ0ID0gaXRlbS5maW5kKCcucHJvZ3Jlc3MtYmFyJyk7XHJcbiAgICAgICAgICAgICAgICBhY2VfcHJvZ3Jlc3NfY2hhcnQoY2hhcnRbMF0sIGNoYXJ0LmRhdGEoJ3RleHQnKSwgY2hhcnQuZGF0YSgndmFsdWUnKSwgMTAwMCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vIEFuaW1hdGUgTGluZSBDaGFydFxyXG4gICAgICAgICAgICBpZihpdGVtLmhhc0NsYXNzKCdwcm9ncmVzcy1saW5lJykpe1xyXG4gICAgICAgICAgICAgICAgdmFyIGxpbmUgPSBpdGVtLmZpbmQoJy5wcm9ncmVzcy1iYXInKTtcclxuICAgICAgICAgICAgICAgIGFjZV9wcm9ncmVzc19saW5lKGxpbmVbMF0sIGxpbmUuZGF0YSgndGV4dCcpLCBsaW5lLmRhdGEoJ3ZhbHVlJyksIDEwMDApO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG59XHJcblxyXG5mdW5jdGlvbiBhY2VfYXBwZWFyX2VsZW1zKGVsZW1zLCB2cGFydCkge1xyXG4gICAgYWNlX2lzX2VsZW1zX2luX3ZpZXdwb3J0KGVsZW1zLCB2cGFydCk7XHJcblxyXG4gICAgalF1ZXJ5KHdpbmRvdykuc2Nyb2xsKGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBhY2VfaXNfZWxlbXNfaW5fdmlld3BvcnQoZWxlbXMsIHZwYXJ0KTtcclxuICAgIH0pO1xyXG5cclxuICAgIGpRdWVyeSh3aW5kb3cpLnJlc2l6ZShmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgYWNlX2lzX2VsZW1zX2luX3ZpZXdwb3J0KGVsZW1zLCB2cGFydCk7XHJcbiAgICB9KTtcclxufVxyXG5cclxuLyogQ2VydHkgR29vZ2xlIE1hcCAqL1xyXG5mdW5jdGlvbiBpbml0aWFsaXNlR29vZ2xlTWFwKG1hcFN0eWxlcykge1xyXG4gICAgdmFyIGxhdGxuZztcclxuICAgIHZhciBsYXQgPSA0NC41NDAzO1xyXG4gICAgdmFyIGxuZyA9IC03OC41NDYzO1xyXG4gICAgdmFyIG1hcCA9IGpRdWVyeSgnI21hcCcpO1xyXG4gICAgdmFyIG1hcENhbnZhcyA9IG1hcC5nZXQoMCk7XHJcbiAgICB2YXIgbWFwX3N0eWxlcyA9IGpRdWVyeS5wYXJzZUpTT04obWFwU3R5bGVzKTtcclxuXHJcbiAgICBpZiAobWFwLmRhdGEoXCJsYXRpdHVkZVwiKSkgbGF0ID0gbWFwLmRhdGEoXCJsYXRpdHVkZVwiKTtcclxuICAgIGlmIChtYXAuZGF0YShcImxvbmdpdHVkZVwiKSkgbG5nID0gbWFwLmRhdGEoXCJsb25naXR1ZGVcIik7XHJcblxyXG4gICAgbGF0bG5nID0gbmV3IGdvb2dsZS5tYXBzLkxhdExuZyhsYXQsIGxuZyk7XHJcblxyXG4gICAgLy8gTWFwIE9wdGlvbnNcclxuICAgIHZhciBtYXBPcHRpb25zID0ge1xyXG4gICAgICAgIHpvb206IDE0LFxyXG4gICAgICAgIGNlbnRlcjogbGF0bG5nLFxyXG4gICAgICAgIHNjcm9sbHdoZWVsOiB0cnVlLFxyXG4gICAgICAgIG1hcFR5cGVJZDogZ29vZ2xlLm1hcHMuTWFwVHlwZUlkLlJPQURNQVAsXHJcbiAgICAgICAgc3R5bGVzOiBtYXBfc3R5bGVzXHJcbiAgICB9O1xyXG5cclxuICAgIC8vIENyZWF0ZSB0aGUgTWFwXHJcbiAgICBtYXAgPSBuZXcgZ29vZ2xlLm1hcHMuTWFwKG1hcENhbnZhcywgbWFwT3B0aW9ucyk7XHJcblxyXG4gICAgdmFyIG1hcmtlciA9IG5ldyBnb29nbGUubWFwcy5NYXJrZXIoe1xyXG4gICAgICAgIG1hcDogbWFwLFxyXG4gICAgICAgIHBvc2l0aW9uOiBsYXRsbmcsXHJcbiAgICAgICAgaWNvbjoge1xyXG4gICAgICAgICAgICBwYXRoOiAnTTEyNSA0MTAgYy01NiAtNzIgLTExMSAtMTc2IC0xMjAgLTIyNCAtNyAtMzYgMTEgLTgzIDQ5IC0xMjQgNzYgLTg1IDIyMyAtNjcgMjcwIDMxIDI4IDYwIDI5IDg4IDYgMTUwIC0xOSA1MSAtMTIyIDIwNSAtMTQ4IDIyMSAtNiAzIC0zMiAtMjEgLTU3IC01NHogbTExMCAtMTc1IGMzNSAtMzQgMzMgLTc4IC00IC0xMTYgLTM1IC0zNSAtNzEgLTM3IC0xMDUgLTcgLTQwIDM1IC00MyA3OCAtMTEgMTE2IDM0IDQxIDg0IDQ0IDEyMCA3eicsXHJcbiAgICAgICAgICAgIGZpbGxDb2xvcjogY2VydHlfdmFyc19mcm9tX1dQLnRoZW1lQ29sb3IsXHJcbiAgICAgICAgICAgIGZpbGxPcGFjaXR5OiAxLFxyXG4gICAgICAgICAgICBzY2FsZTogMC4xLFxyXG4gICAgICAgICAgICBzdHJva2VDb2xvcjogY2VydHlfdmFyc19mcm9tX1dQLnRoZW1lQ29sb3IsXHJcbiAgICAgICAgICAgIHN0cm9rZVdlaWdodDogMSxcclxuICAgICAgICAgICAgYW5jaG9yOiBuZXcgZ29vZ2xlLm1hcHMuUG9pbnQoMTg1LCA1MDApXHJcbiAgICAgICAgfSxcclxuICAgICAgICB0aXRsZTogJ0hlbGxvIFdvcmxkISdcclxuICAgIH0pO1xyXG5cclxuICAgIC8qdmFyIG1hcmtlciA9IG5ldyBNYXJrZXIoe1xyXG4gICAgIG1hcDogbWFwLFxyXG4gICAgIHBvc2l0aW9uOiBsYXRsbmcsXHJcbiAgICAgaWNvbjoge1xyXG4gICAgIHBhdGg6IFNRVUFSRV9QSU4sXHJcbiAgICAgZmlsbENvbG9yOiAnJyxcclxuICAgICBmaWxsT3BhY2l0eTogMCxcclxuICAgICBzdHJva2VDb2xvcjogJycsXHJcbiAgICAgc3Ryb2tlV2VpZ2h0OiAwXHJcbiAgICAgfSxcclxuICAgICBtYXBfaWNvbl9sYWJlbDogJzxzcGFuIGNsYXNzPVwibWFwLWljb24gbWFwLWljb24tcG9zdGFsLWNvZGVcIj48L3NwYW4+J1xyXG4gICAgIH0pOyovXHJcblxyXG4gICAgLy8gS2VlcCBNYXJrZXIgaW4gQ2VudGVyXHJcbiAgICBnb29nbGUubWFwcy5ldmVudC5hZGREb21MaXN0ZW5lcih3aW5kb3csICdyZXNpemUnLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgbWFwLnNldENlbnRlcihsYXRsbmcpO1xyXG4gICAgfSk7XHJcbn0iLCIvKipcclxuICogQ2VydHkgTmF2aWdhdGlvblxyXG4gKi9cclxuXHJcbi8vIE5hdmlnYXRpb24gV2l0aCBTY3JvbGwgYW5kIEFycm93XHJcbmNlcnR5Lm5hdi5pbml0U2Nyb2xsID0gZnVuY3Rpb24oIGVsICl7XHJcbiAgICAvLyBTZXQgTmF2IEhlaWdodFxyXG4gICAgLy8gY2VydHkubmF2LnNjcm9sbCA9IGVsO1xyXG5cclxuICAgIGVsLmhlaWdodChlbC5oZWlnaHQoKSkuYW5pbWF0ZSh7aGVpZ2h0OiBjZXJ0eS5uYXYuaGVpZ2h0fSwgNzAwLCBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAvLyBNb3VzZSBTY3JvbGxcclxuICAgICAgICBlbC5tQ3VzdG9tU2Nyb2xsYmFyKHtcclxuICAgICAgICAgICAgYXhpczogXCJ5XCIsXHJcbiAgICAgICAgICAgIHNjcm9sbGJhclBvc2l0aW9uOiBcIm91dHNpZGVcIlxyXG4gICAgICAgIH0pO1xyXG4gICAgfSk7XHJcblxyXG4gICAgLy8gQXJyb3cgU2Nyb2xsXHJcbiAgICBpZiAoY2VydHkubmF2LmFycm93KXtcclxuICAgICAgICBqUXVlcnkoXCIjY3J0TmF2VG9vbHNcIikucmVtb3ZlQ2xhc3MoJ2hpZGRlbicpO1xyXG5cclxuICAgICAgICBqUXVlcnkoXCIjY3J0TmF2QXJyb3dcIikub24oXCJjbGlja1wiLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIGVsLm1DdXN0b21TY3JvbGxiYXIoJ3Njcm9sbFRvJywgJy09JytjZXJ0eS5uYXYuaGVpZ2h0KTtcclxuICAgICAgICB9KTtcclxuICAgIH1cclxufTtcclxuXHJcbi8vIFN0aWNreSBOYXZpZ2F0aW9uXHJcbmNlcnR5Lm5hdi5leGlzdHMgPSBmYWxzZTtcclxuY2VydHkubmF2Lm1ha2VTdGlja3kgPSBmdW5jdGlvbigpe1xyXG5cclxuICAgIC8vIGNoZWNrIHN0aWNreSBvcHRpb24sIGRldmljZSB0eXBlIGFuZCBzY3JlZW4gc2l6ZVxyXG4gICAgaWYgKCB0aGlzLnN0aWNreS5hY3RpdmUgJiYgIWNlcnR5LnZhcnMubW9iaWxlICYmIE1vZGVybml6ci5tcSgnKG1pbi13aWR0aDogJyArIGNlcnR5LnZhcnMuc2NyZWVuTWQgKyAnKScpICkge1xyXG5cclxuICAgICAgICAvLyBjaGVjayBpZiBuYXYgbm9kZXMgZXhpc3RzXHJcbiAgICAgICAgaWYgKCB0aGlzLmV4aXN0cyApe1xyXG5cclxuICAgICAgICAgICAgLy8gY2hlY2sgaWYgd2luZG93IHNjcm9sbCBwYXNzIGVsZW1lbnRcclxuICAgICAgICAgICAgaWYgKCBjZXJ0eS52YXJzLndpbmRvd1Njcm9sbFRvcCA+IHRoaXMud3JhcC5vZmZzZXQoKS50b3AgKSB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLmVsLmNzcyh7XHJcbiAgICAgICAgICAgICAgICAgICAgJ3RvcCc6IHRoaXMuc3RpY2t5LnRvcCxcclxuICAgICAgICAgICAgICAgICAgICAnbGVmdCc6IHRoaXMud3JhcC5vZmZzZXQoKS5sZWZ0LFxyXG4gICAgICAgICAgICAgICAgICAgICd3aWR0aCc6IHRoaXMud3JhcC53aWR0aCgpLFxyXG4gICAgICAgICAgICAgICAgICAgICdib3R0b20nOiAnYXV0bycsXHJcbiAgICAgICAgICAgICAgICAgICAgJ3Bvc2l0aW9uJzogJ2ZpeGVkJ1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLmVsLmNzcyh7XHJcbiAgICAgICAgICAgICAgICAgICAgJ3RvcCc6ICcwJyxcclxuICAgICAgICAgICAgICAgICAgICAnbGVmdCc6ICdhdXRvJyxcclxuICAgICAgICAgICAgICAgICAgICAnd2lkdGgnOiAnYXV0bycsXHJcbiAgICAgICAgICAgICAgICAgICAgJ2JvdHRvbSc6ICdhdXRvJyxcclxuICAgICAgICAgICAgICAgICAgICAncG9zaXRpb24nOiAncmVsYXRpdmUnXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgIHRoaXMuZWwgPSBqUXVlcnkoJyNjcnROYXZJbm5lcicpO1xyXG4gICAgICAgICAgICB0aGlzLndyYXAgPSBqUXVlcnkoJyNjcnROYXZXcmFwJyk7XHJcblxyXG4gICAgICAgICAgICBpZiAoIHRoaXMuZWwubGVuZ3RoID4gMCAmJiB0aGlzLndyYXAubGVuZ3RoID4gMCApIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuZXhpc3RzID0gdHJ1ZTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgIH1cclxufTtcclxuXHJcbi8vIE5hdmlnYXRpb24gVG9vbHRpcHNcclxuY2VydHkubmF2LnRvb2x0aXAuZWwgPSAnJztcclxuY2VydHkubmF2LnRvb2x0aXAudGltZXIgPSAwO1xyXG5cclxuY2VydHkubmF2LnRvb2x0aXAuc2hvdyA9IGZ1bmN0aW9uKGN1cnJlbnQpe1xyXG4gICAgY2VydHkubmF2LnRvb2x0aXAudGltZXIgPSBzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHtcclxuXHJcbiAgICAgICAgY2VydHkubmF2LnRvb2x0aXAuZWwgPSBqUXVlcnkoJzxkaXYgY2xhc3M9XCJjcnQtdG9vbHRpcFwiPjwvZGl2PicpO1xyXG5cclxuICAgICAgICAvLyBJbml0IHZhcnNcclxuICAgICAgICB2YXIgdG9wID0gY3VycmVudC5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgdmFyIGxlZnQgPSBjdXJyZW50Lm9mZnNldCgpLmxlZnQ7XHJcbiAgICAgICAgdmFyIHJpZ2h0ID0gbGVmdCArIGN1cnJlbnQub3V0ZXJXaWR0aCgpO1xyXG4gICAgICAgIHZhciB3aWR0aCA9IGN1cnJlbnQub3V0ZXJXaWR0aCgpO1xyXG4gICAgICAgIHZhciBoZWlnaHQgPSA0O1xyXG5cclxuICAgICAgICAvLyBBcHBlbmQgdG9vbHRpcFxyXG4gICAgICAgIGNlcnR5LnZhcnMuYm9keS5hcHBlbmQoIGNlcnR5Lm5hdi50b29sdGlwLmVsICk7XHJcblxyXG4gICAgICAgIC8vIFNldCB0b29sdGlwIHRleHRcclxuICAgICAgICBjZXJ0eS5uYXYudG9vbHRpcC5lbC50ZXh0KCBjdXJyZW50LmRhdGEoJ3Rvb2x0aXAnKSApO1xyXG5cclxuICAgICAgICAvLyBQb3NpdGlvbmluZyB0b29sdGlwXHJcbiAgICAgICAgaWYgKHJpZ2h0ICsgY2VydHkubmF2LnRvb2x0aXAuZWwub3V0ZXJXaWR0aCgpIDwgY2VydHkudmFycy53aW5kb3dXKSB7XHJcbiAgICAgICAgICAgIGNlcnR5Lm5hdi50b29sdGlwLmVsLmFkZENsYXNzKCdhcnJvdy1sZWZ0JykuY3NzKHtcImxlZnRcIjogcmlnaHQgKyBcInB4XCIsIFwidG9wXCI6ICh0b3AgKyBoZWlnaHQpICsgXCJweFwifSk7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgY2VydHkubmF2LnRvb2x0aXAuZWwuYWRkQ2xhc3MoJ2Fycm93LXJpZ2h0IHRleHQtcmlnaHQnKS5jc3Moe1xyXG4gICAgICAgICAgICAgICAgXCJsZWZ0XCI6IChsZWZ0IC0gY2VydHkubmF2LnRvb2x0aXAuZWwub3V0ZXJXaWR0aCgpIC0gMTApICsgXCJweFwiLFxyXG4gICAgICAgICAgICAgICAgXCJ0b3BcIjogKHRvcCArIGhlaWdodCkgKyBcInB4XCJcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICAvLyBTaG93IFRvb2x0aXBcclxuICAgICAgICBjZXJ0eS5uYXYudG9vbHRpcC5lbC5mYWRlSW4oMTUwKTtcclxuXHJcbiAgICB9LCAxNTApO1xyXG59O1xyXG5cclxuY2VydHkubmF2LnRvb2x0aXAuaGlkZSA9IGZ1bmN0aW9uKCl7XHJcbiAgICBjbGVhclRpbWVvdXQoY2VydHkubmF2LnRvb2x0aXAudGltZXIpO1xyXG4gICAgaWYgKGNlcnR5Lm5hdi50b29sdGlwLmVsLmxlbmd0aCA+IDApIHtcclxuICAgICAgICBjZXJ0eS5uYXYudG9vbHRpcC5lbC5mYWRlT3V0KDE1MCwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICBjZXJ0eS5uYXYudG9vbHRpcC5lbC5yZW1vdmUoKTtcclxuICAgICAgICB9KTtcclxuICAgIH1cclxufTsiLCIvKipcclxuICogQ2VydHkgU2lkZSBCb3hcclxuICovXHJcbmNlcnR5LnNpZGVCb3guZXhpc3RzID0gZmFsc2U7XHJcbmNlcnR5LnNpZGVCb3gubWFrZVN0aWNreSA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgLy8gY2hlY2sgc3RpY2t5IG9wdGlvbiwgZGV2aWNlIHR5cGUgYW5kIHNjcmVlbiBzaXplXHJcbiAgICBpZiAoIHRoaXMuc3RpY2t5LmFjdGl2ZSAmJiAhY2VydHkudmFycy5tb2JpbGUgJiYgTW9kZXJuaXpyLm1xKCcobWluLXdpZHRoOiAnICsgY2VydHkudmFycy5zY3JlZW5NZCArICcpJykgKSB7XHJcblxyXG4gICAgICAgIC8vIGNoZWNrIGlmIG5hdiBub2RlcyBleGlzdHNcclxuICAgICAgICBpZiAoIHRoaXMuZXhpc3RzICl7XHJcblxyXG4gICAgICAgICAgICAvLyBjaGVjayBpZiB3aW5kb3cgc2Nyb2xsIHBhc3MgZWxlbWVudFxyXG4gICAgICAgICAgICBpZiAoIGNlcnR5LnZhcnMud2luZG93U2Nyb2xsVG9wID4gdGhpcy53cmFwLm9mZnNldCgpLnRvcCApIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuZWwuY3NzKHtcclxuICAgICAgICAgICAgICAgICAgICAndG9wJzogdGhpcy5zdGlja3kudG9wLFxyXG4gICAgICAgICAgICAgICAgICAgICdsZWZ0JzogdGhpcy53cmFwLm9mZnNldCgpLmxlZnQsXHJcbiAgICAgICAgICAgICAgICAgICAgJ3dpZHRoJzogdGhpcy53cmFwLndpZHRoKCksXHJcbiAgICAgICAgICAgICAgICAgICAgJ2JvdHRvbSc6ICdhdXRvJyxcclxuICAgICAgICAgICAgICAgICAgICAncG9zaXRpb24nOiAnZml4ZWQnXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuZWwuY3NzKHtcclxuICAgICAgICAgICAgICAgICAgICAndG9wJzogJzAnLFxyXG4gICAgICAgICAgICAgICAgICAgICdsZWZ0JzogJ2F1dG8nLFxyXG4gICAgICAgICAgICAgICAgICAgICd3aWR0aCc6ICdhdXRvJyxcclxuICAgICAgICAgICAgICAgICAgICAnYm90dG9tJzogJ2F1dG8nLFxyXG4gICAgICAgICAgICAgICAgICAgICdwb3NpdGlvbic6ICdyZWxhdGl2ZSdcclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgdGhpcy5lbCA9IGpRdWVyeSgnI2NydFNpZGVCb3gnKTtcclxuICAgICAgICAgICAgdGhpcy53cmFwID0galF1ZXJ5KCcjY3J0U2lkZUJveFdyYXAnKTtcclxuXHJcbiAgICAgICAgICAgIGlmICggdGhpcy5lbC5sZW5ndGggPiAwICYmIHRoaXMud3JhcC5sZW5ndGggPiAwICkge1xyXG4gICAgICAgICAgICAgICAgdGhpcy5leGlzdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG59OyIsIi8qKlxyXG4gKiBDZXJ0eSBTbGlkZXJcclxuICovXHJcblxyXG4vLyBTbGlkZXJcclxuY2VydHkuc2xpZGVyID0gZnVuY3Rpb24oc2xpZGVyKXtcclxuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgc2xpZGVyLmxlbmd0aDsgaSsrKSB7XHJcblxyXG4gICAgICAgaWYoIGpRdWVyeShzbGlkZXJbaV0pLmRhdGEoXCJpbml0XCIpICE9IFwibm9uZVwiICl7XHJcbiAgICAgICAgICAgalF1ZXJ5KHNsaWRlcltpXSkuc2xpY2soKTtcclxuICAgICAgIH1cclxuICAgIH1cclxufTtcclxuXHJcbi8vIENhcm91c2VsXHJcbmNlcnR5LmNhcm91c2VsID0gZnVuY3Rpb24oY2Fyb3VzZWwpe1xyXG4gICAgZm9yICh2YXIgaSA9IDA7IGkgPCBjYXJvdXNlbC5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgIGlmKCBqUXVlcnkoY2Fyb3VzZWxbaV0pLmRhdGEoXCJpbml0XCIpICE9PSBcIm5vbmVcIiApe1xyXG4gICAgICAgICAgICBqUXVlcnkoY2Fyb3VzZWxbaV0pLnNsaWNrKHtcclxuICAgICAgICAgICAgICAgIFwiZG90c1wiIDogdHJ1ZVxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcbiAgICB9XHJcbn07XHJcblxyXG4iLCIvKipcclxuICogQ2VydHkgUG9ydGZvbGlvXHJcbiAqL1xyXG5cclxuY2VydHkucG9ydGZvbGlvID0ge1xyXG4gICAgcG9wdXBTbGlkZXI6ICcnLFxyXG4gICAgcG9wdXBDYXJvdXNlbDogJycsXHJcbiAgICBjdXJyZW50RW1iZWQ6IGZhbHNlLFxyXG4gICAgY3VycmVudEVtYmVkVHlwZTogZmFsc2UsXHJcblxyXG4gICAgaW5pdEdyaWQ6IGZ1bmN0aW9uKGVsKXtcclxuICAgICAgICAvLyBpc290b3BlIGluaXRpYWxpemF0aW9uXHJcbiAgICAgICAgdmFyIGdyaWQgPSBlbC5pc290b3BlKHtcclxuICAgICAgICAgICAgaXNPcmlnaW5MZWZ0OiAhY2VydHkudmFycy5ydGwsXHJcbiAgICAgICAgICAgIGl0ZW1TZWxlY3RvcjogJy5wZi1ncmlkLWl0ZW0nLFxyXG4gICAgICAgICAgICBwZXJjZW50UG9zaXRpb246IHRydWUsXHJcbiAgICAgICAgICAgIG1hc29ucnk6IHtcclxuICAgICAgICAgICAgICAgIGNvbHVtbldpZHRoOiAnLnBmLWdyaWQtc2l6ZXInXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgLy8gbGF5b3V0IGlzb3RvcGUgYWZ0ZXIgZWFjaCBpbWFnZSBsb2Fkc1xyXG4gICAgICAgIGdyaWQuaW1hZ2VzTG9hZGVkKCkucHJvZ3Jlc3MoIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICBncmlkLmlzb3RvcGUoJ2xheW91dCcpO1xyXG4gICAgICAgIH0pO1xyXG5cclxuICAgICAgICAvLyBpc290b3BlIGZpbHRlclxyXG4gICAgICAgIHZhciBmaWx0ZXIgPSBlbC5jbG9zZXN0KCcucGYtd3JhcCcpLmZpbmQoJy5wZi1maWx0ZXInKTtcclxuICAgICAgICBpZiAoZmlsdGVyLmxlbmd0aCA+IDApIHtcclxuICAgICAgICAgICAgdmFyIGZpbHRlcl9idG4gPSBmaWx0ZXIuZmluZCgnYnV0dG9uJyk7XHJcbiAgICAgICAgICAgIHZhciBmaWx0ZXJfYnRuX2ZpcnN0ID0galF1ZXJ5KCcucGYtZmlsdGVyIGJ1dHRvbjpmaXJzdC1jaGlsZCcpO1xyXG5cclxuICAgICAgICAgICAgZmlsdGVyX2J0bl9maXJzdC5hZGRDbGFzcygnYWN0aXZlJyk7XHJcblxyXG4gICAgICAgICAgICBmaWx0ZXJfYnRuLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgICAgIGZpbHRlcl9idG4ucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xyXG4gICAgICAgICAgICAgICAgalF1ZXJ5KHRoaXMpLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgZmlsdGVyVmFsdWUgPSBqUXVlcnkodGhpcykuYXR0cignZGF0YS1maWx0ZXInKTtcclxuICAgICAgICAgICAgICAgIGdyaWQuaXNvdG9wZSh7IGZpbHRlcjogZmlsdGVyVmFsdWUgfSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuICAgIH0sXHJcblxyXG4gICAgb3BlblBvcHVwOiBmdW5jdGlvbihlbCl7XHJcbiAgICAgICAgLy8gYWRkIG9wZW5lZCBjbGFzcyBvbiBodG1sXHJcbiAgICAgICAgY2VydHkudmFycy5odG1sLmFkZENsYXNzKCdjcnQtcGYtcG9wdXAtb3BlbmVkJyk7XHJcblxyXG4gICAgICAgIC8vIGFwcGVuZCBwb3J0Zm9saW8gcG9wdXBcclxuICAgICAgICB0aGlzLnBvcHVwX3dyYXBwZXIgPSBqUXVlcnkoJzxkaXYgaWQ9XCJwZi1wb3B1cC13cmFwXCI+JytcclxuXHRcdFx0JzxidXR0b24gaWQ9XCJwZi1wb3B1cC1jbG9zZVwiPjxpIGNsYXNzPVwiY3J0LWljb24gY3J0LWljb24tY2xvc2VcIj48L2k+PC9idXR0b24+JytcclxuICAgICAgICAgICAgJzxkaXYgY2xhc3M9XCJwZi1wb3B1cC1pbm5lclwiPicrXHJcbiAgICAgICAgICAgICc8ZGl2IGNsYXNzPVwicGYtcG9wdXAtbWlkZGxlXCI+JytcclxuICAgICAgICAgICAgJzxkaXYgY2xhc3M9XCJwZi1wb3B1cC1jb250YWluZXJcIj4nK1xyXG4gICAgICAgICAgICAnPGJ1dHRvbiBpZD1cInBmLXBvcHVwLWNsb3NlXCI+PGkgY2xhc3M9XCJyc2ljb24gcnNpY29uLWNsb3NlXCI+PC9pPjwvYnV0dG9uPicrXHJcbiAgICAgICAgICAgICc8ZGl2IGlkPVwicGYtcG9wdXAtY29udGVudFwiIGNsYXNzPVwicGYtcG9wdXAtY29udGVudFwiPjwvZGl2PicrXHJcbiAgICAgICAgICAgICc8L2Rpdj4nK1xyXG4gICAgICAgICAgICAnPC9kaXY+JytcclxuICAgICAgICAgICAgJzwvZGl2PicrXHJcbiAgICAgICAgICAgICc8L2Rpdj4nKTtcclxuXHJcbiAgICAgICAgY2VydHkudmFycy5ib2R5LmFwcGVuZCggdGhpcy5wb3B1cF93cmFwcGVyICk7XHJcblxyXG4gICAgICAgIC8vIGFkZCBwb3J0Zm9saW8gcG9wdXAgY29udGVudFxyXG4gICAgICAgIHRoaXMucG9wdXBfY29udGVudCA9IGpRdWVyeSgnI3BmLXBvcHVwLWNvbnRlbnQnKTtcclxuICAgICAgICB0aGlzLnBvcHVwX2NvbnRlbnQuYXBwZW5kKCBlbC5jbG9uZSgpICk7XHJcblxyXG4gICAgICAgIC8vIHBvcHVwIHNsaWRlclxyXG4gICAgICAgIHRoaXMucG9wdXBTbGlkZXIgPSBqUXVlcnkoJyNwZi1wb3B1cC1jb250ZW50IC5wZi1wb3B1cC1tZWRpYScpO1xyXG5cclxuICAgICAgICAvLyBwb3B1cCBzbGlkZXI6IG9uIGluaXRcclxuICAgICAgICB0aGlzLnBvcHVwU2xpZGVyLm9uKCdpbml0JywgZnVuY3Rpb24oZXZlbnQsIHNsaWNrKSB7XHJcbiAgICAgICAgICAgIGNlcnR5LnBvcnRmb2xpby5sb2FkRW1iZWQoMCk7XHJcblxyXG4gICAgICAgICAgICAvLyBNYWtlIFBvcnRmb2xpbyBQb3B1cCBWaXNpYmxlXHJcbiAgICAgICAgICAgIGpRdWVyeSh3aW5kb3cpLnRyaWdnZXIoJ3Jlc2l6ZScpO1xyXG4gICAgICAgIH0pO1xyXG5cclxuICAgICAgICAvLyBwb3B1cCBzbGlkZXI6IGJlZm9yZSBjaGFuZ2VcclxuICAgICAgICB0aGlzLnBvcHVwU2xpZGVyLm9uKCdiZWZvcmVDaGFuZ2UnLCBmdW5jdGlvbiAoZXZlbnQsIHNsaWNrLCBjdXJyZW50U2xpZGUsIG5leHRTbGlkZSkge1xyXG5cclxuICAgICAgICAgICAgLy8gU3RvcCBjdXJyZW50IHNsaWRlIGlmcmFtZS92aWRlbyBwbGF5XHJcbiAgICAgICAgICAgIGlmKCBjZXJ0eS5wb3J0Zm9saW8uY3VycmVudEVtYmVkICYmIGNlcnR5LnBvcnRmb2xpby5jdXJyZW50RW1iZWRUeXBlICl7XHJcbiAgICAgICAgICAgICAgICBzd2l0Y2ggKGNlcnR5LnBvcnRmb2xpby5jdXJyZW50RW1iZWRUeXBlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgY2FzZSBcImlmcmFtZVwiOlxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGlmcmFtZSA9IGNlcnR5LnBvcnRmb2xpby5jdXJyZW50RW1iZWQuZmluZCgnaWZyYW1lJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmcmFtZS5hdHRyKCdzcmMnLCBpZnJhbWUuYXR0cignc3JjJykpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgYnJlYWs7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGNhc2UgXCJ2aWRlb1wiOlxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmlkZW8gPSBjZXJ0eS5wb3J0Zm9saW8uY3VycmVudEVtYmVkLmZpbmQoJ3ZpZGVvJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZpZGVvWzBdLnBhdXNlKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy8gTG9hZCBuZXh0IHNsaWRlIGVtYmVkXHJcbiAgICAgICAgICAgIGNlcnR5LnBvcnRmb2xpby5sb2FkRW1iZWQobmV4dFNsaWRlKTtcclxuICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgLy8gcG9wdXAgc2xpZGVyOiBpbml0aWFsaXplXHJcbiAgICAgICAgdGhpcy5wb3B1cFNsaWRlci5zbGljayh7XHJcbiAgICAgICAgICAgIHNwZWVkOiA1MDAsXHJcbiAgICAgICAgICAgIGRvdHM6IGZhbHNlLFxyXG4gICAgICAgICAgICBhcnJvdzogdHJ1ZSxcclxuICAgICAgICAgICAgaW5maW5pdGU6IGZhbHNlLFxyXG4gICAgICAgICAgICBzbGlkZXNUb1Nob3c6IDEsXHJcbiAgICAgICAgICAgIGFkYXB0aXZlSGVpZ2h0OiB0cnVlXHJcbiAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIC8vIHBvcHVwIGNhcm91c2VsXHJcbiAgICAgICAgdGhpcy5wb3B1cENhcm91c2VsID0galF1ZXJ5KCcjcGYtcG9wdXAtY29udGVudCAucGYtcmVsLWNhcm91c2VsJyk7XHJcblxyXG4gICAgICAgIC8vIHBvcHVwIGNhcm91c2VsOiBpbml0aWFsaXplXHJcbiAgICAgICAgdGhpcy5wb3B1cENhcm91c2VsLnNsaWNrKHtcclxuICAgICAgICAgICAgZG90czogZmFsc2UsXHJcbiAgICAgICAgICAgIGluZmluaXRlOiB0cnVlLFxyXG4gICAgICAgICAgICBzbGlkZXNUb1Nob3c6IDMsXHJcbiAgICAgICAgICAgIHNsaWRlc1RvU2Nyb2xsOiAzLFxyXG4gICAgICAgICAgICBsYXp5TG9hZDogJ29uZGVtYW5kJ1xyXG4gICAgICAgIH0pO1xyXG5cclxuICAgICAgICAvLyBtYWtlIHBvcnRmb2xpbyBwb3B1cCB2aXNpYmxlXHJcbiAgICAgICAgdGhpcy5wb3B1cF93cmFwcGVyLmFkZENsYXNzKCdwZi1vcGVuZWQnKTtcclxuXHJcbiAgICAgICAgLy8gbG9jayB3aW5kb3cgc2Nyb2xsXHJcbiAgICAgICAgY2VydHkubG9ja1Njcm9sbCgpO1xyXG4gICAgfSxcclxuXHJcbiAgICBjbG9zZVBvcHVwOiBmdW5jdGlvbihlbCkge1xyXG4gICAgICAgIC8vIHJlbW92ZSBvcGVuZWQgY2xhc3MgZnJvbSBodG1sXHJcbiAgICAgICAgY2VydHkudmFycy5odG1sLnJlbW92ZUNsYXNzKCdjci1wb3J0Zm9saW8tb3BlbmVkJyk7XHJcblxyXG4gICAgICAgIC8vIG1ha2UgcG9ydGZvbGlvIHBvcHVwIGludmlzaWJsZVxyXG4gICAgICAgIHRoaXMucG9wdXBfd3JhcHBlci5yZW1vdmVDbGFzcygncGYtb3BlbmVkJyk7XHJcblxyXG4gICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgY2VydHkucG9ydGZvbGlvLnBvcHVwX3dyYXBwZXIucmVtb3ZlKCk7XHJcbiAgICAgICAgICAgIGNlcnR5LnVubG9ja1Njcm9sbCgpO1xyXG4gICAgICAgIH0sIDUwMCk7XHJcbiAgICB9LFxyXG5cclxuICAgIGxvYWRFbWJlZDogZnVuY3Rpb24gKHNsaWRlSW5kZXgpIHtcclxuICAgICAgICB2YXIgY3VycmVudEVtYmVkID0galF1ZXJ5KCcjcGYtcG9wdXAtY29udGVudCAucGYtcG9wdXAtc2xpZGVbZGF0YS1zbGljay1pbmRleD1cIicgKyBzbGlkZUluZGV4ICsgJ1wiXScpLmZpbmQoJy5wZi1wb3B1cC1lbWJlZCcpO1xyXG4gICAgICAgIHZhciBjdXJyZW50RW1iZWRUeXBlID0galF1ZXJ5LnRyaW0oY3VycmVudEVtYmVkLmRhdGEoJ3R5cGUnKSk7XHJcbiAgICAgICAgdmFyIGN1cmVudEVtYmVkVXJsID0galF1ZXJ5LnRyaW0oY3VycmVudEVtYmVkLmRhdGEoJ3VybCcpKTtcclxuXHJcbiAgICAgICAgY2VydHkucG9ydGZvbGlvLmN1cnJlbnRFbWJlZCA9IGN1cnJlbnRFbWJlZDtcclxuICAgICAgICBjZXJ0eS5wb3J0Zm9saW8uY3VycmVudEVtYmVkVHlwZSA9IGN1cnJlbnRFbWJlZFR5cGU7XHJcblxyXG4gICAgICAgIC8vIENoZWNrIGlmICdjdXJyZW50RW1iZWQnIHN0aWxsIG5vdCBsb2FkZWQgdGhlbiBkbyBhY3Rpb25zXHJcbiAgICAgICAgaWYgKCFjdXJyZW50RW1iZWQuaGFzQ2xhc3MoJ3BmLWVtYmVkLWxvYWRlZCcpKSB7XHJcblxyXG4gICAgICAgICAgICAvLyBDaGVjayBpZiAnY3VycmVudEVtYmVkJyB1cmwgYW5kIHR5cGUgYXJlIHByb3ZpZGVkXHJcbiAgICAgICAgICAgIGlmICh0eXBlb2YgY3VycmVudEVtYmVkVHlwZSAhPT0gdHlwZW9mIHVuZGVmaW5lZCAmJiBjdXJyZW50RW1iZWRUeXBlICE9PSBmYWxzZSAmJiBjdXJyZW50RW1iZWRUeXBlICE9PSBcIlwiICYmIHR5cGVvZiBjdXJlbnRFbWJlZFVybCAhPT0gdHlwZW9mIHVuZGVmaW5lZCAmJiBjdXJlbnRFbWJlZFVybCAhPT0gZmFsc2UgJiYgY3VyZW50RW1iZWRVcmwgIT09IFwiXCIpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyBTZXQgZW1iZWQgZGltZW5zaW9ucyBpZiBwcm92aWRlZFxyXG4gICAgICAgICAgICAgICAgdmFyIGVtYmVkVyA9IGpRdWVyeS50cmltKGN1cnJlbnRFbWJlZC5kYXRhKCd3aWR0aCcpKTtcclxuICAgICAgICAgICAgICAgIHZhciBlbWJlZEggPSBqUXVlcnkudHJpbShjdXJyZW50RW1iZWQuZGF0YSgnaGVpZ2h0JykpO1xyXG4gICAgICAgICAgICAgICAgaWYgKHR5cGVvZiBlbWJlZFcgIT09IHR5cGVvZiB1bmRlZmluZWQgJiYgZW1iZWRXICE9PSBmYWxzZSAmJiBlbWJlZFcgIT09IFwiXCIgJiYgdHlwZW9mIGVtYmVkSCAhPT0gdHlwZW9mIHVuZGVmaW5lZCAmJiBlbWJlZEggIT09IGZhbHNlICYmIGVtYmVkSCAhPT0gXCJcIikge1xyXG4gICAgICAgICAgICAgICAgICAgIGN1cnJlbnRFbWJlZC5jc3MoeydwYWRkaW5nLXRvcCc6IChlbWJlZEgvZW1iZWRXKjEwMCkrJyUnfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgLy8gTG9hZCBhcHByb3ByaWF0ZSBlbWJlZFxyXG4gICAgICAgICAgICAgICAgc3dpdGNoIChjdXJyZW50RW1iZWRUeXBlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgY2FzZSBcImltYWdlXCI6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIEFkZCBlbWJlZCB0eXBlIGNsYXNzXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGN1cnJlbnRFbWJlZC5hZGRDbGFzcygncGYtZW1iZWQtaW1hZ2UnKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIEFwcGVuZCBlbWJlZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgaW1nID0galF1ZXJ5KCc8aW1nLz4nLHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNyYzogY3VyZW50RW1iZWRVcmwsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdHlsZTogJ2Rpc3BsYXk6bm9uZSdcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSkubG9hZChmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgalF1ZXJ5KHRoaXMpLmZhZGVJbig1MDApO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY3VycmVudEVtYmVkLmFkZENsYXNzKCdwZi1lbWJlZC1sb2FkZWQnKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSkuZXJyb3IoZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGN1cnJlbnRFbWJlZC5hZGRDbGFzcygncGYtZW1iZWQtZXJyb3InKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjdXJyZW50RW1iZWQuZW1wdHkoKS5hcHBlbmQoaW1nKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGJyZWFrO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBjYXNlIFwiaWZyYW1lXCI6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIEFkZCBlbWJlZCB0eXBlIGNsYXNzXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGN1cnJlbnRFbWJlZC5hZGRDbGFzcygncGYtZW1iZWQtaWZyYW1lJyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyBBcHBlbmQgRW1iZWRcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGlmcmFtZSA9IGpRdWVyeSgnPGlmcmFtZS8+Jywge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc3JjOiBjdXJlbnRFbWJlZFVybCxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0eWxlOiAnZGlzcGxheTpub25lJyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGFsbG93ZnVsbHNjcmVlbjogJydcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSkubG9hZChmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgalF1ZXJ5KHRoaXMpLmZhZGVJbig1MDApO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY3VycmVudEVtYmVkLmFkZENsYXNzKCdwZi1lbWJlZC1sb2FkZWQnKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSkuZXJyb3IoZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGN1cnJlbnRFbWJlZC5hZGRDbGFzcygncGYtZW1iZWQtZXJyb3InKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjdXJyZW50RW1iZWQuZW1wdHkoKS5hcHBlbmQoaWZyYW1lKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGJyZWFrO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBjYXNlIFwidmlkZW9cIjpcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy8gQWRkIGVtYmVkIHR5cGUgY2xhc3NcclxuICAgICAgICAgICAgICAgICAgICAgICAgY3VycmVudEVtYmVkLmFkZENsYXNzKCdwZi1lbWJlZC12aWRlbycpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy8gQXBwZW5kIEVtYmVkXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2aWRlb09wdGlvbnMgPSB0aGlzLnBhcnNlT3B0aW9ucyhjdXJlbnRFbWJlZFVybCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2aWRlbyA9ICc8dmlkZW8gJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYodmlkZW9PcHRpb25zLnBvc3RlcikgdmlkZW8gKz0gJ3Bvc3Rlcj1cIicrdmlkZW9PcHRpb25zLnBvc3RlcisnXCIgJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmlkZW8gKz0gJ2NvbnRyb2xzPVwiY29udHJvbHNcIiBwcmVsb2FkPVwieWVzXCI+JztcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYodmlkZW9PcHRpb25zLm1wNCkgdmlkZW8gKz0gJzxzb3VyY2UgdHlwZT1cInZpZGVvL21wNFwiIHNyYz1cIicrdmlkZW9PcHRpb25zLm1wNCsnXCIvPic7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHZpZGVvT3B0aW9ucy53ZWJtKSB2aWRlbyArPSAnPHNvdXJjZSB0eXBlPVwidmlkZW8vd2VibVwiIHNyYz1cIicrdmlkZW9PcHRpb25zLndlYm0rJ1wiLz4nO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZih2aWRlb09wdGlvbnMub2d2KSB2aWRlbyArPSAnPHNvdXJjZSB0eXBlPVwidmlkZW8vb2dnXCIgc3JjPVwiJyt2aWRlb09wdGlvbnMub2d2KydcIi8+JztcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmlkZW8gKz0gJ1lvdXIgYnJvd3NlciBkb2VzIG5vdCBzdXBwb3J0IHRoZSB2aWRlbyB0YWcuPC92aWRlbz4nO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgY3VycmVudEVtYmVkLmVtcHR5KCkuYXBwZW5kKCBqUXVlcnkodmlkZW8pICk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgIH0sXHJcblxyXG4gICAgcGFyc2VPcHRpb25zOiBmdW5jdGlvbiAoc3RyKSB7XHJcbiAgICAgICAgdmFyIG9iaiA9IHt9O1xyXG4gICAgICAgIHZhciBkZWxpbWl0ZXJJbmRleDtcclxuICAgICAgICB2YXIgb3B0aW9uO1xyXG4gICAgICAgIHZhciBwcm9wO1xyXG4gICAgICAgIHZhciB2YWw7XHJcbiAgICAgICAgdmFyIGFycjtcclxuICAgICAgICB2YXIgbGVuO1xyXG4gICAgICAgIHZhciBpO1xyXG5cclxuICAgICAgICAvLyBSZW1vdmUgc3BhY2VzIGFyb3VuZCBkZWxpbWl0ZXJzIGFuZCBzcGxpdFxyXG4gICAgICAgIGFyciA9IHN0ci5yZXBsYWNlKC9cXHMqOlxccyovZywgJzonKS5yZXBsYWNlKC9cXHMqLFxccyovZywgJywnKS5zcGxpdCgnLCcpO1xyXG5cclxuICAgICAgICAvLyBQYXJzZSBhIHN0cmluZ1xyXG4gICAgICAgIGZvciAoaSA9IDAsIGxlbiA9IGFyci5sZW5ndGg7IGkgPCBsZW47IGkrKykge1xyXG4gICAgICAgICAgICBvcHRpb24gPSBhcnJbaV07XHJcblxyXG4gICAgICAgICAgICAvLyBJZ25vcmUgdXJscyBhbmQgYSBzdHJpbmcgd2l0aG91dCBjb2xvbiBkZWxpbWl0ZXJzXHJcbiAgICAgICAgICAgIGlmIChcclxuICAgICAgICAgICAgICAgIG9wdGlvbi5zZWFyY2goL14oaHR0cHxodHRwc3xmdHApOlxcL1xcLy8pICE9PSAtMSB8fFxyXG4gICAgICAgICAgICAgICAgb3B0aW9uLnNlYXJjaCgnOicpID09PSAtMVxyXG4gICAgICAgICAgICApIHtcclxuICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBkZWxpbWl0ZXJJbmRleCA9IG9wdGlvbi5pbmRleE9mKCc6Jyk7XHJcbiAgICAgICAgICAgIHByb3AgPSBvcHRpb24uc3Vic3RyaW5nKDAsIGRlbGltaXRlckluZGV4KTtcclxuICAgICAgICAgICAgdmFsID0gb3B0aW9uLnN1YnN0cmluZyhkZWxpbWl0ZXJJbmRleCArIDEpO1xyXG5cclxuICAgICAgICAgICAgLy8gSWYgdmFsIGlzIGFuIGVtcHR5IHN0cmluZywgbWFrZSBpdCB1bmRlZmluZWRcclxuICAgICAgICAgICAgaWYgKCF2YWwpIHtcclxuICAgICAgICAgICAgICAgIHZhbCA9IHVuZGVmaW5lZDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy8gQ29udmVydCBhIHN0cmluZyB2YWx1ZSBpZiBpdCBpcyBsaWtlIGEgYm9vbGVhblxyXG4gICAgICAgICAgICBpZiAodHlwZW9mIHZhbCA9PT0gJ3N0cmluZycpIHtcclxuICAgICAgICAgICAgICAgIHZhbCA9IHZhbCA9PT0gJ3RydWUnIHx8ICh2YWwgPT09ICdmYWxzZScgPyBmYWxzZSA6IHZhbCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vIENvbnZlcnQgYSBzdHJpbmcgdmFsdWUgaWYgaXQgaXMgbGlrZSBhIG51bWJlclxyXG4gICAgICAgICAgICBpZiAodHlwZW9mIHZhbCA9PT0gJ3N0cmluZycpIHtcclxuICAgICAgICAgICAgICAgIHZhbCA9ICFpc05hTih2YWwpID8gK3ZhbCA6IHZhbDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgb2JqW3Byb3BdID0gdmFsO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLy8gSWYgbm90aGluZyBpcyBwYXJzZWRcclxuICAgICAgICBpZiAocHJvcCA9PSBudWxsICYmIHZhbCA9PSBudWxsKSB7XHJcbiAgICAgICAgICAgIHJldHVybiBzdHI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICByZXR1cm4gb2JqO1xyXG4gICAgfVxyXG59O1xyXG4iLCIoZnVuY3Rpb24gKCQpIHtcclxuICAgIFwidXNlIHN0cmljdFwiO1xyXG5cclxuICAgICQoZnVuY3Rpb24gKCkgeyAvLyBzdGFydDogZG9jdW1lbnQgcmVhZHlcclxuXHJcbiAgICAgICAgLyoqXHJcbiAgICAgICAgICogIFNldCBHbG9iYWwgVmFyc1xyXG4gICAgICAgICAqL1xyXG4gICAgICAgIGNlcnR5LmluaXRHbG9iYWxWYXJzKCk7XHJcblxyXG4gICAgICAgIC8qKlxyXG4gICAgICAgICAqICBOYXZpZ2F0aW9uXHJcbiAgICAgICAgICovXHJcbiAgICAgICAgaWYgKGNlcnR5LnZhcnMuYm9keS5oYXNDbGFzcygnY3J0LW5hdi1vbicpKSB7IC8vIENoZWNrIElmIE5hdiBFeGlzdHNcclxuICAgICAgICAgICAgLy8gU2Nyb2xsZWQgTmF2aWdhdGlvbiAoIGxhcmdlIHNjcmVlbnMgKVxyXG4gICAgICAgICAgICBpZiAoIE1vZGVybml6ci5tcSgnKG1pbi13aWR0aDogJytjZXJ0eS52YXJzLnNjcmVlbk1kKycpJykgJiYgY2VydHkubmF2LmhlaWdodCAhPT0gJ2F1dG8nICkge1xyXG4gICAgICAgICAgICAgICAgY2VydHkubmF2LmluaXRTY3JvbGwoICQoJyNjcnROYXZTY3JvbGwnKSApO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvLyBTdGlja3kgTmF2aWdhdGlvblxyXG4gICAgICAgICAgICBjZXJ0eS5uYXYubWFrZVN0aWNreSgpO1xyXG5cclxuICAgICAgICAgICAgLy8gTmF2aWdhdGlvbiBUb29sdGlwc1xyXG4gICAgICAgICAgICBpZihjZXJ0eS5uYXYudG9vbHRpcC5hY3RpdmUpe1xyXG4gICAgICAgICAgICAgICAgJCgnI2NydE5hdiBhJykuaG92ZXIoZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNlcnR5Lm5hdi50b29sdGlwLnNob3coICQodGhpcykgKTtcclxuICAgICAgICAgICAgICAgIH0sZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNlcnR5Lm5hdi50b29sdGlwLmhpZGUoKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgLy8gQW5jaG9yIE5hdmlnYXRpb25cclxuICAgICAgICAgICAgJCgnI2NydE5hdicpLm9uZVBhZ2VOYXYoe1xyXG4gICAgICAgICAgICAgICAgY2hhbmdlSGFzaDogdHJ1ZSxcclxuICAgICAgICAgICAgICAgIHNjcm9sbFRocmVzaG9sZDogMC41LFxyXG4gICAgICAgICAgICAgICAgZmlsdGVyOiAnOm5vdCguZXh0ZXJuYWwpJ1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIC8qKlxyXG4gICAgICAgICAqICBGaXhlZCBTaWRlIEJveFxyXG4gICAgICAgICAqL1xyXG4gICAgICAgIGNlcnR5LnNpZGVCb3gubWFrZVN0aWNreSgpO1xyXG5cclxuICAgICAgICAvKiogUG9ydGZvbGlvICovXHJcbiAgICAgICAgdmFyIHBmX2dyaWQgPSAkKCcucGYtZ3JpZCcpO1xyXG5cclxuICAgICAgICAvLyBjaGVjayBpZiBncmlkIGV4aXN0cyB0aGFuIGRvIGFjdGlvblxyXG4gICAgICAgIGlmIChwZl9ncmlkLmxlbmd0aCA+IDApIHtcclxuXHJcbiAgICAgICAgICAgIC8vIGluaXQgcG9ydGZvbGlvIGdyaWRcclxuICAgICAgICAgICAgZm9yICh2YXIgaSA9IDA7IGkgPCBwZl9ncmlkLmxlbmd0aDsgaSsrKSB7XHJcbiAgICAgICAgICAgICAgICBjZXJ0eS5wb3J0Zm9saW8uaW5pdEdyaWQoICQocGZfZ3JpZFtpXSkgKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy8gb3BlbiBwb3J0Zm9saW8gcG9wdXBcclxuICAgICAgICAgICAgJChkb2N1bWVudCkub24oJ2NsaWNrJywgJy5wZi1wcm9qZWN0JywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgaWQgPSAkKHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuXHJcbiAgICAgICAgICAgICAgICBjZXJ0eS5wb3J0Zm9saW8ub3BlblBvcHVwKCAkKGlkKSApO1xyXG5cclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkKGRvY3VtZW50KS5vbignY2xpY2snLCAnLnBmLXJlbC1ocmVmJywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgaHJlZiA9ICQodGhpcykuYXR0cignaHJlZicpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vIGlmIGNvbnRhaW4gYW5jaG9yLCBvcGVuIHByb2plY3QgcG9wdXBcclxuICAgICAgICAgICAgICAgIGlmKCBocmVmLmluZGV4T2YoXCIjXCIpICE9IC0xICkge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vIGNsb3NlIGFscmVhZHkgb3BlbmVkIHBvcHVwXHJcbiAgICAgICAgICAgICAgICAgICAgY2VydHkucG9ydGZvbGlvLmNsb3NlUG9wdXAoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy8gb3BlbiBuZXcgb25lIGFmdGVyIHRpbWVvdXRcclxuICAgICAgICAgICAgICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNlcnR5LnBvcnRmb2xpby5vcGVuUG9wdXAoICQoaHJlZikgKTtcclxuICAgICAgICAgICAgICAgICAgICB9LCA1MDApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pO1xyXG5cdFx0XHRcclxuXHRcdFx0JChkb2N1bWVudCkub24oJ2NsaWNrJywgJyNwZi1wb3B1cC1jbG9zZScsIGZ1bmN0aW9uKCkge1x0XHRcdFx0XHJcbiAgICAgICAgICAgICAgICBjZXJ0eS5wb3J0Zm9saW8uY2xvc2VQb3B1cCgpO1xyXG5cdFx0XHR9KTtcclxuXHJcbiAgICAgICAgICAgIC8vIGNsb3NlIHBvcnRmb2xpbyBwb3B1cFxyXG4gICAgICAgICAgICAkKGRvY3VtZW50KS5vbigndG91Y2hzdGFydCBjbGljaycsICcuY3J0LXBmLXBvcHVwLW9wZW5lZCAjcGYtcG9wdXAtd3JhcCcsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgY29udGFpbmVyID0gJCgnI3BmLXBvcHVwLWNvbnRlbnQnKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyBpZiB0aGUgdGFyZ2V0IG9mIHRoZSBjbGljayBpc24ndCB0aGUgY29udGFpbmVyLi4uIG5vciBhIGRlc2NlbmRhbnQgb2YgdGhlIGNvbnRhaW5lclxyXG4gICAgICAgICAgICAgICAgaWYgKCFjb250YWluZXIuaXMoZS50YXJnZXQpICYmIGNvbnRhaW5lci5oYXMoZS50YXJnZXQpLmxlbmd0aCA9PT0gMCkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNlcnR5LnBvcnRmb2xpby5jbG9zZVBvcHVwKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLyoqIENvbXBvbmVudHMgKi9cclxuICAgICAgICAvLyBpbml0IHNsaWRlcnNcclxuICAgICAgICBjZXJ0eS5zbGlkZXIoICQoXCIuY3Itc2xpZGVyXCIpICk7XHJcblxyXG4gICAgICAgIC8vIGluaXQgY2Fyb3VzZWxcclxuICAgICAgICBjZXJ0eS5jYXJvdXNlbCggJChcIi5jci1jYXJvdXNlbFwiKSApO1xyXG5cdFx0XHJcblx0XHQvKiogV2luZG93IFNjcm9sbCBUb3AgQnV0dG9uICovXHJcbiAgICAgICAgdmFyICRidG5TY3JvbGxUb3AgPSAkKCcjY3J0QnRuVXAnKTtcclxuXHRcdFxyXG5cdFx0aWYoJGJ0blNjcm9sbFRvcC5sZW5ndGggPiAwKSB7XHJcbiAgICAgICAgICAgIGlmICgkKHdpbmRvdykuc2Nyb2xsVG9wKCkgPiAxMDApIHtcclxuICAgICAgICAgICAgICAgICRidG5TY3JvbGxUb3Auc2hvdygwKTtcclxuICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICRidG5TY3JvbGxUb3AuaGlkZSgwKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuXHRcdFx0JCh3aW5kb3cpLnNjcm9sbChmdW5jdGlvbiAoKSB7XHJcblx0XHRcdFx0aWYgKCQodGhpcykuc2Nyb2xsVG9wKCkgPiAxMDApIHtcclxuXHRcdFx0XHRcdCRidG5TY3JvbGxUb3Auc2hvdygwKTtcclxuXHRcdFx0XHR9IGVsc2Uge1xyXG5cdFx0XHRcdFx0JGJ0blNjcm9sbFRvcC5oaWRlKDApO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblxyXG5cdFx0XHQkYnRuU2Nyb2xsVG9wLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuXHRcdFx0XHQkKCdodG1sLCBib2R5JykuYW5pbWF0ZSh7c2Nyb2xsVG9wOiAwfSwgODAwKTtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH0pO1xyXG5cdFx0fVxyXG4gICAgfSk7IC8vIGVuZDogZG9jdW1lbnQgcmVhZHlcclxuXHJcblxyXG5cclxuICAgICQod2luZG93KS5vbigncmVzaXplJywgZnVuY3Rpb24gKCkgeyAvLyBzdGFydDogd2luZG93IHJlc2l6ZVxyXG5cclxuICAgICAgICAvLyBSZSBJbml0IFZhcnNcclxuICAgICAgICBjZXJ0eS52YXJzLndpbmRvd1cgPSAkKHdpbmRvdykud2lkdGgoKTtcclxuICAgICAgICBjZXJ0eS52YXJzLndpbmRvd0ggPSAkKHdpbmRvdykuaGVpZ2h0KCk7XHJcbiAgICAgICAgY2VydHkudmFycy53aW5kb3dTY3JvbGxUb3AgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XHJcblxyXG4gICAgICAgIC8vIFN0aWNreSBOYXZpZ2F0aW9uXHJcbiAgICAgICAgY2VydHkubmF2Lm1ha2VTdGlja3koKTtcclxuXHJcbiAgICAgICAgLy8gU3RpY2t5IFNpZGUgQm94XHJcbiAgICAgICAgY2VydHkuc2lkZUJveC5tYWtlU3RpY2t5KCk7XHJcblxyXG4gICAgfSk7IC8vIGVuZDogd2luZG93IHJlc2l6ZVxyXG5cclxuXHJcblxyXG4gICAgJCh3aW5kb3cpLm9uKCdzY3JvbGwnLCBmdW5jdGlvbiAoKSB7IC8vIHN0YXJ0OiB3aW5kb3cgc2Nyb2xsXHJcblxyXG4gICAgICAgIC8vIFJlIEluaXQgVmFyc1xyXG4gICAgICAgIGNlcnR5LnZhcnMud2luZG93U2Nyb2xsVG9wID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xyXG5cclxuICAgICAgICAvLyBTdGlja3kgTmF2aWdhdGlvblxyXG4gICAgICAgIGNlcnR5Lm5hdi5tYWtlU3RpY2t5KCk7XHJcblxyXG4gICAgICAgIC8vIFN0aWNreSBTaWRlIEJveFxyXG4gICAgICAgIGNlcnR5LnNpZGVCb3gubWFrZVN0aWNreSgpO1xyXG5cclxuICAgICAgICAvLyBSZW1vdmUgVG9vbHRpcFxyXG4gICAgICAgIGlmKGNlcnR5Lm5hdi50b29sdGlwLmVsLmxlbmd0aCA+IDApe1xyXG4gICAgICAgICAgICBjZXJ0eS5uYXYudG9vbHRpcC5lbC5yZW1vdmUoKTtcclxuICAgICAgICB9XHJcblxyXG4gICAgfSk7IC8vIGVuZDogd2luZG93IHNjcm9sbFxyXG5cclxuXHJcblxyXG4gICAgJCh3aW5kb3cpLm9uKCdsb2FkJywgZnVuY3Rpb24gKCkgeyAvLyBzdGFydDogd2luZG93IGxvYWRcclxuXHJcbiAgICB9KTsgLy8gZW5kOiB3aW5kb3cgbG9hZFxyXG5cclxufSkoalF1ZXJ5KTsiLCIvLyBUaGVtZSBWYXJpYWJsZXNcclxudmFyIGFjZSA9IHtcclxuICAgIGh0bWw6ICcnLFxyXG4gICAgYm9keTogJycsXHJcbiAgICBtb2JpbGU6ICcnLFxyXG5cclxuICAgIHNpZGViYXI6IHtcclxuICAgICAgICBvYmo6ICcnLFxyXG4gICAgICAgIGJ0bjogJydcclxuICAgIH0sXHJcblxyXG4gICAgbmF2OiB7XHJcbiAgICAgICAgb2JqOiAnJyxcclxuICAgICAgICB0b29sdGlwOiBqUXVlcnkoJzxkaXYgY2xhc3M9XCJjcnQtdG9vbHRpcFwiPjwvZGl2PicpXHJcbiAgICB9LFxyXG5cclxuICAgIG92ZXJsYXk6IHtcclxuICAgICAgICBvYmo6IGpRdWVyeSgnPGRpdiBpZD1cImNydE92ZXJsYXlcIj48L2Rpdj4nKVxyXG4gICAgfSxcclxuXHJcbiAgICBwcm9ncmVzczoge1xyXG4gICAgICAgIGxpbmVzOiAnJyxcclxuICAgICAgICBjaGFydHM6ICcnLFxyXG4gICAgICAgIGJ1bGxldHM6ICcnXHJcbiAgICB9XHJcbn07XHJcblxyXG4oZnVuY3Rpb24gKCQpIHtcclxuICAgIFwidXNlIHN0cmljdFwiO1xyXG5cdFxyXG5cdCQoZnVuY3Rpb24gKCkgeyAvLyBzdGFydDogZG9jdW1lbnQgcmVhZHlcclxuXHJcblx0XHQvKipcclxuXHRcdCAqIENlcnR5IEluaXQgTWFpbiBWYXJzXHJcblx0XHQgKi9cclxuXHRcdGFjZS5odG1sID0gJCgnaHRtbCcpO1xyXG5cdFx0YWNlLmJvZHkgPSAkKCdib2R5Jyk7XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBDZXJ0eSBEZXRlY3QgRGV2aWNlIFR5cGVcclxuXHRcdCAqL1xyXG5cdFx0YWNlX2RldGVjdF9kZXZpY2VfdHlwZSgpO1xyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogQ2VydHkgTW9iaWxlIE5hdmlnYXRpb25cclxuXHRcdCAqL1xyXG5cdFx0JCgnI2NydE1haW5OYXZTbSAubWVudS1pdGVtLWhhcy1jaGlsZHJlbiA+IGEnKS5vbignY2xpY2sgdG91Y2hzdGFydCcsIGZ1bmN0aW9uKCl7XHJcblx0XHRcdGlmKCAkKHRoaXMpLmhhc0NsYXNzKCdob3ZlcicpICl7XHJcblx0XHRcdFx0cmV0dXJuIHRydWU7XHJcblx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0JCh0aGlzKS5hZGRDbGFzcygnaG92ZXInKTtcclxuXHRcdFx0XHQkKHRoaXMpLm5leHQoKS5zbGlkZURvd24oNTAwKTtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogQ2VydHkgU2lkZWJhclxyXG5cdFx0ICovXHJcblx0XHRhY2Uuc2lkZWJhci5vYmogPSAkKCcjY3J0U2lkZWJhcicpO1xyXG5cdFx0YWNlLnNpZGViYXIuYnRuID0gJCgnI2NydFNpZGViYXJCdG4nKTtcclxuXHJcblx0XHQvLyBPcGVuIFNpZGViYXJcclxuXHRcdGFjZS5zaWRlYmFyLmJ0bi5vbigndG91Y2hzdGFydCBjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuXHRcdFx0YWNlX29wZW5fc2lkZWJhcigpO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gQ2xvc2UgU2lkZWJhciBUaHJvdWdoIE92ZXJsYXlcclxuXHRcdCQoZG9jdW1lbnQpLm9uKCd0b3VjaHN0YXJ0IGNsaWNrJywgJy5jcnQtc2lkZWJhci1vcGVuZWQgI2NydE92ZXJsYXknLCBmdW5jdGlvbiAoZSkge1xyXG5cdFx0XHR2YXIgY29udGFpbmVyID0gYWNlLnNpZGViYXIub2JqO1xyXG5cdFx0XHQvLyBpZiB0aGUgdGFyZ2V0IG9mIHRoZSBjbGljayBpc24ndCB0aGUgY29udGFpbmVyLi4uIG5vciBhIGRlc2NlbmRhbnQgb2YgdGhlIGNvbnRhaW5lclxyXG5cdFx0XHRpZiAoIWNvbnRhaW5lci5pcyhlLnRhcmdldCkgJiYgY29udGFpbmVyLmhhcyhlLnRhcmdldCkubGVuZ3RoID09PSAwKSB7XHJcblx0XHRcdFx0YWNlX2Nsb3NlX3NpZGViYXIoKTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gQ2xvc2UgU2lkZWJhciBVc2luZyBCdXR0b25cclxuXHRcdCQoJyNjcnRTaWRlYmFyQ2xvc2UnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XHJcblx0XHRcdGFjZV9jbG9zZV9zaWRlYmFyKCk7XHJcblx0XHR9KTtcclxuXHJcblx0XHQvLyBTaWRlYmFyIEN1c3RvbSBTY3JvbGxcclxuXHRcdCQoXCIjY3J0U2lkZWJhcklubmVyXCIpLm1DdXN0b21TY3JvbGxiYXIoe1xyXG5cdFx0XHRheGlzOiBcInlcIixcclxuXHRcdFx0dGhlbWU6IFwibWluaW1hbC1kYXJrXCIsXHJcblx0XHRcdGF1dG9IaWRlU2Nyb2xsYmFyOiB0cnVlLFxyXG5cdFx0XHRzY3JvbGxCdXR0b25zOiB7IGVuYWJsZTogdHJ1ZSB9XHJcblx0XHR9KTtcclxuXHJcblx0XHQvKipcclxuXHRcdCAqIENlcnR5IENpcmNsZSAmIExpbmUgQ2hhcnRzXHJcblx0XHQgKi9cclxuXHRcdGlmKCFjZXJ0eS5wcm9ncmVzcy5hbmltYXRpb24gfHwgYWNlLm1vYmlsZSkge1xyXG5cdFx0XHQvLyBDaXJjbGUgQ2hhcnRcclxuXHRcdFx0YWNlLnByb2dyZXNzLmNoYXJ0cyA9ICQoJy5wcm9ncmVzcy1jaGFydCAucHJvZ3Jlc3MtYmFyJyk7XHJcblx0XHRcdGZvciAodmFyIGkgPSAwOyBpIDwgYWNlLnByb2dyZXNzLmNoYXJ0cy5sZW5ndGg7IGkrKykge1xyXG5cdFx0XHRcdHZhciBjaGFydCA9ICQoYWNlLnByb2dyZXNzLmNoYXJ0c1tpXSk7XHJcblxyXG5cdFx0XHRcdGFjZV9wcm9ncmVzc19jaGFydChjaGFydFswXSwgY2hhcnQuZGF0YSgndGV4dCcpLCBjaGFydC5kYXRhKCd2YWx1ZScpLCAxKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gTGluZSBDaGFydFxyXG5cdFx0XHRhY2UucHJvZ3Jlc3MubGluZXMgPSAkKCcucHJvZ3Jlc3MtbGluZSAucHJvZ3Jlc3MtYmFyJyk7XHJcblx0XHRcdGZvciAodmFyIGkgPSAwOyBpIDwgYWNlLnByb2dyZXNzLmxpbmVzLmxlbmd0aDsgaSsrKSB7XHJcblx0XHRcdFx0dmFyIGxpbmUgPSAkKGFjZS5wcm9ncmVzcy5saW5lc1tpXSk7XHJcblxyXG5cdFx0XHRcdGFjZV9wcm9ncmVzc19saW5lKGxpbmVbMF0sIGxpbmUuZGF0YSgndGV4dCcpLCBsaW5lLmRhdGEoJ3ZhbHVlJyksIDEpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBDZXJ0eSBBbmltYXRlIEVsZW1lbnRzXHJcblx0XHQgKi9cclxuXHRcdGlmKGNlcnR5LnByb2dyZXNzLmFuaW1hdGlvbiAmJiAhYWNlLm1vYmlsZSkge1xyXG5cdFx0XHRhY2VfYXBwZWFyX2VsZW1zKCQoJy5jcnQtYW5pbWF0ZScpLCAwKTtcclxuXHRcdH1cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIENvZGUgSGlnaGxpZ2h0XHJcblx0XHQgKi9cclxuXHRcdCQoJ3ByZScpLmVhY2goZnVuY3Rpb24gKGksIGJsb2NrKSB7XHJcblx0XHRcdGhsanMuaGlnaGxpZ2h0QmxvY2soYmxvY2spO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBDZXJ0eSBBbGVydHNcclxuXHRcdCAqL1xyXG5cdFx0JCgnLmFsZXJ0IC5jbG9zZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuXHRcdFx0dmFyIGFsZXJ0ID0gJCh0aGlzKS5wYXJlbnQoKTtcclxuXHJcblx0XHRcdGFsZXJ0LmZhZGVPdXQoNTAwLCBmdW5jdGlvbiAoKSB7XHJcblx0XHRcdFx0YWxlcnQucmVtb3ZlKCk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBDZXJ0eSBTbGlkZXJcclxuXHRcdCAqL1xyXG5cdFx0JCgnLnNsaWRlcicpLnNsaWNrKHtcclxuXHRcdFx0ZG90czogdHJ1ZVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBDZXJ0eSBHb29nbGUgTWFwIEluaXRpYWxpc2F0aW9uXHJcblx0XHQgKi9cclxuXHRcdGlmICgkKCcjbWFwJykubGVuZ3RoID4gMCkge1xyXG5cdFx0XHRpbml0aWFsaXNlR29vZ2xlTWFwKCBjZXJ0eV92YXJzX2Zyb21fV1AubWFwU3R5bGVzICk7XHJcblx0XHR9XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiAgVGFic1xyXG5cdFx0ICovXHJcblx0XHR2YXIgdGFiQWN0aXZlID0gJCgnLnRhYnMtbWVudT5saS5hY3RpdmUnKTtcclxuXHRcdGlmKCB0YWJBY3RpdmUubGVuZ3RoID4gMCApe1xyXG5cdFx0XHRmb3IgKHZhciBpID0gMDsgaSA8IHRhYkFjdGl2ZS5sZW5ndGg7IGkrKykge1xyXG5cdFx0XHRcdHZhciB0YWJfaWQgPSAkKHRhYkFjdGl2ZVtpXSkuY2hpbGRyZW4oKS5hdHRyKCdocmVmJyk7XHJcblxyXG5cdFx0XHRcdCQodGFiX2lkKS5hZGRDbGFzcygnYWN0aXZlJykuc2hvdygpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0JCgnLnRhYnMtbWVudSBhJykub24oJ2NsaWNrJywgZnVuY3Rpb24oZSl7XHJcblx0XHRcdHZhciB0YWIgPSAkKHRoaXMpO1xyXG5cdFx0XHR2YXIgdGFiX2lkID0gdGFiLmF0dHIoJ2hyZWYnKTtcclxuXHRcdFx0dmFyIHRhYl93cmFwID0gdGFiLmNsb3Nlc3QoJy50YWJzJyk7XHJcblx0XHRcdHZhciB0YWJfY29udGVudCA9IHRhYl93cmFwLmZpbmQoJy50YWItY29udGVudCcpO1xyXG5cclxuXHRcdFx0dGFiLnBhcmVudCgpLmFkZENsYXNzKFwiYWN0aXZlXCIpO1xyXG5cdFx0XHR0YWIucGFyZW50KCkuc2libGluZ3MoKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XHJcblx0XHRcdHRhYl9jb250ZW50Lm5vdCh0YWJfaWQpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKS5oaWRlKCk7XHJcblx0XHRcdCQodGFiX2lkKS5hZGRDbGFzcygnYWN0aXZlJykuZmFkZUluKDUwMCk7XHJcblxyXG5cdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblx0XHR9KTtcclxuXHJcblx0XHQvKipcclxuXHRcdCAqIFRvZ2dsZUJveFxyXG5cdFx0ICovXHJcblx0XHR2YXIgdG9nZ2xlYm94QWN0aXZlID0gJCgnLnRvZ2dsZWJveD5saS5hY3RpdmUnKTtcclxuXHRcdGlmKCB0b2dnbGVib3hBY3RpdmUubGVuZ3RoID4gMCApe1xyXG5cdFx0XHR0b2dnbGVib3hBY3RpdmUuZmluZCgnLnRvZ2dsZWJveC1jb250ZW50Jykuc2hvdygpO1xyXG5cdFx0fVxyXG5cclxuXHRcdCQoJy50b2dnbGVib3gtaGVhZGVyJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKXtcclxuXHRcdFx0dmFyIHRvZ2dsZV9oZWFkID0gJCh0aGlzKTtcclxuXHJcblx0XHRcdHRvZ2dsZV9oZWFkLm5leHQoJy50b2dnbGVib3gtY29udGVudCcpLnNsaWRlVG9nZ2xlKDMwMCk7XHJcblx0XHRcdHRvZ2dsZV9oZWFkLnBhcmVudCgpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcclxuXHRcdH0pO1xyXG5cclxuXHJcblx0XHQvKipcclxuXHRcdCAqIEFjY29yZGVvblxyXG5cdFx0ICovXHJcblx0XHR2YXIgYWNjb3JkZW9uQWN0aXZlID0gJCgnLmFjY29yZGlvbj5saS5hY3RpdmUnKTtcclxuXHRcdGlmKCBhY2NvcmRlb25BY3RpdmUubGVuZ3RoID4gMCApe1xyXG5cdFx0XHRhY2NvcmRlb25BY3RpdmUuZmluZCgnLmFjY29yZGlvbi1jb250ZW50Jykuc2hvdygpO1xyXG5cdFx0fVxyXG5cclxuXHRcdCQoJy5hY2NvcmRpb24taGVhZGVyJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKXtcclxuXHRcdFx0dmFyIGFjY19oZWFkID0gJCh0aGlzKTtcclxuXHRcdFx0dmFyIGFjY19zZWN0aW9uID0gYWNjX2hlYWQucGFyZW50KCk7XHJcblx0XHRcdHZhciBhY2NfY29udGVudCA9IGFjY19oZWFkLm5leHQoKTtcclxuXHRcdFx0dmFyIGFjY19hbGxfY29udGVudHMgPSBhY2NfaGVhZC5jbG9zZXN0KCcuYWNjb3JkaW9uJykuZmluZCgnLmFjY29yZGlvbi1jb250ZW50Jyk7XHJcblxyXG5cdFx0XHRpZihhY2Nfc2VjdGlvbi5oYXNDbGFzcygnYWN0aXZlJykpe1xyXG5cdFx0XHRcdGFjY19zZWN0aW9uLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcclxuXHRcdFx0XHRhY2NfY29udGVudC5zbGlkZVVwKCk7XHJcblx0XHRcdH1lbHNle1xyXG5cdFx0XHRcdGFjY19zZWN0aW9uLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xyXG5cdFx0XHRcdGFjY19zZWN0aW9uLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuXHRcdFx0XHRhY2NfYWxsX2NvbnRlbnRzLnNsaWRlVXAoMzAwKTtcclxuXHRcdFx0XHRhY2NfY29udGVudC5zbGlkZURvd24oMzAwKTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0LyoqXHJcblx0XHQgKiBDb21tZW50cyBPcGVuL0Nsb3NlXHJcblx0XHQgKi9cclxuXHRcdCQoJy5jb21tZW50LXJlcGx5cy1saW5rJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKXtcclxuXHRcdFx0JCh0aGlzKS5jbG9zZXN0KCcuY29tbWVudCcpLnRvZ2dsZUNsYXNzKCdzaG93LXJlcGxpZXMnKTtcclxuXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogUG9ydGZvbGlvIFBvcHVwXHJcblx0XHQgKi9cclxuXHRcdHZhciBwZl9wb3B1cCA9IHt9O1xyXG5cdFx0cGZfcG9wdXAud3JhcHBlciA9IG51bGw7XHJcblx0XHRwZl9wb3B1cC5jb250ZW50ID0gbnVsbDtcclxuXHRcdHBmX3BvcHVwLnNsaWRlciA9IG51bGw7XHJcblxyXG5cdFx0cGZfcG9wdXAub3BlbiA9IGZ1bmN0aW9uICggZWwgKXtcclxuXHRcdFx0Ly8gQXBwZW5kIFBvcnRmb2xpbyBQb3B1cFxyXG5cdFx0XHR0aGlzLndyYXBwZXIgPSAkKCc8ZGl2IGlkPVwicGYtcG9wdXAtd3JhcFwiIGNsYXNzPVwicGYtcG9wdXAtd3JhcFwiPicrXHJcblx0XHRcdCc8ZGl2IGNsYXNzPVwicGYtcG9wdXAtaW5uZXJcIj4nK1xyXG5cdFx0XHQnPGRpdiBjbGFzcz1cInBmLXBvcHVwLW1pZGRsZVwiPicrXHJcblx0XHRcdCc8ZGl2IGNsYXNzPVwicGYtcG9wdXAtY29udGFpbmVyXCI+JytcclxuXHRcdFx0JzxidXR0b24gaWQ9XCJwZi1wb3B1cC1jbG9zZVwiPjxpIGNsYXNzPVwicnNpY29uIHJzaWNvbi1jbG9zZVwiPjwvaT48L2J1dHRvbj4nK1xyXG5cdFx0XHQnPGRpdiBpZD1cInBmLXBvcHVwLWNvbnRlbnRcIiBjbGFzcz1cInBmLXBvcHVwLWNvbnRlbnRcIj48L2Rpdj4nK1xyXG5cdFx0XHQnPC9kaXY+JytcclxuXHRcdFx0JzwvZGl2PicrXHJcblx0XHRcdCc8L2Rpdj4nKTtcclxuXHJcblx0XHRcdGFjZS5ib2R5LmFwcGVuZCh0aGlzLndyYXBwZXIpO1xyXG5cclxuXHRcdFx0Ly8gQWRkIFBvcnRmb2xpbyBQb3B1cCBJdGVtc1xyXG5cdFx0XHR0aGlzLmNvbnRlbnQgPSAkKCcjcGYtcG9wdXAtY29udGVudCcpO1xyXG5cdFx0XHR0aGlzLmNvbnRlbnQuYXBwZW5kKCBlbC5jbG9uZSgpICk7XHJcblxyXG5cdFx0XHQvLyBNYWtlIFBvcnRmb2xpbyBQb3B1cCBWaXNpYmxlXHJcblx0XHRcdHBmX3BvcHVwLndyYXBwZXIuYWRkQ2xhc3MoJ29wZW5lZCcpO1xyXG5cdFx0XHRhY2VfbG9ja19zY3JvbGwoKTtcclxuXHRcdH07XHJcblxyXG5cdFx0cGZfcG9wdXAuY2xvc2UgPSBmdW5jdGlvbigpe1xyXG5cdFx0XHR0aGlzLndyYXBwZXIucmVtb3ZlQ2xhc3MoJ29wZW5lZCcpO1xyXG5cdFx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0cGZfcG9wdXAud3JhcHBlci5yZW1vdmUoKTtcclxuXHRcdFx0XHRhY2VfdW5sb2NrX3Njcm9sbCgpO1xyXG5cdFx0XHR9LCA1MDApO1xyXG5cdFx0fTtcclxuXHJcblx0XHQvLyBPcGVuIFBvcnRmb2xpbyBQb3B1cFxyXG5cdFx0JChkb2N1bWVudCkub24oJ2NsaWNrJywgJy5wZi1idG4tdmlldycsIGZ1bmN0aW9uKCkge1xyXG5cdFx0XHR2YXIgaWQgPSAkKHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuXHRcdFx0cGZfcG9wdXAub3BlbiggJChpZCkgKTtcclxuXHJcblx0XHRcdGFjZS5odG1sLmFkZENsYXNzKCdjcnQtcG9ydGZvbGlvLW9wZW5lZCcpO1xyXG5cclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gQ2xvc2UgUG9ydGZvbGlvIFBvcHVwXHJcblx0XHQkKGRvY3VtZW50KS5vbigndG91Y2hzdGFydCBjbGljaycsICcuY3J0LXBvcnRmb2xpby1vcGVuZWQgI3BmLXBvcHVwLXdyYXAnLCBmdW5jdGlvbiAoZSkge1xyXG5cdFx0XHR2YXIgY29udGFpbmVyID0gJCgnI3BmLXBvcHVwLWNvbnRlbnQnKTtcclxuXHJcblx0XHRcdC8vIGlmIHRoZSB0YXJnZXQgb2YgdGhlIGNsaWNrIGlzbid0IHRoZSBjb250YWluZXIuLi4gbm9yIGEgZGVzY2VuZGFudCBvZiB0aGUgY29udGFpbmVyXHJcblx0XHRcdGlmICghY29udGFpbmVyLmlzKGUudGFyZ2V0KSAmJiBjb250YWluZXIuaGFzKGUudGFyZ2V0KS5sZW5ndGggPT09IDApIHtcclxuXHRcdFx0XHRwZl9wb3B1cC5jbG9zZSgpO1xyXG5cdFx0XHRcdGFjZS5odG1sLnJlbW92ZUNsYXNzKCdjcnQtcG9ydGZvbGlvLW9wZW5lZCcpO1xyXG5cdFx0XHR9XHJcblx0XHR9KTtcclxuXHJcblx0XHQvKipcclxuXHRcdCAqIFNob3cgQ29kZSA8cHJlPlxyXG5cdFx0ICovXHJcblx0XHQkKCcudG9nZ2xlLWxpbmsnKS5vbignY2xpY2snLCBmdW5jdGlvbigpe1xyXG5cdFx0XHR2YXIgaWQgPSAkKHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuXHJcblx0XHRcdGlmKCQodGhpcykuaGFzQ2xhc3MoJ29wZW5lZCcpKXtcclxuXHRcdFx0XHQkKGlkKS5zbGlkZVVwKDUwMCk7XHJcblx0XHRcdFx0JCh0aGlzKS5yZW1vdmVDbGFzcygnb3BlbmVkJyk7XHJcblx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0JChpZCkuc2xpZGVEb3duKDUwMCk7XHJcblx0XHRcdFx0JCh0aGlzKS5hZGRDbGFzcygnb3BlbmVkJyk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdC8qKlxyXG5cdFx0ICogU2hhcmUgQnV0dG9uXHJcblx0XHQgKi9cclxuXHRcdCQoJy5zaGFyZS1idG4nKS5vbiggXCJtb3VzZWVudGVyXCIsIGZ1bmN0aW9uKCl7XHJcblx0XHRcdCQodGhpcykucGFyZW50KCkuYWRkQ2xhc3MoJ2hvdmVyZWQnKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdCQoJy5zaGFyZS1ib3gnKS5vbiggXCJtb3VzZWxlYXZlXCIsIGZ1bmN0aW9uKCl7XHJcblx0XHRcdHZhciBzaGFyZV9ib3ggPSAkKHRoaXMpO1xyXG5cclxuXHRcdFx0aWYoc2hhcmVfYm94Lmhhc0NsYXNzKCdob3ZlcmVkJykpe1xyXG5cdFx0XHRcdHNoYXJlX2JveC5hZGRDbGFzcygnY2xvc2luZycpO1xyXG5cdFx0XHRcdHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XHJcblx0XHRcdFx0XHRzaGFyZV9ib3gucmVtb3ZlQ2xhc3MoJ2hvdmVyZWQnKTtcclxuXHRcdFx0XHRcdHNoYXJlX2JveC5yZW1vdmVDbGFzcygnY2xvc2luZycpO1xyXG5cdFx0XHRcdH0sMzAwKTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdH0pOyAvLyBlbmQ6IGRvY3VtZW50IHJlYWR5XHJcbn0pKGpRdWVyeSk7Il19
