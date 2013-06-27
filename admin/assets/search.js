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
var search = {

	// 当前页码
	index: 0,

	// 模板替换
	substitute: function (s, o) {

		if (Object.prototype.toString.call(s) !== '[object String]') {
			return '';
		}
		if (Object.prototype.toString.call(o) !== '[object Object]') {
			return s;
		}
		return s.replace(/\{([^{}]+)\}/g, function (match, key) {
			var value = o[key];
			return ( value !== undefined) ? '' + value : '';
		});

	},

	// 批量渲染
	render: function (data) {

		var self = this,
			fragment = [], s = $('#template').html();
		$.each(data, function (k, v) {
			fragment.push(self.substitute(s, v));
		});
		return fragment.join('');

	},

	// 加载状态
	loading: false,

	// 获取数据
	load: function (url, args) {

		var self = this,
			list = $('.list'), load = $('.load');
		if (load.attr('data-load') === 'false' || self.loading) {
			return;
		}
		$.ajax({
			url: url,
			data: $.extend(args, {
				index: self.index
			}),
			beforeSend: function () {
				self.loading = true;
				load.removeClass('loaded').html('加载中');
			},
			complete: function () {
				self.loading = false;
				load.addClass('loaded').html('没有了');
			},
			success: function (d) {
				if (d.data.length === 0) {
					load.attr('data-load', 'false');
				} else {
					list.append(self.substitute(self.render(d.data)));
				}
				self.index = d.index;
			},
			dataType: 'json'
		});

	},

	// 排版重置
	resize: function () {

		var a = 256, b = 40,
			c = a * Math.floor(($(document).width() - b) / a);
		$('.list').css('width', c);

	},

	// 事件绑定
	bind: function (url, args) {

		var self = this;
		$('.select').change(function () {
			$('.form').submit();
		});
		$(window).on('resize', self.resize);
		$(window).on('scroll', function () {
			self.load(url, args);
		});

	},

	// 初始化
	init: function (url, args) {

		this.resize();
		this.bind(url, args);
		this.load(url, args);

	}

};