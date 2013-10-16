<?php

// 设置系统时间
date_default_timezone_set('Asia/Shanghai');

// 配置服务接口
$tms = 'http://tms.taobao.com/dpl/';
$config['tms_file_template'] = $tms . 'api/template/';
$config['tms_file_module'] = $tms . 'api/module/';
$config['tms_config'] = $tms . 'client/getConfigList.htm';
$config['tms_market'] = $tms . 'client/getMarketList.htm';
$config['tms_template'] = $tms . 'client/getTemplateList.htm';
$config['tms_module'] = $tms . 'client/getModuleList.htm';
$config['tms_type'] = $tms . 'client/getModuleTypes.htm';
$config['tms_author'] = $tms . 'client/getModuleAuthors.htm';
$config['tms_prototype'] = $tms . 'client/getPrototypeInfo.htm';

// 配置系统参数
$config['lessc'] = true;
$config['version'] = '20131016';

// 配置系统路径
$home = dirname(dirname(BASEPATH));
$config['db'] = $home . '/db';
$config['src'] = $home . '/src';

// 配置资源路径
$src = $config['src'];
$config['modules'] = $src . '/modules';
$config['www'] = $src . '/www';
