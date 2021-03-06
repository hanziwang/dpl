<div class="content setting">
	<div class="fieldset">
		<div class="hd"><span>设置用户参数</span></div>
		<div class="bd">
			<form class="form" method="get" action="<?= base_url('api/setting') ?>">
				<input type="hidden" name="refer" value="setting">
				<div class="field clearfix">
					<label class="label">使用业务规范：</label>
					<div class="clearfix">
						<select class="select" name="id">
<?php foreach ($config as $v) : ?>
							<option value="<?= $v->id ?>" data-src="<?= dirname($src) . '/' . $v->code ?>"<?= intval($v->id) === intval($setting['id']) ? ' selected="selected"' : '' ?>><?= $v->name ?>（<?= $v->company ?>）</option>
<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="field clearfix">
					<label class="label">当前工作目录：</label>
					<div class="clearfix">
						<input type="text" class="text text-disabled" disabled="disabled" value="<?= $src ?>">
					</div>
				</div>
				<div class="submit">
					<button type="submit" class="button">保存用户参数</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

	// 设置用户参数
	$('.select').on('change', function () {
		var target = $(this),
			index = target[0].selectedIndex + 1;
		$('.text').val(target.find('option:nth-child(' + index + ')').attr('data-src'));
	});
	$('.form').on('submit', page.loading);

</script>