<?php

// 设置系统时间
date_default_timezone_set('Asia/Shanghai');

// 配置系统路径
$dir = dirname(FCPATH);
$config['db'] = $dir . DIRECTORY_SEPARATOR . 'db';
$config['src'] = $dir . DIRECTORY_SEPARATOR . 'src';
$config['tmp'] = $dir . DIRECTORY_SEPARATOR . 'tmp';

// 配置资源路径
$src = $config['src'];
$config['modules'] = $src . DIRECTORY_SEPARATOR . 'modules';
$config['www'] = $src . DIRECTORY_SEPARATOR . 'www';