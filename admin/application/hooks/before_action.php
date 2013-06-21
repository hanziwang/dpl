<?php

// 预处理配置参数
function before_action () {

	$ci =& get_instance();
	$ci->load->library('json');

	// 排除用户参数设置页面
	if ($ci->uri->rsegment(1) === 'setting') {
		return;
	}

	// 读取用户参数
	$setting = $ci->config->item('db') . '/.setting';
	if (file_exists($setting)) {
		$data = @file_get_contents($setting);
		$data = $ci->json->decode($data, true);
		$src = $ci->config->item('src') . '/' . $data['company'];
		$ci->config->set_item('config', $data);
		$ci->config->set_item('modules', $src . '/modules');
		$ci->config->set_item('www', $src . '/www');
	} else {
		header('Location: ' . $ci->config->base_url('setting'));
	}

}