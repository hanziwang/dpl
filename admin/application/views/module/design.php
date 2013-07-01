<?php header('content-type:text/html;charset=UTF-8'); ?>
<?php _tms_import($path . $name . '.json'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="gbk">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>im-img-a1</title>
<link rel="stylesheet" href="http://a.tbcdn.cn/??tbsp/tbsp.css,p/global/1.0/global-min.css">
<script src="http://a.tbcdn.cn/s/kissy/1.3.0/seed-min.js"></script>
<style>
<?= $css ?>
<?= $less ?>
</style>
</head>
<body>
<div class="J_Module skin-default" data-name="im-img-a1" style="margin-top:50px;margin-left:50px;">
<?= eval(' ?>' . $content . '<?php '); ?>
</div>
<script>
<?= $js ?>
</script>
<script>
<?= $render_callback ?>
</script>
<?php _tms_export($path . $name . '.json'); ?>
</body>
</html>