<div class="search">
	<div class="toolbar">
		<form class="form form-mini clearfix" method="get" action="<?= base_url('template/search') ?>">
			<input type="hidden" name="filter" value="<?= $filter ?>">
			<span class="toggle clearfix">
				<a href="<?= base_url('template/search?filter=my' . $query_string) ?>"<?= $filter === 'my' ? ' class="selected"' : '' ?>>我的模板</a>
				<a href="<?= base_url('template/search?filter=all' . $query_string) ?>"<?= $filter === 'all' ? ' class="selected"' : '' ?>>所有模板</a>
				<a href="<?= base_url('template/search?filter=more' . $query_string) ?>"<?= $filter === 'more' ? ' class="selected"' : '' ?>>更多模板</a>
			</span>
			<select class="select" name="market">
				<option value="">所有市场</option>
<?php foreach ($markets as $v) : ?>
				<option value="<?= $v->id ?>"<?= intval($v->id) === intval($market) ? ' selected="selected"' : '' ?>><?= $v->fullName ?></option>
<?php endforeach; ?>
			</select>
			<input type="text" class="text" name="q" value="<?= $q ?>" placeholder="模板名称、昵称、描述">
			<button class="button button-small" type="submit">搜索一下</button>
		</form>
	</div>
	<div class="result <?= $filter ?>">
		<ul class="list clearfix"></ul>
		<div class="load">加载中</div>
	</div>
</div>
<?php if ($filter === 'my' || $filter === 'all') : ?>
<script type="text/template" id="template">
	<li class="item">
		<a class="explore" title="{description}" href="<?= base_url('template/design?market={marketid}&name={name}') ?>" target="_blank">
			<span class="nickname">{nickname}</span>
			<img src="{imgurl}_250x250.jpg" alt="">
		</a>
		<ul class="action clearfix">
			<li><a href="<?= base_url('template/edit?market={marketid}&name={name}') ?>">编辑</a></li>
			<li><a href="<?= base_url('template/copy?market={marketid}&name={name}') ?>">拷贝</a></li>
			<li><a href="<?= base_url('template/design?market={marketid}&name={name}') ?>" target="_blank">调试</a></li>
<?php if ($filter === 'my') : ?>
			<li><a href="javascript:;" class="upload" data-market="{marketid}" data-name="{name}">上传模板</a></li>
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
			<li><a href="javascript:;" class="download" data-id="{id}" data-name="{name}">下载</a></li>
		</ul>
	</li>
</script>
<?php endif; ?>
<script src="<?= base_url('assets/search.js?v=' . $version) ?>"></script>
<script>

	// 搜索模板
	search.init('<?= base_url("api/template_search") ?>', {
		filter: '<?= $filter ?>',
		market: '<?= $market ?>',
		q: '<?= $q ?>'
	});

</script>
<?php if ($filter === 'my') : ?>
<script>

	// 上传模板
	$('.my').on('click', '.upload', function () {
		var target = $(this),
			market = target.attr('data-market'),
			name = target.attr('data-name');
		$.ajax({
			dataType: 'json',
			url: '<?= base_url('api/template_upload') ?>?market=' + market + '&name=' + name,
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('template/search?filter=my&q=') ?>' + name : alert(d.message);
			}
		});
	});

</script>
<?php endif; ?>
<?php if ($filter === 'more') : ?>
<script>

	// 下载模板
	$('.more').on('click', '.download', function () {
		var target = $(this),
			id = target.attr('data-id'),
			name = target.attr('data-name');
		$.ajax({
			dataType: 'json',
			url: '<?= base_url('api/template_download') ?>?id=' + id,
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('template/search?filter=my&q=') ?>' + name : alert(d.message);
			}
		});
	});

</script>
<?php endif; ?>