<?php

// 设置系统时间
date_default_timezone_set('Asia/Shanghai');

// 配置业务规范
$config['config'] = '1';

// 配置系统路径
$dir = dirname(dirname(BASEPATH));
$config['db'] = $dir . '/db';
$config['src'] = $dir . '/src';

// 配置资源路径
$src = $config['src'];
$config['modules'] = $src . '/modules';
$config['www'] = $src . '/www';