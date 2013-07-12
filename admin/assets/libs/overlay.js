/**
 * 简单的弹出层
 * @author 邦彦<tinyhill@163.com>
 */
press.define('overlay', ['jquery'], function (require) {

	var $ = require('jquery');

	// 封装简单的弹出层
	$.overlay = function (config) {

		// 默认参数
		var defaults = {

			// 标题文本
			title: '默认标题',

			// 内容节点
			content: null,

			// 是否支持关闭
			closable: true,

			// 确定按钮文本
			ok: '确定',

			// 点击确定时的回调函数
			onOk: null,

			// 渲染完成之后的回调
			afterRenderUI: null,

			// 是否启用迷你模式
			type: 'normal'

		};

		var overlay = {

			// 容器节点
			container: null,

			// 创建弹出层
			__create: function (config) {

				var self = this,
					container = $('<div class="press-base press-overlay">' +
						'   <div class="press-overlay-mask"></div>' +
						'</div>'),
					content = $('<div class="press-overlay-content"></div>'),
					close = $('<span class="press-overlay-close"></span>'),
					head = $('<div class="press-overlay-head">' + config.title + '</div>'),
					body = $('<div class="press-overlay-body"></div>'),
					foot = $('<div class="press-overlay-foot press-clearfix">' +
						'   <button type="button" class="press-button press-button-red press-overlay-ok">' + config.ok + '</button>' +
						'   </div>');

				// 创建弹出层
				config.closable && content.append(close);
				body.append(config.content);
				content.prepend(head, body, foot);
				container.append(content);
				container.addClass('press-overlay-' + config.type);

				// 弹出对话框
				$('body').append(container).fadeIn('fast');
				config.afterRenderUI && config.afterRenderUI(container, function () {
					self.__close();
				});

				// 绑定节点
				this.container = container;
			},

			// 关闭
			__close: function () {

				this.container.fadeOut('fast', function () {
					$(this).remove();
				});

			},

			// 绑定事件
			__bind: function () {

				var self = this, container = self.container;

				// 绑定关闭事件
				container.delegate('.press-overlay-close', 'click', function () {
					self.__close();
				});

				// 绑定确定事件
				container.delegate('.press-overlay-ok', 'click', function () {
					config.onOk && config.onOk(container, function () {
						self.__close();
					});
				});

			},

			// 初始化
			__init: function (config) {

				// 禁止创建多实例
				if ($('.press-overlay').length !== 0) {
					return;
				}

				// 混入用户配置项
				config = $.extend(defaults, config);

				this.__create(config);
				this.__bind();

			}

		};

		overlay.__init(config);

	};

});