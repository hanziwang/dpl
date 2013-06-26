<div class="content home">
	<div class="fieldset">
		<div class="hd"><span>系统概况</span></div>
		<div class="bd">
			<ul class="clearfix">
				<li>程序版本：多业务规范版（<span id="version"><?= $version ?></span>）<a id="message" href="javascript:;"></a></li>
				<li>业务规范：<?= $setting['name'] ?>（<?= $setting['company'] ?>）<a href="<?= base_url('setting') ?>">点此修改</a></li>
			</ul>
		</div>
	</div>
	<div class="fieldset">
		<div class="hd"><span>快捷导航</span></div>
		<div class="bd">
			<ul class="clearfix">
				<li>常用地址：<a href="//daogou.tms.taobao.com" target="_blank">新版管理系统</a><a href="//wiki.tms.taobao.net" target="_blank">维基百科</a></li>
				<li>帮助中心：<a href="//dpl.taobao.net" target="_blank">使用手册</a><a href="//wiki.tms.taobao.net/dpl:issues" target="_blank">意见反馈</a></li>
			</ul>
		</div>
	</div>
</div>
<script>
	$.ajax({
		dataType: 'jsonp',
		url: '//www.taobao.com/market/dpl/v3.php',
		success: function (d) {
			if ($('#version').html() !== d) {
				$('#message').html('发现新版本').css('color', 'red');
			} else {
				$('#message').html('没有新版本').css('color', 'green');
			}
		}
	});
</script>