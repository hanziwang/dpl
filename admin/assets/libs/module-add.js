/**
 * 添加模块
 * @author 邦彦<bangyan@taobao.com>
 */
press.define('module-add', ['jquery', 'mustache', 'template', 'overlay', 'page'], function (require) {

	var $ = require('jquery');
	var mustache = require('mustache');
	var template = require('template');
	var overlay = require('overlay');
	var page = require('page');

	return {

		// 设置过滤参数
		__filter: 'all',

		// 重置模块列表宽度
		__resize: function (list) {

			var w = list.outerWidth(),
				n = Math.floor((w - 68) / 260),
				l = (w - n * 260 - 60) / 2;

			list.css('padding-left', l + 30);

		},

		// 模块数据加载状态
		__loading: false,

		// 滚动获取模块数据
		__load: function () {

			var self = this,
				form = $('.press-module-add-form'),
				list = $('.press-module-add-list');

			// 停止加载操作
			if (list.attr('data-load') === 'false' || self.__loading) {
				return;
			}

			// 获取模块列表
			$.ajax({
				dataType: 'json',
				url: press.base + 'api/module_search?' + form.serialize(),
				data: {
					filter: self.__filter,
					market: press.market,
					template: press.name,
					index: parseInt(list.attr('data-index')) + 1
				},
				beforeSend: function () {
					self.__loading = true;
				},
				complete: function () {
					self.__loading = false;
				},
				success: function (d) {
					if (d.data.length === 0) {
						list.attr('data-load', 'false');
					} else {
						list.attr('data-index', d.code);
						list.append(function () {
							$.each(d.data, function (k, v) {
								v.url = press.base + 'module/design?name=' + v.name;
								if (self.__filter === 'private') {
									v.url += '&market=' + press.market + '&template=' + press.name;
								}
							});
							return $(mustache.render(template.TEMPLATE_MODULE_ADD_LIST, d)).fadeIn();
						});
					}
				}
			});

		},

		// 模块加载缓冲区
		__selected: {},

		// 选择该模块
		__select: function (trigger) {

			var self = this,
				item = trigger.parents('.press-module-add-item'),
				name = item.attr('data-name'),
				cls = 'press-module-add-selected';

			// 判断是否加载过
			if (!self.__selected[name]) {

				// 加载模块数据
				!trigger.attr('disabled') && $.ajax({
					dataType: 'json',
					url: press.base + 'api/module_render',
					data: {
						filter: self.__filter,
						market: press.market,
						template: press.name,
						name: item.attr('data-name')
					},
					beforeSend: function () {
						trigger.html('正在读取...');
						trigger.attr('disabled', true);
					},
					complete: function () {
						trigger.attr('disabled', false);
					},
					success: function (d) {
						trigger.html('取消该模块');
						self.__selected[name] = d;
						item.addClass(cls);
					},
					error: function () {
						trigger.html('读取错误，点击重试');
						item.removeClass(cls);
					}
				});

			} else {

				// 交替切换选中效果
				if (item.hasClass(cls)) {
					trigger.html('选择该模块');
					item.removeClass(cls);
				} else {
					trigger.html('取消该模块');
					item.addClass(cls);
				}
			}

		},

		// 将模块插入页面
		__insert: function (config) {

			var self = this, insert;

			// 定义模块插入方法
			insert = function (name) {

				var data = self.__selected[name],
					time = new Date().getTime(),

				// 构建模块容器节点
					box = $('<div class="J_Module skin-default" id="guid-' + time + '"></div>'),
					module = $(data['php']);

				// 设置模块属性
				box.attr({
					'data-name': name,
					'data-skin': 'default',
					'data-guid': time
				});

				// 插入模块样式、结构
				box.append('<style>' + data['css'] + data['skin/default'] + '</style>')
					.append(module);

				// 插入模块工具条
				page.setModuleAdmin(box, config.width);

				// 插入页面指定位置
				if (config.module) {
					config.module.after(box);
				} else {
					config.region.append(box);
					config.region.find('.press-region-admin').remove();
				}

				// 加载模块脚本前，判断是否已经加载过
				if (!page.loaded[name]) {
					box.append('<script>' + data['js'] + '</script>');
					renderCallback(box[0], module[0]);
					page.loaded[name] = true;
				} else {
					renderCallback(box[0], module[0]);
				}

			};

			// 遍历选中的模块
			$('.press-module-add-selected').each(function (key, item) {

				var name = $(item).attr('data-name');
				if (self.__filter === 'private') {
					insert(name);
				} else {
					$.ajax({
						dataType: 'json',
						url: press.base + 'api/module_copy',
						data: {
							path: 'modules/' + name,
							market: press.market,
							template: press.name,
							name: name
						},
						beforeSend: page.loading,
						complete: page.unloading,
						success: function (d) {
							d.code === 200 && insert(name);
						},
						type: 'post'
					});
				}

			});

		},

		// 获取内容节点
		__getContent: function (config) {

			return $(mustache.render(template.TEMPLATE_MODULE_ADD, {
				market: press.market,
				template: press.name,
				width: config.width,
				authors: $.parseJSON(press.authors)
			}));

		},

		// 创建模块添加对话框
		__create: function (config) {

			var self = this;

			// 配置对话框
			$.overlay({
				title: '添加模块',
				content: function () {
					return self.__getContent(config);
				},
				ok: '选择好了，就这几个',
				onOk: function (container, close) {
					self.__insert(config);
					close();
				},
				afterRenderUI: function () {
					self.__bind();
					self.__load();
				},
				type: 'large'
			});

		},

		// 绑定事件
		__bind: function () {

			var self = this,
				form = $('.press-module-add-form'),
				list = $('.press-module-add-list');

			// 绑定搜索按钮
			form.on('submit', function (e) {

				e.preventDefault();
				list.html('');
				list.attr({
					'data-index': 0,
					'data-load': 'true'
				});
				self.__load();

			});

			// 绑定滚动加载数据
			list.on('scroll', function () {
				self.__load();
			});

			// 绑定模块选择
			form.on('click', '.press-module-add-select', function () {
				self.__select($(this));
			});

			// 绑定模块类型切换
			form.on('click', '.press-form-toggle a', function () {

				var togglable = $('.press-module-add-togglable'),
					cls = 'press-form-toggle-selected',
					val = $(this).attr('data-value');

				// 私有模块隐藏表单
				val === 'private' ? togglable.hide() : togglable.show();
				$(this).addClass(cls);
				$(this).siblings('a').removeClass(cls);
				self.__filter = val;
				form.submit();

			});

			// 绑定模块列表宽度重置
			$(window).on('resize', function () {
				self.__resize(list);
			});
			self.__resize(list);

		},

		// 初始化
		init: function (config) {

			this.__create(config);

		}

	};

});