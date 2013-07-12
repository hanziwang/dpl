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

		// 插入管理工具条
		__create: function () {

			$('html').addClass('press-html');
			$('body').append(mustache.render(template.TEMPLATE_ADMIN, {
				url: press.base + 'template/design?market=' + press.market + '&name=' + press.name
			}));

		},

		// 绑定事件
		__bind: function () {

			var doc = $(document);

			// 保存配置
			doc.on('click', '.press-admin-save', function () {
				page.setAttribute();
			});

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