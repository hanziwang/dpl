<?php header('Content-type:text/html;charset=UTF-8'); ?>
<?php eval(' ?>' . $header . '<?php '); ?>
<link rel="stylesheet" href="http://a.tbcdn.cn/apps/tms/press/css/<?= $setting['width'] ?>.css?v=<?= $version ?>">
<?= $nav ?>
<!-- 模板开始 -->
<style>
<?= $css ?>
</style>
<div id="page">
	<div id="content">
<?php
foreach ($modules as $module) :
ob_start();
?>
<div class="J_Module skin-<?= $module['skin'] ?>" data-name="<?= $module['name'] ?>" data-skin="<?= $module['skin'] ?>" data-guid="<?= $module['guid'] ?>">
<?php
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
<script charset="utf-8" src="http://a.tbcdn.cn/apps/tms/press/js/<?= $setting['module'] ?>.js?v=<?= $version ?>"></script>
<!-- 模板结束 -->
<?= $footer ?>