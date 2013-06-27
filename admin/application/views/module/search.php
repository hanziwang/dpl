<div class="search module-search">
	<div class="toolbar">
		<form class="form form-mini clearfix" method="get" action="<?= base_url('module/search') ?>">
			<input type="hidden" name="filter" value="<?= $filter ?>">
			<span class="toggle clearfix">
				<a href="<?= base_url('module/search?filter=my' . $query_string) ?>"<?= $filter === 'my' ? ' class="selected"' : '' ?>>我的模块</a>
				<a href="<?= base_url('module/search?filter=all' . $query_string) ?>"<?= $filter === 'all' ? ' class="selected"' : '' ?>>所有模块</a>
				<a href="<?= base_url('module/search?filter=more' . $query_string) ?>"<?= $filter === 'more' ? ' class="selected"' : '' ?>>更多模块</a>
			</span>
			<select class="select" name="author">
				<option value="">所有作者</option>
<?php foreach ($authors as $v) : ?>
					<option<?= $v->name == $author ? ' selected="selected"' : '' ?>><?= $v->name ?></option>
<?php endforeach; ?>
			</select>
			<select class="select" name="author">
				<option value="">所有宽度</option>
<?php foreach ($authors as $v) : ?>
					<option<?= $v->name == $author ? ' selected="selected"' : '' ?>><?= $v->name ?></option>
<?php endforeach; ?>
			</select>
			<input type="text" class="text" name="q" value="<?= $q ?>" placeholder="模块名称、昵称、描述">
			<button class="button button-small" type="submit">搜索一下</button>
		</form>
	</div>
	<div class="result">
		<ul class="list clearfix"></ul>
		<div class="load">加载中</div>
	</div>
</div>
<?php if ($filter === 'my' || $filter === 'all') : ?>
<script type="text/template" id="template">
	<li class="item">
		<a class="explore" title="{description}" href="<?= base_url('module/design?market={marketid}&name={name}') ?>" target="_blank">
			<span class="nickname">{nickname}</span>
			<img src="{imgurl}_250x250.jpg" alt="">
		</a>
		<ul class="action clearfix">
			<li><a href="<?= base_url('module/design?market={marketid}&name={name}&edit=true') ?>" target="_blank">编辑</a></li>
			<li><a href="<?= base_url('module/copy?market={marketid}&name={name}') ?>" target="_blank">拷贝</a></li>
			<?php if ($filter === 'my') : ?>
				<li><a href="javascript:;" class="upload" data-market="{marketid}" data-name="{name}">上传模块</a></li>
			<?php endif; ?>
		</ul>
	</li>
</script>
<?php endif; ?>
<?php if ($filter === 'more') : ?>
<script type="text/template" id="template">
	<li class="item">
		<a class="explore" title="{description}" href="{imgurl}" target="_blank">
			<span class="nickname">{nickname}</span>
			<img src="{imgurl}_250x250.jpg" alt="">
		</a>
		<ul class="action clearfix">
			<li><a href="javascript:;" class="download" data-id="{id}">下载</a></li>
		</ul>
	</li>
</script>
<?php endif; ?>
<script src="<?= base_url('assets/search.js?v=' . $version) ?>"></script>
<script>
	search.init('<?= base_url("api/module/search") ?>', {
		filter: '<?= $filter ?>',
		author: '<?= $author ?>',
		width: '<?= $width ?>',
		q: '<?= $q ?>'
	});
</script>