<?php

/**
 * 设置模型
 */
class Setting extends CI_Model {

	// 存储配置
	function serialize () {

		$db = $this->config->item('db');
		$db = $db . DIRECTORY_SEPARATOR . md5('config');

		if (!file_exists($db)) {
			@file_put_contents($db, serialize(array()));
			@chmod($db, 0777);
		} else {
			$db = @file_get_contents($db);
			$db = unserialize($db);
			var_dump($db);
		}

	}

}