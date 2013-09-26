<?php
@include APPPATH . 'libraries/Tms.php';
header('Content-type:text/html;charset=UTF-8');
eval(' ?>' . $header . '<?php ');
?>
<link rel="stylesheet" href="http://a.tbcdn.cn/apps/tms/press/css/<?= $setting['feature'] ?>.css?v=<?= $version ?>">
</head>
<body>
<div id="page">
	<div id="content">
		<div class="layout <?= $grid ?>">
<!-- 模块开始 -->
<style>
<?= $module['css'] ?>
<?= $module['skin/default'] ?>
</style>
<div class="J_Module skin-default" data-name="<?= $name ?>">
<?php
_tms_syntax($module['file'], $module['php']);
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
<?= $setting['renderCallback'] . "\n" ?>
<style>
#page {
	padding-top: 69px;
}
</style>
<?php if (isset($_REQUEST['debug'])) : $md5 = md5(var_export($name, true)); ?>
<style>
#s1<?= $md5 ?> {
	position: fixed;
	top: 0;
	left: 0;
	padding: 20px;
}
#s2<?= $md5 ?> {
	border: 1px solid #d9d9d9;
	border-top: 1px solid #c0c0c0;
	font-size: 12px;
	font-family: arial;
	border-radius: 1px;
	margin: 0;
	padding: 5px;
}
#v<?= $md5 ?> {
	position: fixed;
	right: 0;
	bottom: 0;
	font-size: 12px;
	font-family: arial;
	background: #dd4b39;
	color: #fff;
	height: 25px;
	line-height: 25px;
	padding: 0 8px;
	visibility: hidden;
}
#v<?= $md5 ?> a {
	color: #fff !important;
}
.v<?= $md5 ?> {
	visibility: visible !important;
}
</style>
<span id="s1<?= $md5 ?>">
	<select id="s2<?= $md5 ?>">
<?php foreach ($markets as $v) : ?>
		<option value="<?= $v->id ?>"<?= intval($v->id) === intval($market) ? ' selected="selected"' : '' ?>><?= $v->fullName ?></option>
<?php endforeach; ?>
	</select>
</span>
<span id="v<?= $md5 ?>"></span>
<script>
document.getElementsByTagName('title')[0].innerHTML = '<?= $name ?>';
document.getElementById('s2<?= $md5 ?>').onchange = function (e) {
	location.href = '<?= base_url('module/design?name=' . $name . '&market=') ?>' + e.target.value + '&debug';
};
(function (xhr, id, version, eid) {

	if (!id) return;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status === 200) {
			if (id && JSON.parse(xhr.responseText).version !== version) {
				var el = document.getElementById(eid);
				el.innerHTML = '版本已过期，<a href="<?= base_url('module/search?filter=more&q=' . $name) ?>">点此查看最新版本</a>';
				el.className = eid;
			}
		}
	};
	xhr.open('get', '<?= base_url('api/tms_version?id=') ?>' + id, true);
	xhr.timeout = 5000;
	xhr.send(null);

})(new XMLHttpRequest(), '<?= $tms_id ?>', <?= $tms_version ?>, 'v<?= $md5 ?>');
</script>
<?php endif; ?>
</body>
</html>