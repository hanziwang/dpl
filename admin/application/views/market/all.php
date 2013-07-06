<div class="content market">
	<div class="fieldset">
		<div class="hd"><span>所有市场</span></div>
		<div class="bd">
			<table>
				<tr>
					<th width="10%">编号</th>
					<th width="30%">市场名称</th>
					<th width="20%">皮肤色卡</th>
					<th width="20%">基础组件</th>
					<th width="20%">操作</th>
				</tr>
<?php foreach ($market_all as $v) : ?>
				<tr>
					<td><?= $v->id ?></td>
					<td><?= $v->fullName ?>（<?= $v->shortName ?>）</td>
					<td>
						<div class="color clearfix">
<?php foreach ($v->color as $color) : ?>
							<span style="background:<?= $color ?>;" title="<?= $color ?>"></span>
<?php endforeach; ?>
						</div>
					</td>
					<td>
						<div class="parts clearfix">
							<a href="http://www.taobao.com/go/market/<?= $v->id ?>/__header.php" target="_blank">页头</a>
							<a href="http://www.taobao.com/go/rgn/nav/<?= $v->id ?>__nav.php" target="_blank">导航</a>
							<a href="http://www.taobao.com/go/market/<?= $v->id ?>/__footer.php" target="_blank">页尾</a>
							<a class="update" data-id="<?= $v->id ?>" href="javascript:;" title="更新页头、导航、页尾"></a>
						</div>
					</td>
					<td>
						<a href="<?= base_url('template/search?filter=all&market=' . $v->id) ?>">模板管理</a>
					</td>
				</tr>
<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<script>

	// 更新页头、导航、页尾
	$('.update').on('click', function () {
		var target = $(this),
			id = target.attr('data-id');
		!target.hasClass('updating') && $.ajax({
			dataType: 'json',
			url: '<?= base_url('api/market_create?id=') ?>' + id,
			beforeSend: function () {
				target.addClass('updating');
			},
			success: function (d) {
				d.code === 200 ? target.addClass('updated') : alert(d.message);
			}
		});
	});

</script>