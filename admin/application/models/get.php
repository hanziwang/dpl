<?php

/**
 * 查询模型
 */
class Get extends CI_Model {

	// 查询规范
	function config () {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$config = $db_dir . '/.config';

		// 读取规范数据
		if (file_exists($config)) {
			$data = @file_get_contents($config);
		} else {
			$data = @file_get_contents($this->config->item('get_config_list', 'tms'));
			@file_put_contents($config, $data);
			@chmod($config, 0777);
		}
		return $this->json->decode($data);

	}

	// 查询市场
	function market () {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$market = $db_dir . '/.market';

		// 读取市场数据
		if (file_exists($market)) {
			$data = @file_get_contents($market);
		} else {
			$data = @file_get_contents($this->config->item('get_market_list', 'tms'));
			@file_put_contents($market, $data);
			@chmod($market, 0777);
		}
		return $this->json->decode($data);

	}

	// 查询本地模板
	function _template_common ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$www_dir = $this->config->item('www');

		// 读取市场
		if (!empty($args['market'])) {
			$market_dirs = glob($www_dir . '/' . $args['market']);
		} else {
			$market_dirs = glob($www_dir . '/*');
		}

		// 读取模板
		$templates = array();
		$index = 0;
		foreach ($market_dirs as $market_dir) {
			$template_dirs = glob($market_dir . '/*');
			foreach ($template_dirs as $template_dir) {
				if (isset($args['index']) && $args['index'] > $index) {
					continue;
				}
				if (!is_dir($template_dir)) {
					continue;
				}
				$data = @file_get_contents($template_dir . '/data.json');
				$data = $this->json->decode($data);

				// 查询修改过的模板
				if ($args['filter'] === 'client') {
					if (file_exists($template_dir . '/.md5')) {
						$str = @file_get_contents($template_dir . '/.md5');
						$md5 = $this->dir->md5($template_dir);
						if ($md5 === $str) {
							continue;
						}
					}
				}

				// 关键字查询
				if (!empty($args['q'])) {
					if (strpos($args['q'], $data->name . ',' . $data->nickname . ',' . $data->description) === false) {
						continue;
					}
				}

				// 导入模板堆栈
				array_push($templates, $data);

				// 根据堆栈长度判断是否跳出查询
				if (isset($args['index']) && count($templates) === 10) {
					return array(
						'code' => $index,
						'data' => $templates
					);
				}
			}
		}
		return array(
			'code' => $index,
			'data' => $templates
		);

	}

	// 查询模板
	function template ($args) {

		switch ($args['filter']) {

			case 'server' :
			case 'client' :
			{
				return $this->_template_common($args);
			}
			case 'update' :
			{
				return $this->_template_update($args);
			}

		}

	}

}