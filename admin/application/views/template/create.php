<div class="content manage">
	<div class="fieldset">
		<div class="hd"><span>新建模板</span></div>
		<div class="bd">
			<form class="form">
				<div class="field clearfix">
					<label class="label">模板名称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="name" maxlength="50" required="required" pattern="^[a-zA-Z][a-z0-9A-Z-]*[a-z0-9A-Z]$" placeholder="字母开头，可包含字母、数字、中划线">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">模板昵称：</label>
					<div class="clearfix">
						<input type="text" class="text" name="nickname" maxlength="50" required="required">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">业务标签：</label>
					<div class="clearfix tags">
						<input type="hidden" class="tag" name="tag">
						<div class="tag-selectable clearfix">
<?php foreach ($tags as $v) : $v = explode(':', $v); ?>
							<a data-id="<?= $v[0] ?>" href="javascript:;"<?= intval($default) === intval($v[0]) ? ' class="selected"' : '' ?>><?= $v[1] ?><i></i></a>
<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">所属市场：</label>
					<div class="clearfix">
						<select class="select" name="market" required="required">
							<option value="">选择市场</option>
<?php foreach ($markets as $v) : ?>
							<option value="<?= $v->id ?>"><?= $v->fullName ?></option>
<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">创建者：</label>
					<div class="clearfix">
						<input type="text" class="text" name="author" maxlength="50" required="required">
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">描述：</label>
					<div class="clearfix">
						<textarea class="textarea" name="description" maxlength="100" required="required"></textarea>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">缩略图地址：</label>
					<div class="imgurl clearfix">
						<input type="url" class="text" name="imgurl" maxlength="100" required="required">
						<span class="file" title="点此上传图片"><input type="file"></span>
					</div>
				</div>
				<div class="submit">
					<button type="submit" class="button">填好了，创建模板！</button>
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

	// 创建者
	$.ajax({
		dataType: 'jsonp',
		url: '//www.taobao.com/go/market/dpl/tracknick.php',
		success: function (d) {
			$('.text[name=author]').val(d);
		}
	});

	// 上传图片
	$('.file input').on('change', function (e) {
		page.upload('<?= base_url('api/upload') ?>', e.currentTarget.files[0], function (url) {
			$('.imgurl .text').val(url);
		});
	});

	// 新建模板
	$('.form').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: '<?= base_url('api/template_create') ?>',
			data: $('.form').serialize(),
			beforeSend: page.loading,
			complete: page.unloading,
			success: function (d) {
				d.code === 200 ? location.href = '<?= base_url('template/search?filter=my&q=') ?>' + $('.text[name=name]').val() : alert(d.message);
			},
			dataType: 'json'
		});
	});

</script>