/* Sicky Widget */
// Todo: Mobile options on resize
// Todo: If sticky content is larger than window height

(function ( $ ) {
	var $wdg_window_width = 0,
		$wdg_window_height = 0,
		$wdg_window_scroll_top = 0,
		$wdg_wrapped = false;
        $wdg_ismobile = false;

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $wdg_ismobile = true;
    }

	$(function() {
		// Init Vars
		$wdg_window_width = $(window).width();
		$wdg_window_height = $(window).height();
		$wdg_window_scroll_top = $(window).scrollTop();
		
		// Sticky Widget
		set_sticky_widget();
	});

	$(window).scroll(function () {
		// Re Init Vars
		$wdg_window_width = $(window).width();
		$wdg_window_height = $(window).height();
		$wdg_window_scroll_top = $(window).scrollTop();	

		// Sticky Widget
		set_sticky_widget();
	});

	$(window).resize(function () {
		// Re Init Vars
		$wdg_window_width = $(window).width();
		$wdg_window_height = $(window).height();
		$wdg_window_scroll_top = $(window).scrollTop();

		// Sticky Widget
		set_sticky_widget();
	});

	function set_sticky_widget() {
		var wdg_start = $('#wdg-sticky-start');
		var wdg_end = $('#wdg-sticky-end');
		
		// Find the siblings that follow "#sticky-widget-start" up to the "#sticky-widget-end"
		// and wrap them up into a wrapper div and do it once
		if( !$wdg_wrapped ){
            $("#wdg-sticky-start ~ *")
                .wrapAll("<div id='sticky-widget-wrapper'></div>")
                .wrapAll("<div id='sticky-widget-inner'></div>");
			
			$wdg_wrapped = true;
		}		
		
		// when reach sticky widget make wrapped div sticky while scrolling up/down
		var wdg_wrap = $('#sticky-widget-wrapper'),
			wdg_inner = $('#sticky-widget-inner'),		
			wdg_offset_top = wdg_wrap.offset().top;

        if(!$wdg_ismobile){
            if($wdg_window_scroll_top > wdg_offset_top && $wdg_window_width > 992) {
                wdg_inner
                    .addClass('wdg-sticky')
                    .css({
                        top: '10px',
                        bottom: 'auto',
                        position: 'fixed',
                        left: wdg_wrap.offset().left,
                        width: wdg_wrap.width()
                    });

                // when overlaps footer
                if (!($('#crtFooter').offset().top > $wdg_window_scroll_top + wdg_inner.outerHeight())) {
                    wdg_inner.css({
                        top: 'auto',
                        bottom: $('#crtFooter').height() + 'px'
                    });
                }
            } else {
                wdg_inner
                    .removeClass('wdg-sticky')
                    .css({
                        top: 'auto',
                        left: 'auto',
                        width: 'auto',
                        position: 'static'
                    })
            }
        }
	}
}( jQuery ));
