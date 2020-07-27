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
