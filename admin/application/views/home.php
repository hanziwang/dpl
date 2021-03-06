<div class="content home">
	<div class="fieldset">
		<div class="hd"><span>系统概况</span></div>
		<div class="bd">
			<ul class="clearfix">
				<li>运行环境：PHP <?= PHP_VERSION ?>（<span><?= PHP_SAPI ?></span>）<a href="<?= base_url('phpinfo') ?>">查看详情</a></li>
				<li>程序版本：多终端版（<span id="version"><?= $version ?></span>）<span id="message"></span></li>
				<li>业务规范：<?= $setting['name'] ?>（<?= $setting['company'] ?>）<a href="<?= base_url('setting') ?>">点此修改</a></li>
			</ul>
		</div>
	</div>
	<div class="fieldset">
		<div class="hd"><span>快捷导航</span></div>
		<div class="bd">
			<ul class="clearfix">
				<li>常用地址：<a href="http://daogou.tms.taobao.com" target="_blank">新版管理系统</a><a href="http://wiki.tms.taobao.net" target="_blank">维基百科</a></li>
				<li>帮助中心：<a href="http://wiki.tms.taobao.net/dpl:sdk:start" target="_blank">使用手册</a><a href="http://wiki.tms.taobao.net/dpl:issues" target="_blank">意见反馈</a></li>
			</ul>
		</div>
	</div>
</div>
<script>

	// 程序版本
	$.ajax({
		dataType: 'jsonp',
		url: '//www.taobao.com/go/market/dpl/v3.php',
		success: function (d) {
			if ($('#version').html() !== d) {
				$('#message').html('发现新版本').css('color', 'red');
			} else {
				$('#message').html('没有新版本').css('color', 'green');
			}
		}
	});

</script>