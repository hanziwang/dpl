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
	<h1 class="logo"><a href="<?= base_url() ?>" title="返回首页"></a></h1>
	<ul class="quick-menu clearfix">
		<li class="item parent">
			<a class="explore" href="javascript:;">市场管理</a>
			<ul class="submenu">
				<li><a href="<?= base_url('market/all') ?>">所有市场</a></li>
			</ul>
		</li>
		<li class="item parent">
			<a class="explore" href="javascript:;">模板管理</a>
			<ul class="submenu">
				<li><a href="<?= base_url('template/create') ?>">新建模板</a></li>
				<li><a href="<?= base_url('template/search?filter=all') ?>">所有模板</a></li>
				<li><a href="<?= base_url('template/search?filter=my') ?>">我的模板</a></li>
			</ul>
		</li>
		<li class="item parent">
			<a class="explore" href="javascript:;">模块管理</a>
			<ul class="submenu">
				<li><a href="<?= base_url('module/create') ?>">新建模块</a></li>
				<li><a href="<?= base_url('module/search?filter=all') ?>">所有模块</a></li>
				<li><a href="<?= base_url('module/search?filter=my') ?>">我的模块</a></li>
			</ul>
		</li>
		<li class="item">
			<a class="explore" href="<?= base_url('update') ?>" title="更新业务数据"><b class="icon icon-update"></b></a>
		</li>
	</ul>
	<ul class="quick-action clearfix">
		<li class="item parent">
			<a class="explore" href="javascript:;">帮助中心</a>
			<ul class="submenu">
				<li><a href="//wiki.tms.taobao.net/dpl:start" target="_blank">使用手册</a></li>
				<li><a href="//wiki.tms.taobao.net/dpl:issues" target="_blank">意见反馈</a></li>
			</ul>
		</li>
		<li class="item">
			<a class="explore" href="<?= base_url('setting') ?>" title="设置用户参数"><b class="icon icon-setting"></b></a>
		</li>
	</ul>
</div>
