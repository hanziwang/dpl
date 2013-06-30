<div class="content template">
	<div class="fieldset">
		<div class="hd"><span>拷贝模板 “<?= $name ?>”</span></div>
		<div class="bd">
			<form class="form">
				<input type="hidden" name="path" value="<?= $market . '/' . $name ?>">
				<div class="field clearfix">
					<label class="label">模板名称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="name" value="<?= $name ?>" maxlength="50" required="required" pattern="^[a-zA-Z][a-z0-9A-Z-]*[a-z0-9A-Z]$" placeholder="字母开头，可包含字母、数字、中划线">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">模板昵称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="nickname" value="<?= $nickname ?>" maxlength="50" required="required">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">所属市场：</label>
					<div class="clearfix">
						<select class="select" name="market" required="required">
							<option value="">选择市场</option>
<?php foreach ($markets as $v) : ?>
							<option value="<?= $v->id ?>"<?= intval($market) === intval($v->id) ? ' selected="selected"' : '' ?>><?= $v->fullName ?></option>
<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">创建者：</label>
					<div class="clearfix">
						<input type="text" class="text" name="author" value="<?= $author ?>" maxlength="50" required="required">
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
						<input type="url" class="text" name="imgurl" value="<?= $imgurl ?>" maxlength="100" required="required">
						<span class="file" title="点此上传图片"><input type="file"></span>
					</div>
				</div>
				<div class="submit">
					<button type="submit" class="button">填好了，拷贝模板！</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$.ajax({
		dataType: 'jsonp',
		url: '//www.taobao.com/go/market/dpl/tracknick.php',
		success: function (d) {
			$('.text[name=author]').val(d);
		}
	});
	$('.file input').on('change', function (e) {
		page.upload('<?= base_url('api/upload') ?>', e.currentTarget.files[0], function (url) {
			$('.imgurl .text').val(url);
		});
	});
	$('.form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: '<?= base_url('api/template_copy') ?>',
			data: $('.form').serialize(),
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('template/search?filter=all&q=') ?>' + $('.text[name=name]').val() : alert(d.message);
			},
			dataType: 'json'
		});
	});
</script>