<div class="content manage">
	<div class="fieldset">
		<div class="hd"><span>拷贝模块 “<?= $name ?>”</span></div>
		<div class="bd">
			<form class="form">
				<input type="hidden" name="market" value="<?= $market ?>">
				<input type="hidden" name="template" value="<?= $template ?>">
				<input type="hidden" name="category" value="">
				<input type="hidden" name="tag" value="">
				<input type="hidden" name="path" value="<?= 'www/' . $market . '/' . $template . '/modules/' . $name ?>">
				<div class="field clearfix">
					<label class="label">模块名称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="name" maxlength="50" required="required" pattern="^[a-zA-Z][a-z0-9A-Z-]*[a-z0-9A-Z]$" placeholder="字母开头，可包含字母、数字、中划线" value="<?= $name ?>">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">模块昵称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="nickname" maxlength="50" required="required" value="<?= $nickname ?>">
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
					<button type="submit" class="button">填好了，拷贝模块！</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

	// 缩略图地址
	$('.file input').on('change', function (e) {
		page.upload('<?= base_url('api/upload') ?>', e.currentTarget.files[0], function (url) {
			$('.imgurl .text').val(url);
		});
	});

	// 拷贝模块
	$('.form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: '<?= base_url('api/module_copy') ?>',
			data: $('.form').serialize(),
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('template/module/search' . $query_string . '&q=') ?>' + $('.text[name=name]').val() : alert(d.message);
			},
			dataType: 'json'
		});
	});

</script>