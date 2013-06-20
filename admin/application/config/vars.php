<?php

// 设置系统时间
date_default_timezone_set('Asia/Shanghai');

// 配置服务接口
$tms = 'http://tms.taobao.com/dpl/';
$config['tms']['api_template'] = $tms . 'api/template/';
$config['tms']['api_module'] = $tms . 'api/module/';
$config['tms']['get_config_list'] = $tms . 'client/getConfigList.htm';
$config['tms']['get_layout_list'] = $tms . 'client/getLayoutList.htm';
$config['tms']['get_market_list'] = $tms . 'client/getMarketList.htm';
$config['tms']['get_template_list'] = $tms . 'client/getTemplateList.htm';
$config['tms']['get_module_list'] = $tms . 'client/getModuleList.htm';
$config['tms']['get_module_types'] = $tms . 'client/getModuleTypes.htm';
$config['tms']['get_module_authors'] = $tms . 'client/getModuleAuthors.htm';

// 配置系统路径
$dir = dirname(dirname(BASEPATH));
$config['db'] = $dir . '/db';
$config['src'] = $dir . '/src';

// 配置资源路径
$src = $config['src'];
$config['modules'] = $src . '/modules';
$config['www'] = $src . '/www';