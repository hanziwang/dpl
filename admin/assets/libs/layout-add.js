/**
 * 添加布局
 * @author 邦彦<bangyan@taobao.com>
 */
press.define('layout-add', ['jquery', 'mustache', 'template', 'overlay', 'page'], function (require) {

	var $ = require('jquery');
	var mustache = require('mustache');
	var template = require('template');
	var overlay = require('overlay');
	var page = require('page');

	return {

		// 根据布局类型获取模板
		__getTemplate: function (grid) {

			// 栅格公式
			var rules = {
					990: { n: 20, c: 50, g: 10 },
					950: { n: 24, c: 40, g: 10 },
					940: { n: 19, c: 50, g: 10 },
					320: { n: 1, c: 320, g: 0 }
				},
				type = {}, count = 0,
				rule = rules[press.width];

			// 循环格式化
			grid.replace(/[a-z][0-9]+/g, function (match) {
				match.replace(/[a-z]/g, function (key) {
					type[key] = match.replace(key, '');
				});
			});

			// 计算栏宽
			type.s = type.s || 0;
			type.e = type.e || 0;
			type.m = rule.n - type.s - type.e;
			$.each(type, function (k, v) {
				if (v !== 0) {
					type[k] = v * rule.c - rule.g;
					count = count + 1;
				} else {
					delete type[k];
				}
			});

			// 返回指定类型的布局
			return mustache.render(template.TEMPLATE_LAYOUT[count - 1], {
				grid: grid,
				main: grid === 'grid-m' ? '100%' : type.m,
				sub: type.s,
				extra: type.e
			});

		},

		// 获取内容节点
		__getContent: function () {

			var grids = $.parseJSON(press.grids),
				types = [];

			return $(mustache.render(template.TEMPLATE_LAYOUT_ADD, {
				width: press.width,
				types: function () {
					$.each(grids, function (k, v) {
						types.push({
							grid: v
						});
					});
					return types;
				}
			}));

		},

		// 选择使用布局
		__insert: function (layout) {

			var self = this,
				origin = null,
				types = [];

			// 当前已选布局
			$('.press-layout-add-selected').find('li').each(function (k, v) {
				types.push($(v).attr('data-grid'));
			});

			// 执行布局添加
			$.each(types, function (k, v) {
				var _layout = $(self.__getTemplate(v));

				// 设置布局工具条
				page.setLayoutAdmin(_layout);
				_layout.find('.J_Region').each(function (k, v) {

					// 设置区块工具条
					page.setRegionAdmin(v, $(v).attr('data-width'));
				});

				// 插入空布局
				if (typeof layout !== 'undefined') {
					layout.after(_layout);
					layout = _layout;
				} else {
					$('#content').append(_layout);
				}

				// 保存第一个布局节点
				origin = origin || _layout;
			});

			// 平滑滚动至布局插入点
			$('body, html').animate({
				scrollTop: origin.offset().top - 100
			}, 500);

		},

		// 创建布局添加
		__create: function (config) {

			// 配置参数
			var self = this,
				layout = config.layout,
				closable = config.closable;

			// 配置对话框
			$.overlay({
				title: '添加布局',
				content: function () {
					return self.__getContent();
				},
				closable: closable,
				ok: '选择好了，就这几个',
				onOk: function (container, close) {
					self.__insert(layout);
					close();
				},
				afterRenderUI: function () {
					self.__bind();
				},
				type: 'small'
			});

		},

		// 绑定事件
		__bind: function () {

			var selectable = $('.press-layout-add-selectable'),
				selected = $('.press-layout-add-selected'),
				cls = 'press-grid-selected';

			// 绑定布局选择
			selectable.on('click', 'li', function () {

				var target = selected.find('ul'),
					trigger = $(this),
					grid = trigger.attr('data-grid'),
					item = $('<li class="press-grid press-' + grid + '" data-grid="' + grid + '"><span>删除</span></li>').hide();

				trigger.addClass(cls);
				target.append(item);
				item.fadeIn('fast');

			});

			// 绑定布局悬停
			selected.on('mouseenter mouseleave', 'li', function (e) {

				var trigger = $(this);
				if (e.type === 'mouseenter') {
					trigger.addClass(cls);
				}
				if (e.type === 'mouseleave') {
					trigger.removeClass(cls);
				}

			});

			// 绑定布局删除
			selected.on('click', 'span', function () {

				var trigger = $(this).parent(),
					grid = trigger.attr('data-grid');

				trigger.fadeOut('fast', function () {
					if (selected.find('.press-' + grid).length === 1) {
						selectable.find('.press-' + grid).removeClass(cls);
					}
					$(this).remove();
				});

			});

		},

		// 初始化
		init: function (config) {

			this.__create(config);

		}

	};

});