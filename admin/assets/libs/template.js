/**
 * 页面组件模板
 * 注：遵循 mustache 语法规则
 * @author 邦彦<tinyhill@163.com>
 */
press.define('template', [], function () {

	return {

		// 管理工具条模板
		TEMPLATE_ADMIN: '<div class="press-base press-admin">' +
			'	<ul class="press-admin-menu press-clearfix">' +
			'		<li class="press-admin-item">' +
			'			<button class="press-button press-button-gray press-admin-private">私有模块管理</button>' +
			'		</li>' +
			'	</ul>' +
			'	<ul class="press-admin-action press-clearfix">' +
			'		<li class="press-admin-item">' +
			'			<a class="press-button press-button-gray press-admin-preview" href="{{url}}" target="_blank">预览</a>' +
			'		</li>' +
			'		<li class="press-admin-item">' +
			'			<button class="press-button press-button-red press-admin-save">保存设置</button>' +
			'		</li>' +
			'	</ul>' +
			'</div>',

		// 私有模块管理模板
		TEMPLATE_ADMIN_PRIVATE: '<div class="press-admin-iframe">' +
			'   <style>html, body { overflow: hidden !important; }</style>' +
			'   <iframe src="{{src}}"></iframe>' +
			'</div>',

		// 布局工具条模板
		TEMPLATE_LAYOUT_ADMIN: '<div class="press-base press-layout-admin">' +
			'	<div class="press-layout-action press-clearfix">' +
			'		<span class="press-layout-add press-overlay-trigger" title="在该布局后添加布局">' +
			'			<b>添加布局</b>' +
			'		</span>' +
			'		<span class="press-layout-up" title="上移布局">' +
			'			<i class="press-icon press-icon-chevron-up"></i>' +
			'		</span>' +
			'		<span class="press-layout-down" title="下移布局">' +
			'			<i class="press-icon press-icon-chevron-down"></i>' +
			'		</span>' +
			'		<span class="press-layout-remove" title="删除布局">' +
			'			<i class="press-icon press-icon-remove"></i>' +
			'		</span>' +
			'	</div>' +
			'</div>',

		// 区块工具条模板
		TEMPLATE_REGION_ADMIN: '<div class="press-base press-region-admin" style="height:{{height}}px;">' +
			'	<div class="press-region-action press-clearfix">' +
			'		<em class="press-region-label">{{width}}</em>' +
			'		<span class="press-region-add">添加模块</span>' +
			'	</div>' +
			'</div>',

		// 模块工具条模板
		TEMPLATE_MODULE_ADMIN: '<div class="press-base press-module-admin">' +
			'	<div class="press-module-mask"></div>' +
			'	<div class="press-module-action press-clearfix">' +
			'		<span class="press-module-add press-overlay-trigger" title="在该模块后添加模块">' +
			'			<b>添加模块</b>' +
			'		</span>' +
			'		<span class="press-module-up" title="上移模块">' +
			'			<i class="press-icon press-icon-chevron-up"></i>' +
			'		</span>' +
			'		<span class="press-module-down" title="下移模块">' +
			'			<i class="press-icon press-icon-chevron-down"></i>' +
			'		</span>' +
			'		<span class="press-module-remove" title="删除模块">' +
			'			<i class="press-icon press-icon-remove"></i>' +
			'		</span>' +
			'	</div>' +
			'</div>',

		// 标准布局模板
		TEMPLATE_LAYOUT: [
			'<div class="J_Layout layout {{grid}}">' +
				'	<div class="col-main">' +
				'		<div class="main-wrap J_Region" data-width="{{main}}"></div>' +
				'	</div>' +
				'</div>',
			'<div class="J_Layout layout {{grid}}">' +
				'	<div class="col-main">' +
				'		<div class="main-wrap J_Region" data-width="{{main}}"></div>' +
				'	</div>' +
				'	<div class="col-sub J_Region" data-width="{{sub}}"></div>' +
				'</div>',
			'<div class="J_Layout layout {{grid}}">' +
				'	<div class="col-main">' +
				'		<div class="main-wrap J_Region" data-width="{{main}}"></div>' +
				'	</div>' +
				'	<div class="col-sub J_Region" data-width="{{sub}}"></div>' +
				'	<div class="col-extra J_Region" data-width="{{extra}}"></div>' +
				'</div>'],

		// 添加布局模板
		TEMPLATE_LAYOUT_ADD: '<div class="press-layout-add-selectable press-overlay-scroll">' +
			'	<strong>可选布局列表</strong>' +
			'	<ul class="press-clearfix press-layout-{{width}}">' +
			'		{{#types}}' +
			'		<li class="press-grid press-{{grid}}" data-grid="{{grid}}"><i></i></li>' +
			'		{{/types}}' +
			'	</ul>' +
			'</div>' +
			'<div class="press-layout-add-selected press-overlay-scroll">' +
			'	<strong>当前已选布局</strong>' +
			'	<ul class="press-clearfix press-layout-{{width}}"></ul>' +
			'</div>',

		// 添加模块模板
		TEMPLATE_MODULE_ADD: '<form class="press-module-add-form">' +
			'	<div class="press-form-mini press-clearfix">' +
			'		<div class="press-form-toggle press-clearfix">' +
			'			<a href="javascript:;" class="press-form-toggle-selected" data-value="all">公共模块</a>' +
			'			<a href="javascript:;" data-value="private">私有模块</a>' +
			'		</div>' +
			'		<div class="press-module-add-togglable">' +
			'		<select class="press-form-select press-form-select-disabled" disabled="disabled">' +
			'			<option>{{width}}</option>' +
			'		</select>' +
			'		<input type="hidden" name="width" value="{{width}}">' +
			'		<select class="press-form-select press-module-add-authors" name="author">' +
			'			<option value="">创建者</option>' +
			'			{{#authors}}' +
			'			<option value="{{name}}">{{name}}</option>' +
			'			{{/authors}}' +
			'		</select>' +
			'		<input class="press-form-text" type="text" size="35" placeholder="模块名称、描述" name="q">' +
			'		<button class="press-button press-button-blue press-button-small" type="submit">搜索</button>' +
			'		</div>' +
			'	</div>' +
			'	<ul class="press-module-add-list press-clearfix press-overlay-scroll" data-load="true" data-index="0"></ul>' +
			'</form>',

		// 模块条目模板
		TEMPLATE_MODULE_ADD_LIST: '{{#data}}' +
			'<li class="press-module-add-item" data-name="{{name}}">' +
			'	<img src="{{imgurl}}_250x250.jpg" alt="">' +
			'	<em>{{nickname}}</em><i>已选择</i>' +
			'	<div class="press-module-add-explore">' +
			'		<ul>' +
			'			<li>{{nickname}}</li>' +
			'			<li class="press-clearfix"><b>名称：</b><span>{{name}}</span></li>' +
			'			<li class="press-clearfix"><b>描述：</b><span>{{description}}</span></li>' +
			'			<li class="press-clearfix"><b>作者：</b><span>{{author}}</span></li>' +
			'		</ul>' +
			'		<div class="press-module-add-action">' +
			'			<a class="press-button press-button-gray" href="{{url}}" target="_blank">预览</a>' +
			'			<a class="press-button press-button-blue press-module-add-select" href="javascript:;">选择该模块</a>' +
			'		</div>' +
			'	</div>' +
			'</li>' +
			'{{/data}}'

	};

});
