/**
 * 页面公用功能
 * @author 邦彦<bangyan@taobao.com>
 */
press.define('page', ['jquery'], function (require) {

	var $ = require('jquery');

	return {

		// 页面模块脚本加载状态
		loaded: {},

		// 操作信息提示
		message: function (str, hide) {

			var trigger = $('.press-admin-message span'),
				message = press.message;

			trigger.html(str).show();
			hide && setTimeout(function () {
				message ? trigger.html(message) : trigger.hide();
			}, 2500);

		},

		// 窗口卸载提示
		beforeUnload: function () {

			var self = this;

			// 保存页面初始配置
			this.attribute = this.getAttribute();

			// 监听窗口卸载事件
			$(window).on('beforeunload', function () {

				var stringify = JSON.stringify,
					attribute = self.getAttribute();

				if (stringify(self.attribute) !== stringify(attribute)) {
					return '离开这个页面，您所做的更改将丢失。';
				}

			});

		},

		// 添加加载状态
		loading: function () {

			var loading = $('<div class="press-loading"><span></span></div>');

			if ($('.press-loading').length === 0) {
				$('body').append(loading.hide().fadeIn('fast'));
			}

		},

		// 解除加载状态
		unloading: function () {

			$('.press-loading').fadeOut('fast', function () {
				$(this).remove();
			});

		},

		// 获取页面配置
		getAttribute: function () {

			var attribute = [];

			//遍历布局
			$('.J_Layout').each(function (layout_id, layout) {

				var _attribute = {
					grid: $(layout).attr('class').match(/grid-[\w]+/).shift(),
					region: []
				};

				// 遍历区块
				$(layout).find('.J_Region').each(function (region_id, region) {

					_attribute.region[region_id] = [];

					// 遍历模块
					$(region).find('.J_Module').each(function (module_id, module) {
						_attribute.region[region_id].push({
							name: $(module).attr('data-name'),
							skin: $(module).attr('data-skin') || 'default',
							guid: $(module).attr('data-guid') || new Date().getTime()
						});
					});

				});
				attribute.push(_attribute);

			});
			return attribute;

		},

		// 保存页面配置
		setAttribute: function () {

			var self = this,
				attribute = this.getAttribute();

			$.ajax({
				type: 'post',
				url: press.api + '/template_save' + location.search,
				data: {
					attribute: JSON.stringify(attribute)
				},
				beforeSend: self.loading,
				complete: self.unloading,
				success: function (d) {
					if (d.code === 200) {
						self.message(d.message);
					} else {
						alert(d.message);
					}
				},
				dataType: 'json'
			});

		}

	};

});