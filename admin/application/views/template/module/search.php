<div class="search">
	<div class="toolbar">
		<form class="form form-mini clearfix" method="get" action="<?= base_url('template/module/search') ?>">
			<input type="hidden" name="market" value="<?= $market ?>">
			<input type="hidden" name="template" value="<?= $template ?>">
			<select class="select" name="author">
				<option value="">所有作者</option>
				<?php foreach ($authors as $v) : ?>
					<option<?= $v->name == $author ? ' selected="selected"' : '' ?>><?= $v->name ?></option>
				<?php endforeach; ?>
			</select>
			<select class="select" name="width">
				<option value="">所有宽度</option>
				<?php foreach ($widths as $v) : ?>
					<option value="<?= $v ?>"<?= strval($v) === $width ? ' selected="selected"' : '' ?>><?= $v === 0 ? '100%' : $v ?></option>
				<?php endforeach; ?>
			</select>
			<input type="text" class="text" name="q" value="<?= $q ?>" placeholder="模块名称、昵称、描述">
			<button class="button button-small" type="submit">搜索一下</button>
		</form>
	</div>
	<div class="result private">
		<ul class="list clearfix"></ul>
		<div class="load">加载中</div>
	</div>
</div>
<script type="text/template" id="template">
	<li class="item">
		<a class="explore" title="{description}" href="<?= base_url('module/design?name={name}&market=' . $market . '&template=' . $template) ?>" target="_blank">
			<span class="nickname">{nickname}</span>
			<img src="{imgurl}_250x250.jpg" alt="">
		</a>
		<ul class="action clearfix">
			<li><a href="<?= base_url('template/module/edit' . $query_string . '&name={name}') ?>">编辑</a></li>
			<li><a href="<?= base_url('template/module/copy' . $query_string . '&name={name}') ?>">拷贝</a></li>
			<li><a href="<?= base_url('module/design' . $query_string . '&name={name}&debug') ?>" target="_blank">调试</a></li>
		</ul>
	</li>
</script>
<script src="<?= base_url('assets/search.js?v=' . $version) ?>"></script>
<script>

	// 搜索模块
	search.init('<?= base_url("api/module_search") ?>', {
		filter: 'private',
		market: '<?= $market ?>',
		template: '<?= $template ?>',
		author: '<?= $author ?>',
		width: '<?= $width ?>',
		q: '<?= $q ?>'
	});

</script>