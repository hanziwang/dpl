<?php header('content-type:text/html;charset=UTF-8'); ?>
<?php _tms_import($path . $name . '.json'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="gbk">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>im-img-a1</title>
<link rel="stylesheet" href="http://a.tbcdn.cn/??tbsp/tbsp.css,p/global/1.0/global-min.css">
<script src="http://a.tbcdn.cn/??s/kissy/1.2.0/kissy-min.js,p/global/1.0/global-min.js,p/market/r/120507/market-min.js,p/market/2011/common_v2.js,p/market/ui/ui.js"></script>
<style>
<?= $css ?>
<?= $less ?>
</style>
<div class="J_Module skin-default" data-name="im-img-a1" style="margin:50px;">
<?= eval(' ?>' . $content . '<?php '); ?>
</div>
<script>
<?= $js ?>
</script>
<?php _tms_export($path . $name . '.json'); ?>