/**
 * 管理工具条
 * @author 邦彦<tinyhill@163.com>
 */
press.define('admin', ['jquery', 'mustache', 'template', 'page'], function (require) {

	var $ = require('jquery');
	var mustache = require('mustache');
	var template = require('template');
	var page = require('page');

	var admin = {

		// 滚动位置
		scrollTop: 0,

		// 插入管理工具条
		__create: function () {

			$('html').addClass('press-html');
			$('body').append(mustache.render(template.TEMPLATE_ADMIN, {
				url: press.base + 'template/design?market=' + press.market + '&name=' + press.name
			}));

			// 防止工具条被遮挡
			if ($('#page').length !== 0 && $('#page').offset().top <= 61) {
				$('#page').addClass('press-page');
			}

		},

		// 私有模块管理
		__private: function () {

			var src = press.base + 'template/module/search?market=' + press.market + '&template=' + press.name;

			// 记录滚动位置
			this.scrollTop = $(window).scrollTop();

			// 插入页面
			if ($('.press-admin-iframe').length === 0) {
				$('body').append(function () {
					return $(mustache.render(template.TEMPLATE_ADMIN_PRIVATE, {
						src: src
					})).fadeIn();
				});
			}

		},

		// 绑定事件
		__bind: function () {

			var self = this, doc = $(document);

			// 模块管理
			doc.on('click', '.press-admin-private', function () {
				self.__private();
			});

			// 保存配置
			doc.on('click', '.press-admin-save', function () {
				page.setAttribute();
			});

			// 关闭窗口
			press.close = function () {
				$('.press-admin-iframe').fadeOut('fast', function () {
					$(this).remove();
					$(window).scrollTop(self.scrollTop);
				});
			};

		},

		// 初始化
		init: function () {

			this.__create();
			this.__bind();

		}

	};

	// 执行初始化
	admin.init();

});