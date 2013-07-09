/**
 * 启动调试模式
 * @author 邦彦<tinyhill@163.com>
 */
press.seajs.config({

	// 别名配置
	alias: {
		'press.css': 'press.css',
		'jquery': 'jquery.js',
		'mustache': 'mustache.js',
		'template': 'template.js',
		'page': 'page.js',
		'page.css': 'page.css',
		'admin': 'admin.js',
		'admin.css': 'admin.css',
		'layout': 'layout.js',
		'layout-add': 'layout-add.js',
		'layout.css': 'layout.css',
		'module': 'module.js',
		'module-add': 'module-add.js',
		'module.css': 'module.css',
		'overlay': 'overlay',
		'overlay.css': 'overlay.css',
		'render': 'render.js',
		'render.css': 'render.css'

	},

	// 映射配置
	map: [
		[ /^(.*\.(?:css|js))(.*)$/i, '$1?v=' + press.version ]
	],

	// 调试模式
	debug: false,

	// 路径配置
	base: press.base,

	// 文件编码
	charset: 'utf-8'

}).use([
	'press.css',
	'jquery',
	'mustache',
	'template',
	'page',
	'page.css',
	'admin',
	'admin.css',
	'layout',
	'layout-add',
	'layout.css',
	'module',
	'module-add',
	'module.css',
	'overlay',
	'overlay.css',
	'render',
	'render.css'
]);