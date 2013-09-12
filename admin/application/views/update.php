<div class="content update">
	<div class="fieldset">
		<div class="hd"><span>更新业务数据</span></div>
		<div class="bd">
			<form class="form" method="get" action="<?= base_url('api/setting') ?>">
				<input type="hidden" name="ref" value="update">
				<input type="hidden" name="id" value="<?= $config ?>">
				<div class="hint">提示信息：请确认目录【db】和【src】可写</div>
				<div class="progress"><span></span></div>
				<div class="submit">
					<button type="button" class="button">猛击这里更新</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

	// 更新业务数据
	$('.button').on('click', function () {
		var target = $(this),
			ajax = function (ids) {
				$.ajax({
					url: '<?= base_url('api/update') ?>?id=' + ids.shift(),
					success: function (d) {
						if (d.code === 200) {
							$('.progress span').css('width', (1 - ids.length / 6) * 100 + '%');
							ids.length ? ajax(ids) : $('.form').on('submit', page.loading).submit();
						} else {
							target.removeClass('button-disabled').attr('disabled', false).html('数据下载失败，请点此重试');
						}
					},
					dataType: 'json'
				});
			};
		$('.progress').show('fast', function () {
			target.addClass('button-disabled').attr('disabled', true).html('正在下载数据，请稍候');
			ajax(['config', 'market', 'template', 'module', 'type', 'author']);
		});
	});

</script>