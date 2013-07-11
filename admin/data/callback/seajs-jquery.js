(function () {

	// 定义单模块渲染回调函数
	window.renderCallback = function (box, module) {
		box = $(box);
		module = $(module);
		var name = box.attr('data-name');
		if (!box.find('.tb-module').hasClass('tb-finish')) {
			seajs.use(name, function (x) {
				x.init(box, module);
			});
		}
	};

	// 遍历模块并执行模块脚本
	$('.J_Module').each(function () {
		renderCallback($(this), $(this).find('.tb-module'))
	});

})();