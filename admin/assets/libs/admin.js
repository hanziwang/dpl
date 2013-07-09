/**
 * 管理工具条
 * @author 邦彦<bangyan@taobao.com>
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
			$('body').append(template.TEMPLATE_ADMIN);

		},

		// 升级模板
		__upgrade: function () {

			var confirm = $(mustache.render(template.TEMPLATE_ADMIN_UPGRADE, {
				page: press.page
			}));

			$('body').append(confirm);

			// 马上升级
			confirm.on('click', '.press-admin-upgrade-ok', function () {
				var reserve = $('.press-admin-upgrade-reserve').is(':checked');
				location.href = $(this).attr('data-url') + '&reserve=' + reserve;
			});

			// 取消升级
			confirm.on('click', '.press-admin-upgrade-cancel', function () {
				confirm.fadeOut('fast', function () {
					$(this).remove();
				});
			});

		},

		// 绑定事件
		__bind: function () {

			var doc = $(document), self = this;

			// 保存页面
			doc.on('click', '.press-admin-save', function () {
				page.setAttribute(function () {
					$('.press-area-save').trigger('click');
				});
			});

			// 升级模板
			doc.on('click', '.press-admin-upgrade', function () {
				self.__upgrade();
			});

			// 选择模板
			doc.on('click', '.press-admin-reselect', function () {
				if (confirm('选择模板会导致已有数据丢失，确定吗？')) {
					location.href = $(this).attr('data-url');
				}
			});

			// 发布页面
			doc.on('click', '.press-admin-release', function () {
				if (confirm('确定马上发布该页面吗？')) {
					location.href = $(this).attr('data-url');
				}
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