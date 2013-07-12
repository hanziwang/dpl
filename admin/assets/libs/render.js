/**
 * 设计页面渲染
 * 注：渲染设计状态下的工具条、占位块
 * @author 邦彦<tinyhill@163.com>
 */
press.define('render', ['jquery', 'mustache', 'template', 'page'], function (require) {

	var $ = require('jquery');
	var mustache = require('mustache');
	var template = require('template');
	var page = require('page');

	var render = {

		// 设置布局工具条
		setLayoutAdmin: function (layout) {

			$(layout).append(template.TEMPLATE_LAYOUT_ADMIN);

		},

		// 设置区块占位块
		setRegionAdmin: function (region, width) {

			var self = this,
				_layout = $(region).parents('.J_Layout'),
				_region = $(region),
				_width = width || (_layout.hasClass('grid-m') ? '100%' : _region.width());

			// 设置区块宽度属性
			_region.attr('data-width', function () {
				return _layout.hasClass('grid-m') ? '100%' : _width;
			});

			// 如果区块已添加模块，则设置模块工具条
			if (_region.children('.J_Module').length > 0) {
				_region.find('.J_Module').each(function (k, module) {
					self.setModuleAdmin(module, _width);
				});
			}

			// 如果区块未添加模块，则设置模块占位块
			else {
				_region.append(mustache.render(template.TEMPLATE_REGION_ADMIN, {
					width: _width,
					height: _layout.children('.J_Module').length > 0 ? _layout.height() : 150
				}));
			}

		},

		// 设置模块工具条
		setModuleAdmin: function (module, width) {

			$(module).append(mustache.render(template.TEMPLATE_MODULE_ADMIN, {
				width: width
			}));

		},

		// 批量设置工具条、占位块
		__setAdmin: function () {

			var self = this;

			// 设置布局工具条
			$('.J_Layout').each(function (k, layout) {
				self.setLayoutAdmin(layout);
			});

			// 设置区块占位块
			$('.J_Region').each(function (k, region) {
				self.setRegionAdmin(region);
			});

		},

		// 绑定悬停切换事件
		__toggleCls: function (trigger, cls) {

			$(document).on('mouseenter mouseleave', trigger, function (e) {
				if (e.type === 'mouseenter') {
					$(this).siblings().removeClass(cls);
					$(this).addClass(cls);
				}
				if (e.type === 'mouseleave') {
					$(this).removeClass(cls);
				}
			});

		},

		// 绑定页面操作事件
		__bind: function () {

			var self = this, doc = $(document);

			// 绑定布局悬停事件
			self.__toggleCls('.J_Layout', 'press-layout');

			// 绑定区块悬停事件
			self.__toggleCls('.J_Region', 'press-region');

			// 绑定模块悬停事件
			self.__toggleCls('.J_Module', 'press-module');

			// 绑定浮层打开事件，解除当前布局的选中效果
			doc.on('click', '.press-overlay-trigger', function () {
				$(this).parent().trigger('mouseleave');
			});

			// 根据鼠标位置触发布局选中
			doc.one('mousemove', function (e) {
				$(e.target).trigger('mouseenter');
			});

		},

		// 初始化
		init: function () {

			// 绑定窗口卸载事件
			page.beforeUnload();

			this.__setAdmin();
			this.__bind();

			// 绑定工具条设置方法
			page.setLayoutAdmin = this.setLayoutAdmin;
			page.setRegionAdmin = this.setRegionAdmin;
			page.setModuleAdmin = this.setModuleAdmin;

		}

	};

	// 执行初始化
	render.init();

});