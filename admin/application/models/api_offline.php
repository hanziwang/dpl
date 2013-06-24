<?php

/**
 * 离线模型
 */
class Api_offline extends CI_Model {

	// 离线远程数据
	function _fetch ($args) {

		$this->load->library('json');

		// 配置基础路径
		$url = $this->config->item('tms_' . $args['id']);
		$db_dir = $this->config->item('db');
		$file = $db_dir . '/.' . $args['id'];

		// 读取远程数据
		if ($data = @file_get_contents($url)) {
			@file_put_contents($file, $data);
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => $args['name'] . '数据离线成功',
				'data' => $file
			);
		} else {
			return array(
				'code' => 400,
				'message' => $args['name'] . '数据离线失败',
				'data' => $file
			);
		}

	}

	// 离线业务规范数据
	function config () {

		return $this->_fetch(array(
			'id' => 'config',
			'name' => '业务规范',
		));

	}

	// 离线市场数据
	function market () {

		return $this->_fetch(array(
			'id' => 'market',
			'name' => '市场'
		));

	}

	// 离线模板数据
	function template () {

		return $this->_fetch(array(
			'id' => 'template',
			'name' => '模板'
		));

	}

	// 离线模块数据
	function module () {

		return $this->_fetch(array(
			'id' => 'module',
			'name' => '模块'
		));

	}

	// 离线模块类型数据
	function types () {

		return $this->_fetch(array(
			'id' => 'types',
			'name' => '模块类型'
		));

	}

	// 离线模块作者数据
	function authors () {

		return $this->_fetch(array(
			'id' => 'authors',
			'name' => '模块作者'
		));

	}

}