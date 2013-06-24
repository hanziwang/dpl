<div class="content">
	<fieldset class="fieldset">
		<legend>系统概况</legend>
		<div class="form">
			<div class="field">
				程序版本：
				<span id="version">多业务规范版（<span id="revision">20130106</span>）</span>
				<a id="message" href="http://www.taobao.com/go/market/dpl/version.php" target="_blank"></a>
			</div>
			<div class="field">
				业务规范：
				淘宝垂直市场统一规范（taobao）
				<a href="http://127.0.0.1:8000/admin/setting">点此修改</a>
			</div>
		</div>
	</fieldset>
	<fieldset class="fieldset">
		<legend>快捷导航</legend>
		<div class="form">
			<div class="field">
				常用地址：
				<a href="http://tms.taobao.com/" target="_blank">TMS</a>
				<a href="http://tps.tms.taobao.com/" target="_blank">TPS</a>
				<a href="http://daogou.tms.taobao.com/" target="_blank">新版导购平台</a>
				<a href="http://tg.taobao.net/cml/" target="_blank">CML</a>
			</div>
			<div class="field">
				帮助中心：
				<a href="http://wiki.ued.taobao.net/doku.php?id=tms:dpl:start" target="_blank">使用文档</a>
				<a href="http://wiki.ued.taobao.net/doku.php?id=tms:php:start" target="_blank">标签参考</a>
			</div>
		</div>
	</fieldset>
</div>
<script>
	(function (S) {

		S.io({
			type : 'get',
			url : 'http://www.taobao.com/go/market/dpl/version.php',
			success : function (d) {

				var client = S.one('#revision').html(),
					server = d.shift().revision,
					message = S.one('#message');

				if (client < server) {
					message.html('有新版本，请更新代码');
					message.css('color', 'red');
				} else {
					message.html('没有新版本');
					message.css('color', 'green');
				}

			},
			dataType : 'jsonp',
			cache : false
		});

	})(KISSY);
</script>