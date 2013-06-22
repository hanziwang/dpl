<?php

// 预处理配置参数
function before_action () {

	$ci =& get_instance();
	$ci->load->library('json');

	// 排除用户参数设置页面
	$filter = array('setting', 'offline');
	if (in_array($ci->uri->rsegment(1), $filter)) {
		return;
	}

	// 检查离线数据
	$setting = $ci->config->item('db') . '/.setting';
	if (!file_exists($setting)) {
		header('Location: ' . $ci->config->base_url('setting'));
	}

	// 读取用户参数
	$data = @file_get_contents($setting);
	$data = $ci->json->decode($data, true);
	$src = $ci->config->item('src') . '/' . $data['company'];
	$ci->config->set_item('config', $data);
	$ci->config->set_item('modules', $src . '/modules');
	$ci->config->set_item('www', $src . '/www');

}