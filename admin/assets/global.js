/**
 * ____________ _          _____
 * |  _  \ ___ \ |        |____ |
 * | | | | |_/ / |  __   __   / /
 * | | | |  __/| |  \ \ / /   \ \
 * | |/ /| |   | |___\ V /.___/ /
 * |___/ \_|   \_____/\_/ \____/
 *
 * @author 邦彦<tinyhill@163.com>
 */
(function ($) {

	var page = {

		// 添加加载状态
		loading: function () {

			var loading = $('<div class="loading"><span></span></div>');

			if ($('.loading').length === 0) {
				$('body').append(loading.hide().fadeIn('fast'));
			}

		},

		// 解除加载状态
		unloading: function () {

			$('.loading').fadeOut('fast', function () {
				$(this).remove();
			});

		}


	};

	window.page = page;

})(jQuery);