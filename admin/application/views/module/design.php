<?php header('Content-type:text/html;charset=UTF-8'); ?>
<?= $header ?>
<link rel="stylesheet" href="http://a.tbcdn.cn/apps/tms/press/css/<?= $setting['width'] ?>.css?v=<?= $version ?>">
</head>
<body>
<div id="page">
	<div id="content">
		<div class="layout grid-m0">
<!-- 模块开始 -->
<style>
<?= $module['css'] ?>
<?= $module['skin/default'] ?>
</style>
<div class="J_Module skin-default" data-name="<?= $name ?>">
<?php
_tms_import($module['json']);
eval(' ?>' . $module['php'] . '<?php ');
_tms_export($module['json']);
?>
</div>
<script>
<?= $module['js'] ?>
</script>
<!-- 模块结束 -->
		</div>
	</div>
</div>
<script charset="utf-8" src="http://a.tbcdn.cn/apps/tms/press/js/<?= $setting['module'] ?>.js?v=<?= $version ?>"></script>
<?php $id = md5($name); ?>
<style>
#page {
	padding-top: 69px;
}
</style>
<?php if (isset($_REQUEST['debug'])) : ?>
<style>
#span-<?= $id ?> {
	position: fixed;
	top: 20px;
	left: 20px;
	padding: 20px;
}
#select-<?= $id ?> {
	border: 1px solid #d9d9d9;
	border-top: 1px solid #c0c0c0;
	font-size: 12px;
	font-family: arial;
	border-radius: 1px;
	margin: 0;
	padding: 5px;
}
</style>
<span id="span-<?= $id ?>">
	<select id="select-<?= $id ?>">
<?php foreach ($markets as $v) : ?>
	<option value="<?= $v->id ?>"<?= intval($v->id) === intval($market) ? ' selected="selected"' : '' ?>><?= $v->fullName ?></option>
<?php endforeach; ?>
	</select>
</span>
<script>
document.getElementsByTagName('title')[0].innerHTML = '<?= $name ?>';
document.getElementById('select-<?= $id ?>').onchange = function (e) {
	location.href = '<?= base_url('module/design?name=' . $name . '&market=') ?>' + e.target.value + '&debug';
}
</script>
<?php endif; ?>
</body>
</html>