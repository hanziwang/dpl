<div class="content update">
	<div class="fieldset">
		<div class="hd"><span>更新业务数据</span></div>
		<div class="bd">
			<form class="form" method="get" action="<?= base_url('api/update/redirect') ?>">
				<div class="hint">提示信息：请确认数据目录【db】可写（777）</div>
				<div class="progress"><span></span></div>
				<div class="submit">
					<button type="button" class="button">下载业务数据</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('.button').on('click', function () {
		var target = $(this),
			ajax = function (ids) {
				$.ajax({
					url: '<?= base_url('api/update') ?>?id=' + ids.shift(),
					success: function (d) {
						if (d.code === 200) {
							$('.progress span').css('width', (1 - ids.length / 5) * 100 + '%');
							ids.length ? ajax(ids) : $('.form').on('submit', page.loading).submit();
						} else {
							target.removeClass('button-disabled').attr('disabled', false);
						}
					},
					dataType: 'json'
				});
			};
		$('.progress').show('fast', function () {
			target.addClass('button-disabled').attr('disabled', true);
			ajax(['config', 'template', 'module', 'type', 'author']);
		});
	});
</script>