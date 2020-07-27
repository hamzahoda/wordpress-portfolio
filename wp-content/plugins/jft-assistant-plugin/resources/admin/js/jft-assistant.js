/* global ajaxurl */
/* global jft */
/* global confirm */
(function ($, jft) {

	$(document).ready(function () {
		initAll();
	});

	$(window).load(function () {
		initWindow();
	});

	function checkJFTCookie() {
		$.ajax({
			url: jft.theme.link_check,
			xhrFields: {
				withCredentials: true
			},
			crossDomain: true,
			success: function (r) {
				if (r.theme === 'undefined') {
					return;
				}
				if (r.theme.id === 'undefined') {
					return;
				}
				if (jft.theme === 'undefined') {
					return;
				}
				if (jft.theme.link === 'undefined') {
					return;
				}
				$.ajax({
					url: ajaxurl,
					method: 'post',
					data: {
						nonce: jft.ajax.nonce,
						action: jft.ajax.action,
						_action: 'get_theme_links',
						theme_details: r
					},
					success: function (r) {
						if (window.confirm(r.message)) {
							window.location.href = r.link;
						}
					}
				});

			}
		});

	}

	function initWindow() {
		if (!(jft.screen === 'theme-install' && jft.jft_page)) {
			return;
		}
		checkJFTCookie();
		// make search box full size.
		$('div.wp-filter .search-form input[type=search]').css('width', '100%');
		$('div.wrap').addClass('jft-page');

		// remove the existing menu highlight and add highlight to the JFT page menu item.
		$('ul.wp-submenu li.current').removeClass('current').find('a').removeClass('current');
		$('ul.wp-submenu li').find('a').each(function () {
			if ('theme-install.php?browse=jft&pg=jft' === $(this).attr('href')) {
				$(this).addClass('current').parent().addClass('current');
			}
		});

		$.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				nonce: jft.ajax.nonce,
				action: jft.ajax.action,
				_action: 'in_page'
			}
		});

		$(window).unload(function () {
			$.ajax({
				url: ajaxurl,
				method: 'post',
				async: false,
				data: {
					nonce: jft.ajax.nonce,
					action: jft.ajax.action,
					_action: 'out_page'
				}
			});
		});

        orbitFoxPluginHandler();
	}

    function orbitFoxPluginHandler(){
        $(document).on('click', 'a.theme-install', function(){
            if(jft.orbit_fox && confirm(jft.orbit_fox.prompt)){
                $.ajax({
                    url: ajaxurl,
                    method: 'post',
                    data: {
                        nonce: jft.ajax.nonce,
                        action: jft.ajax.action,
                        _action: 'orbit_fox_prompt'
                    }
                });

                $.ajax({
                    url     : jft.orbit_fox.install,
                    method  : 'GET',
                    success : function(){
                        $.ajax({
                            url     : jft.orbit_fox.activate,
                            method  : 'GET'
                        });
                    }
                });
            }
        });
    }

	function initAll() {
		if (jft.screen === 'theme-install') {
			if (jft.jft_page) {
				$('div.wp-filter .filter-count').remove();
				$('div.wp-filter .filter-links').remove();
				$('div.wp-filter button').remove();
				$('div.wp-filter .search-form').css('width', '100%');
				$('h1').html(jft.tab_name);
			} else {
				$('ul.filter-links').append('<li><a href="#" data-sort="jft">' + jft.tab_name + '</a></li>');
			}
		}
	}


})(jQuery, jft);