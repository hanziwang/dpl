<?php

/**
 * 接口模型
 */
class Api extends CI_Model {

	// 更新业务数据
	function update ($args) {

		$this->load->library('json');

		// 配置基础路径
		$url = $this->config->item('tms_' . $args['id']);
		$db_dir = $this->config->item('db');
		$file = $db_dir . '/.' . $args['id'];

		// 读取业务数据
		if ($buffer = @file_get_contents($url)) {
			@file_put_contents($file, $buffer);
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => $args['name'] . '数据更新成功',
				'data' => $file
			);
		} else {
			return array(
				'code' => 400,
				'message' => $args['name'] . '数据更新失败',
				'data' => $file
			);
		}

	}

	// 设置用户参数
	function setting ($args) {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');

		// 写入用户参数
		$data = @file_get_contents($db_dir . '/.config');
		$data = $this->json->decode($data);
		foreach ($data as $v) {
			if (intval($v->id) === intval($args['id'])) {
				$v = $this->json->encode($v);
				@file_put_contents($db_dir . '/.setting', $v);
				break;
			}
		}
		return array(
			'code' => 200,
			'message' => '用户参数设置成功'
		);

	}

}