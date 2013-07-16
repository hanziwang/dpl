<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="<?= base_url('assets/reset.css?v=' . $version) ?>">
	<link rel="stylesheet" href="<?= base_url('assets/global.css?v=' . $version) ?>">
	<script src="<?= base_url('assets/jquery.js?v=' . $version) ?>"></script>
	<script src="<?= base_url('assets/global.js?v=' . $version) ?>"></script>
</head>
<body>
<div class="header clearfix">
	<ul class="quick-menu clearfix">
		<li class="item">
			<a class="explore" href="<?= base_url('template/module/search' . $query_string) ?>">所有模块</a>
		</li>
		<li class="item">
			<a class="explore" href="<?= base_url('template/module/create' . $query_string) ?>">新建私有模块</a>
		</li>
	</ul>
	<ul class="quick-action clearfix">
		<li class="item">
			<a class="explore" href="javascript:window.top.press.close();" title="关闭窗口"><b class="icon icon-close"></b></a>
		</li>
	</ul>
</div>