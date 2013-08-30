<?php header('Content-type:text/html;charset=UTF-8'); ?>
<?php eval(' ?>' . $header . '<?php '); ?>
<link rel="stylesheet" href="http://a.tbcdn.cn/apps/tms/press/css/<?= $setting['feature'] ?>.css?v=<?= $version ?>">
<?= $nav ?>
<!-- 模板开始 -->
<style>
<?= $modules_css ?>
<?= $css ?>
</style>
<div id="page">
	<div id="content">
<?php
foreach ($modules as $module) :
ob_start();
?>
<div class="J_Module skin-<?= $module['skin'] ?>" id="guid-<?= $module['guid'] ?>" data-name="<?= $module['name'] ?>" data-skin="<?= $module['skin'] ?>" data-guid="<?= $module['guid'] ?>">
<?php
_tms_syntax($module['file'], $module['php']);
_tms_import($module['json']);
eval(' ?>' . $module['php'] . '<?php ');
_tms_export($module['json']);
?>
</div>
<?php
$php = ob_get_contents();
ob_end_clean();
$content = str_replace('{' . $module['guid'] . '}', $php, $content);
endforeach;
?>
		<?= $content ?>
	</div>
</div>
<script>
<?= $js ?>
</script>
<script>
<?= $modules_js ?>
</script>
<?= $setting['renderCallback'] ?>
<!-- 模板结束 -->
<?php if (isset($_REQUEST['debug'])) : ?>
<script>

	// 初始化模板调试
	var press = {

		// 配置参数
		base: '<?= base_url() ?>',
		grids: <?= $grids ?>,
		authors: '<?= $authors ?>',
		feature: '<?= $setting['feature'] ?>',
		market: '<?= $market ?>',
		name: '<?= $name ?>',
		version:'<?= $version ?>',

		// 加载 seajs 类库
		seajs: function () {

			var base = this.base + 'assets/libs/',
				readyState = false,
				script = document.createElement('script');
			script.charset = 'utf-8';
			script.id = 'seajsnode';
			script.src = base + 'sea.js?v=' + this.version;
			script.setAttribute('data-main', base + 'main.js?v=' + this.version);

			// 绑定加载完毕事件
			script.onload = script.onreadystatechange = function () {
				if (!readyState && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
					readyState = true;
				}
			};
			document.body.appendChild(script);

		},

		// 初始化
		init: function () {

			document.getElementsByTagName('title')[0].innerHTML = '<?= $name ?>';
			this.seajs();

		}

	};

	press.init();

</script>
<?php endif; ?>
<?php eval(' ?>' . $footer . '<?php '); ?>