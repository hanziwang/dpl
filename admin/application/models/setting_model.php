<?php

/**
 * 设置模型
 */
class Setting_model extends CI_Model {

	// 设置用户参数
	function save ($args) {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$config = $db_dir . '/.config';

		// 写入用户参数
		$data = $this->json->decode(@file_get_contents($config));
		foreach ($data as $v) {
			if (intval($v->id) === intval($args['id'])) {
				$v = $this->json->encode($v);
				@file_put_contents($db_dir . '/.setting', $v);
				break;
			}
		}
		return array(
			'code' => 200,
			'message' => '用户参数写入成功',
			'data' => $config
		);

	}

}