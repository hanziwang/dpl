<?php

/**
 * 查询模型
 */
class Get_model extends CI_Model {

	// 查询规范
	function config () {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$config = $db_dir . '/.config';

		// 检查离线数据
		if (!file_exists($config)) {
			header('Location: ' . $this->config->base_url('offline'));
		}

		// 读取规范数据
		$data = @file_get_contents($config);
		return $this->json->decode($data);

	}

	// 查询市场
	function market () {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$config_id = $this->config->item('id', 'config');
		$market = $db_dir . '/.market';

		// 检查离线数据
		if (!file_exists($market)) {
			header('Location: ' . $this->config->base_url('offline'));
		}

		// 读取市场数据
		$data = @file_get_contents($market);
		$data = $this->json->decode($data);
		foreach ($data as $k => &$v) {
			if ($v->configId !== $config_id) {
				unset($data[$k]);
			}
		}
		return $data;

	}

	// 查询全部模板、我的模板
	function _template_common ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$www_dir = $this->config->item('www');

		// 读取市场
		if (!empty($args['market'])) {
			$market_dirs = glob($www_dir . '/' . $args['market'], GLOB_ONLYDIR);
		} else {
			$market_dirs = glob($www_dir . '/*', GLOB_ONLYDIR);
		}

		// 读取模板
		$templates = array();
		$index = 0;
		foreach ($market_dirs as $market_dir) {
			$template_dirs = glob($market_dir . '/*', GLOB_ONLYDIR);
			foreach ($template_dirs as $v) {

				// 从指定页码读取
				if (isset($args['index']) && $args['index'] > $index++) {
					continue;
				}

				// 过滤修改过的模板
				if ($args['filter'] === 'client') {
					if (file_exists($v . '/.md5')) {
						$str = @file_get_contents($v . '/.md5');
						$md5 = $this->dir->md5($v);
						if ($md5 === $str) {
							continue;
						}
					}
				}

				// 读取配置信息
				$data = @file_get_contents($v . '/data.json');
				$data = $this->json->decode($data);

				// 关键字查询
				if (!empty($args['q'])) {
					$haystack = $data->name . $data->nickname . $data->description;
					if (strpos($haystack, $args['q']) === false) {
						continue;
					}
				}

				// 收集模板数据
				array_push($templates, $data);
				if (isset($args['index']) && count($templates) === 1) {
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

	// 查询更多模板
	function _template_update () {

		$this->load->library('json');

		// 配置基础路径
		$db_dir = $this->config->item('db');
		$template = $db_dir . '/.template';

		// 读取模板数据
		if (file_exists($template)) {
			$data = @file_get_contents($template);
		} else {
			$data = @file_get_contents($this->config->item('get_template_list', 'tms'));
			@file_put_contents($template, $data);
			@chmod($template, 0777);
		}
		return $this->json->decode($data);

	}

	// 查询模板
	function template ($args) {

		switch ($args['filter']) {
			case 'client' :
			case 'server' :
				return $this->_template_common($args);
			case 'update' :
				return $this->_template_update();
		}

	}

	// 查询本地模块
	function _module_common ($args) {

		// todo

	}

	// 查询未下载的模块
	function _module_update () {

		// todo

	}

	// 查询私有模块
	function _module_private () {

		// todo

	}

	// 查询模块
	function module () {

		// todo

	}

}