/**
 *  _ __  _ __ ___  ___ ___
 * | '_ \| '__/ _ \/ __/ __|
 * | |_) | | |  __/\__ \__ \
 * | .__/|_|  \___||___/___/
 * |_|
 *
 * Press start from here!
 * see: http://github.com/tinyhill/press for details
 * @author 邦彦<bangyan@taobao.com>
 */
var press = (function () {

	var seajs_version = '2.0.0', p;

	p = {

		// 修订时间戳
		// version: new Date().getTime(),
		version: '20130704',

		// 配置环境参数
		__defaults: function () {

			var scripts = document.getElementsByTagName('script'),
				script = scripts[scripts.length - 1];

			// 绑定环境参数
			this.status = script.getAttribute('data-status'); // 页面状态
			this.api = script.getAttribute('data-api'); // 接口路径
			this.base = script.getAttribute('data-base'); // 基准路径
			this.config = script.getAttribute('data-config'); // 业务规范
			this.template = script.getAttribute('data-template'); // 页面类型
			this.width = script.getAttribute('data-width'); // 页面宽度
			this.grids = script.getAttribute('data-grids'); // 布局列表
			this.site = script.getAttribute('data-site'); // 站点 id
			this.colors = script.getAttribute('data-colors'); // 站点色卡
			this.page = script.getAttribute('data-page'); // 页面 id
			this.role = script.getAttribute('data-role'); // 用户角色
			this.nick = script.getAttribute('data-nick'); // 用户昵称
			this.message = script.getAttribute('data-message'); // 提示信息
			this.authors = script.getAttribute('data-authors'); // 模块作者列表
			this.types = script.getAttribute('data-types'); // 模块类型列表
			this.todo = script.getAttribute('data-todo'); // 未完成模块
			this.tce = script.getAttribute('data-tce'); // 动态模块

		},

		// 加载指定版本的 seajs 类库
		__seajs: function () {

			var base = this.base,
				readyState = false,
				script = document.createElement('script');
			script.charset = 'utf-8';
			script.src = base + 'libs/seajs/' + seajs_version + '/sea.js';
			script.setAttribute('data-config', base + 'config.js?v=' + this.version);
			script.setAttribute('data-main', base + 'main.js?v=' + this.version);

			// 绑定加载完毕事件
			script.onload = script.onreadystatechange = function () {
				if (!readyState && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
					readyState = true;
				}
			};
			document.body.appendChild(script);

		},

		// 初始化宿主环境
		init: function () {

			this.__defaults();
			this.__seajs();

		}

	};

	// 执行初始化
	p.init();

	// 返回宿主对象
	return p;

})();
