/**
 * 布局操作
 * 注：集合了基本的布局操作功能
 * @author 邦彦<bangyan@taobao.com>
 */
press.define('layout', ['jquery', 'mustache', 'layout-add'], function (require) {

	var $ = require('jquery');
	var mustache = require('mustache');
	var layout_add = require('layout-add');

	var layout = {

		// 检查布局存在情况，并决定是否添加布局
		__detect: function () {

			if ($('.J_Layout').length === 0) {
				layout_add.init({
					layout: undefined,
					closable: false
				});
			}

		},

		// 绑定事件
		__bind: function () {

			var self = this, doc = $(document);

			// 绑定添加布局事件
			doc.on('click', '.press-layout-add', function () {

				var layout = $(this).parents('.J_Layout');

				// 配置“添加布局”
				// 注：传入参数为当前布局节点
				layout_add.init({
					layout: layout
				});

			});

			// 绑定上移布局事件
			doc.on('click', '.press-layout-up', function () {

				var layout = $(this).parents('.J_Layout');

				//如果存在前置布局，则调换位置
				if (layout.prev('.J_Layout').length !== 0) {
					layout.insertBefore(layout.prev('.J_Layout'));
				}

			});

			// 绑定下移布局事件
			doc.on('click', '.press-layout-down', function () {

				var layout = $(this).parents('.J_Layout');

				//如果存在后置布局，则调换位置
				if (layout.next('.J_Layout').length !== 0) {
					layout.insertAfter(layout.next('.J_Layout'));
				}

			});

			// 绑定删除布局事件
			doc.on('click', '.press-layout-remove', function () {

				var layout = $(this).parents('.J_Layout');

				// 隐藏布局并删除
				confirm('确定要删除布局吗？') && layout.fadeOut(function () {
					$(this).remove();
					self.__detect();
				});

			});

		},

		// 初始化
		init: function () {

			this.__detect();
			this.__bind();

		}

	};

	// 执行初始化
	layout.init();

});