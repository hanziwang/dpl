<div class="content manage">
	<div class="fieldset">
		<div class="hd"><span>编辑模板 “<?= $name ?>”</span></div>
		<div class="bd">
			<form class="form">
				<div class="field clearfix">
					<label class="label">模板名称：</label>
					<div class="clearfix">
						<input type="text" class="text text-disabled" disabled="disabled" value="<?= $name ?>">
						<input type="hidden" name="name" value="<?= $name ?>">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">模板昵称：</label>
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
					<label class="label">所属市场：</label>
					<div class="clearfix">
						<select class="select select-disabled" disabled="disabled">
							<option value="">选择市场</option>
<?php foreach ($markets as $v) : if (intval($market) === intval($v->id)) : ?>
							<option value="<?= $v->id ?>" selected="selected"><?= $v->fullName ?></option>
<?php endif; endforeach; ?>
						</select>
						<input type="hidden" name="market" value="<?= $market ?>">
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
					<button type="submit" class="button">填好了，编辑模板！</button>
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

	// 上传图片
	$('.file input').on('change', function (e) {
		page.upload('<?= base_url('api/upload') ?>', e.currentTarget.files[0], function (url) {
			$('.imgurl .text').val(url);
		});
	});

	// 编辑模板
	$('.form').on('submit', function (e) {
		e.preventDefault();
		$('.tag').val(function () {
			var tags = [];
			$('.tag-selectable a.selected').each(function (k, v) {
				tags.push($(v).attr('data-id'));
			});
			return tags.join(',') || $('.tag').val();
		});
		$.ajax({
			type: 'post',
			url: '<?= base_url('api/template_edit') ?>',
			data: $('.form').serialize(),
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('template/search?filter=my&q=') ?>' + $('input[name=name]').val() : alert(d.message);
			},
			dataType: 'json'
		});
	});

</script>