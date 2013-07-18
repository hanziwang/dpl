<div class="content manage">
	<div class="fieldset">
		<div class="hd"><span>编辑模块 “<?= $name ?>”</span></div>
		<div class="bd">
			<form class="form">
				<div class="field clearfix">
					<label class="label">模块名称：</label>
					<div class="clearfix">
						<input type="text" class="text text-disabled" disabled="disabled" value="<?= $name ?>">
						<input type="hidden" name="name" value="<?= $name ?>">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">模块昵称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="nickname" maxlength="50" required="required" value="<?= $nickname ?>">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">业务标签：</label>
					<div class="clearfix tags">
						<input type="hidden" class="tag" name="tag">
						<div class="tag-selectable clearfix">
<?php foreach ($tags as $v) : $v = explode(':', $v); ?>
							<a data-id="<?= $v[0] ?>" href="javascript:;"<?= in_array($v[0], $tag) ? ' class="selected"' : '' ?>><?= $v[1] ?><i></i></a>
<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">模块分类：</label>
					<div class="clearfix types">
						<input type="hidden" class="category" name="category" required="required">
						<span class="type-selected">
<?php foreach ($types as $v) : if (in_array($v->id, $category)) : ?>
							<span id="type-selected-<?= $v->id ?>"><a data-id="<?= $v->id ?>" href="javascript:;"></a><?= $v->value ?></span>
<?php endif; endforeach; ?>
						</span>
						<div class="type-unselected">
<?php foreach ($types as $v) : ?>
							<a data-id="<?= $v->id ?>" href="javascript:;"><?= $v->value ?></a>
<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">适应宽度：</label>
					<div class="clearfix">
						<select class="select" name="width" required="required">
							<option value="">选择宽度</option>
<?php foreach ($widths as $v) : ?>
							<option value="<?= $v ?>"<?= intval($v) === intval($width) ? ' selected="selected"' : ''?>><?= $v === 0 ? '100%' : $v ?></option>
<?php endforeach; ?>>
						</select>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">创建者：</label>
					<div class="clearfix">
						<input type="text" class="text" name="author" maxlength="50" required="required" value="<?= $author ?>">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">描述：</label>
					<div class="clearfix">
						<textarea class="textarea" name="description" maxlength="100" required="required"><?= $description ?></textarea>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">缩略图地址：</label>
					<div class="imgurl clearfix">
						<input type="url" class="text" name="imgurl" maxlength="100" required="required" value="<?= $imgurl ?>">
						<span class="file" title="点此上传图片"><input type="file"></span>
					</div>
				</div>
				<div class="submit">
					<button type="submit" class="button">填好了，编辑模块！</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

	// 业务标签
	$('.tag-selectable').on('click', 'a', function () {
		if ($(this).hasClass('selected') && $(this).siblings('.selected').length !== 0) {
			$(this).removeClass('selected');
		} else {
			$(this).addClass('selected');
		}
	});

	// 模块分类
	$('.type-select').on('click', function () {
		$('.type-unselected').fadeToggle('fast');
	});
	$('.type-selected').on('click', 'a', function () {
		$(this).parent().remove();
	});
	$('.type-unselected').on('click', 'a', function () {
		var id = $(this).attr('data-id'),
			text = $(this).text();
		if ($('#type-selected-' + id).length === 0) {
			$('.type-selected').append('<span id="type-selected-' + id + '"><a data-id="' + id + '" href="javascript:;"></a>' + text + '</span>');
		}
	});

	// 缩略图地址
	$('.file input').on('change', function (e) {
		page.upload('<?= base_url('api/upload') ?>', e.currentTarget.files[0], function (url) {
			$('.imgurl .text').val(url);
		});
	});

	// 编辑模块
	$('.form').on('submit', function (e) {
		e.preventDefault();
		$('.tag').val(function () {
			var tags = [];
			$('.tag-selectable a.selected').each(function (k, v) {
				tags.push($(v).attr('data-id'));
			});
			return tags.join(',') || $('.tag').val();
		});
		$('.category').val(function () {
			var types = [];
			$('.type-selected a').each(function (k, v) {
				types.push($(v).attr('data-id'));
			});
			return types.join(',');
		});
		$.ajax({
			type: 'post',
			url: '<?= base_url('api/module_edit') ?>',
			data: $('.form').serialize(),
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('module/search?filter=my&q=') ?>' + $('input[name=name]').val() : alert(d.message);
			},
			dataType: 'json'
		});
	});

</script>