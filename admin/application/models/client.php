<?php

/**
 * 系统功能模型
 */
class Client extends CI_Model {

	// 设置用户参数
	function setting ($args) {

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$config = $db_dir . '/.config';

		// 写入规范参数
		if (!file_exists($config)) {
			$data = @file_get_contents($this->config->item('get_config_list', 'tms'));
			@file_put_contents($config, $data);
			@chmod($config, 0777);
		}

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