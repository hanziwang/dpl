/**
 * 模块脚本统一初始化（适用于 kissy 1.2+ 环境）
 */
KISSY.use('node', function (S) {

	// 定义单模块渲染回调函数
	window.renderCallback = function (box, module) {
		var _box = S.one(box),
			name = _box.attr('data-name');
		if (!_box.one('.tb-module').hasClass('tb-finish')) {
			S.use(name, function (S, X) {
				new X(box, module);
			});
		}
	};

	// 遍历模块并执行模块脚本
	S.each(S.all('.J_Module'), function (box) {
		renderCallback(box, S.one(box).one('.tb-module')[0]);
	});

});