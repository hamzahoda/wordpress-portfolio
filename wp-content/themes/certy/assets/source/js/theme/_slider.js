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

