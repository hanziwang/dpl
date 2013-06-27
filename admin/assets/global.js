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

	},

	// 简易图片上传
	upload: function (url, file, callback) {

		var self = this, formdata = new FormData();
		formdata.append('nick', '邦彦');
		formdata.append('session_id', new Date().getTime());
		formdata.append('photo', file);
		$.ajax({
			type: 'post',
			url: url,
			data: formdata,
			processData: false,
			contentType: false,
			beforeSend: self.loading,
			complete: self.unloading,
			success: function (d) {
				d.status === '1' ? callback(d.url) : alert(d.msg);
			},
			dataType: 'json'
		});

	}

};