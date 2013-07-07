<?php

// 预处理配置参数
function before_action () {

	$ci =& get_instance();
	$ci->load->library('json');

	// 排除特定页面
	if ($ci->uri->rsegment(1) === 'update') {
		return;
	}

	// 检查本地数据
	$db_dir = $ci->config->item('db');
	$files = array('config', 'setting', 'template', 'module', 'type', 'author');
	foreach ($files as $v) {
		if (!file_exists($db_dir . '/' . $v . '.json')) {
			header('Location: ' . base_url('update'));
		}
	}

	// 读取用户参数
	$data = @file_get_contents($db_dir . '/setting.json');
	$data = $ci->json->decode($data, true);
	$src = $ci->config->item('src') . '/' . $data['code'];
	$ci->config->set_item('setting', $data);
	$ci->config->set_item('src', $src);
	$ci->config->set_item('modules', $src . '/modules');
	$ci->config->set_item('www', $src . '/www');

}