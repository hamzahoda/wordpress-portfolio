$ = jQuery
jQuery(document).ready(function () {

    if ($(window).width() > 1023) {
        $('#myfullpage').fullpage({
            anchors: rt_portfolio_var.anchors,
            menu: '#menu',
            slidesNavigation: true,
            fadingEffect: true,
            fadingEffectKey: 'YWx2YXJvdHJpZ28uY29tXzAzN1ptRmthVzVuUldabVpXTjBiNXo='
        });
    }
    //counters
    $('.count').counterUp({
        delay: 10,
        time: 4000
    });



if( $('.main-menu .menu-item').hasClass('menu-item-has-children') ) {
  $('.main-menu .menu-item.menu-item-has-children > a').append('<span class="close">+</span>');
}



$(document).on('click', '.close', function(e){
  e.preventDefault();
  var $this = $(this);
  $this.parent().next('ul').slideToggle(function(){
    if( $(this).is(':visible') ) {
      $this.text('-').addClass('submenu-toggled');
    } else {
      $this.text('+').removeClass('submenu-toggled');
    }
  });
});

var $lis = $('.main-menu ul > li');
$.each($lis, function(i, v) {
  var el = $lis[i];

  if( $(el).hasClass('current-menu-item') || $(el).hasClass('current_page_item') || $(el).hasClass('current-menu-ancestor') ) {

   // $(el).children('a').eq(0).find('span').toggleClass('submenu-toggled').text('-');
    $(el).children('.sub-menu').eq(0).slideToggle();
  }
});


    /* search toggle */
    $('body').click(function (evt) {
        if (!($(evt.target).closest('.search-section').length || $(evt.target).hasClass('search-toggle'))) {
            if ($(".search-toggle").hasClass("search-active")) {
                $(".search-toggle").removeClass("search-active");
                $(".search-box").slideUp("slow");
            }
        }
    });

    $(document).on('click', '.search-toggle', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('search-active')) {
            $(this).addClass('search-active');
            $('.search-box').slideDown();
        } else {
            $(this).removeClass('search-active');
            $('.search-box').slideUp();
        }
    });

  // custom tab
    jQuery('.tabs .tab-links a').on('click', function (e) {
        var currentAttrValue = jQuery(this).attr('href');
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });

    /* back-to-top button*/
    $('.back-to-top').hide();
    $('.back-to-top').on("click", function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });


    $(window).scroll(function () {
        var scrollheight = 400;
        if ($(window).scrollTop() > scrollheight) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });

    // slider
    if ($('.banner-slider')[0]) {
        $(".banner-slider").owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: true,
            smartSpeed: 900,
            autoplay: true,
            autoplayTimeout: 5000,
            fallbackEasing: 'easing',
            transitionStyle: "fade",
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
        });
    }

    if ($('.portfolio-slider')[0]) {
        $(".portfolio-slider").owlCarousel({
            items: 3,
            loop: true,
            nav: false,
            dots: true,
            smartSpeed: 900,
            autoplay: true,
            autoplayTimeout: 5000,
            fallbackEasing: 'easing',
            transitionStyle: "fade",
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            responsive: {
                0: {
                    items: 1
                },
                479: {
                    items: 2
                },
                1059: {
                    items: 3
                }
            }
        });
    }

    if ($('.testimonial-slider')[0]) {
        $(".testimonial-slider").owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: false,
            smartSpeed: 900,
            autoplay: true,
            autoplayTimeout: 5000,
            fallbackEasing: 'easing',
            transitionStyle: "fade",
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
        });
    }

    if ($('.partner-slider')[0]) {
        $(".partner-slider").owlCarousel({
            items: 3,
            loop: true,
            nav: false,
            dots: false,
            smartSpeed: 900,
            autoplay: true,
            autoplayTimeout: 5000,
            fallbackEasing: 'easing',
            transitionStyle: "fade",
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            responsive: {
                0: {
                    items: 2
                },
                479: {
                    items: 3
                },
                1059: {
                    items: 3
                }
            }
        });
    }

    if ($('.team-slider')[0]) {
        $(".team-slider").owlCarousel({
            items: 3,
            loop: true,
            nav: false,
            dots: true,
            smartSpeed: 900,
            autoplay: true,
            autoplayTimeout: 5000,
            fallbackEasing: 'easing',
            transitionStyle: "fade",
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            responsive: {
                0: {
                    items: 1
                },
                479: {
                    items: 2
                },
                1124: {
                    items: 3
                }
            }
        });
    }

    if ($(".blog-section .post-item-wrapper").niceScroll != undefined) {

        $(".blog-section .post-item-wrapper").niceScroll({
            cursorcolor: "#0391CE",
            cursorwidth: "5px",
            cursorborder: "1px solid #0c8edc"
        });

    }

    if ($(".service-detail-wrapper").niceScroll != undefined) {

        $(".service-detail-wrapper").niceScroll({
            cursorcolor: "#0391CE",
            cursorwidth: "5px",
            cursorborder: "1px solid #0c8edc"
        });

    }

    if ($(".personal-skills").niceScroll != undefined) {

        $(".personal-skills").niceScroll({
            cursorcolor: "#0391CE",
            cursorwidth: "5px",
            cursorborder: "1px solid #0c8edc"
        });

    }

    if ($(".thumbnail-image-item").niceScroll != undefined) {

        $(".thumbnail-image-item").niceScroll({
            cursorcolor: "#0391CE",
            cursorwidth: "5px",
            cursorborder: "1px solid #0c8edc"
        });

    }
    if ($(".contact-section-wrapper").niceScroll != undefined) {

        $(".contact-section-wrapper").niceScroll({
            cursorcolor: "#0391CE",
            cursorwidth: "5px",
            cursorborder: "1px solid #0c8edc"
        });

    }

    $(document).on('mouseenter', '#menu', function (e) {
        $('#menu').addClass('menu-active');
    });

    $(document).on('mouseleave', '#menu', function (e) {
        $(this).removeClass('menu-active');
    });

    $(document).on('click', '.menu-icon', function (e) {
        var $this = $(this),
        $parent = $(this).parents('#menu');

        if ($parent.hasClass('menu-active')) {
            $parent.removeClass('menu-active');
        } else {
            $parent.addClass('menu-active');
        }
    });



    var main_body_var  = $( 'body' );
    if ( main_body_var.hasClass( 'one-page-menu' ) ){
        if ($(window).width() < 1023) {
            $(document).on('click', '.home .main-menu a', function (e) {    
                e.preventDefault();    
                $('.main-menu li').removeClass('active');    
                var target = $(this).attr('data-scroll');
                                
                if ($('#menu').hasClass('menu-active')) {      
                    $('#menu').removeClass('menu-active');    
                }
                    
                if ($(target).length) {      
                    var $target = $(target),
                            targetOffsetTop = $target.offset().top;                      
                    $(this).parents('li').addClass('active');                      
                    $('html, body').animate({        
                    scrollTop: targetOffsetTop - 20      
                    }, 600);    
                }  
            });
        } 
    }



});
