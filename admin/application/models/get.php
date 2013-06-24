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
				$templates[] = $data;
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

	// 查询更多模板
	function _template_more ($args) {

		$this->load->library('json');

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$db_dir = $this->config->item('db');
		$template = $db_dir . '/.template';

		// 读取模板数据
		$templates = array();
		$index = 0;
		$data = @file_get_contents($template);
		$data = $this->json->decode($data, true);
		foreach ($data as $v) {

			// 从指定页码读取
			if (isset($args['index']) && $args['index'] > $index++) {
				continue;
			}

			// 过滤模板数据
			$file = $www_dir . '/' . $v['marketid'] . '/' . $v['name'] . '/data.json';
			if (file_exists($file)) {
				$file = @file_get_contents($file);
				$file = $this->json->decode($file);
				if (intval($v['version']) > intval($file->version)) {
					$templates[] = $v;
				}
			} else {
				$templates[] = $v;
			}

			// 收集模板数据
			if (isset($args['index']) && count($templates) === 10) {
				return array(
					'code' => $index,
					'data' => $templates
				);
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
			case 'client' :
			case 'server' :
				return $this->_template_common($args);
			case 'more' :
				return $this->_template_more($args);
		}

	}

	// 查询全部模块、我的模块
	function _module_common ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$modules_dir = $this->config->item('modules');

		// 读取模块
		$modules = array();
		$index = 0;
		$modules_dirs = glob($modules_dir . '/*', GLOB_ONLYDIR);
		foreach ($modules_dirs as $v) {

			// 从指定页码读取
			if (isset($args['index']) && $args['index'] > $index++) {
				continue;
			}

			// 过滤修改过的模块
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

			// 模块作者查询
			if (!empty($args['author'])) {
				if ($args['author'] === $data->author) {
					continue;
				}
			}

			// 模块宽度查询
			if (!empty($args['width'])) {
				if ($args['width'] === 0 || $args['width'] === $data->width) {
					continue;
				}
			}

			// 关键字查询
			if (!empty($args['q'])) {
				$haystack = $data->name . $data->nickname . $data->description;
				if (strpos($haystack, $args['q']) === false) {
					continue;
				}
			}

			// 收集模块数据
			$modules[] = $data;
			if (isset($args['index']) && count($modules) === 10) {
				return array(
					'code' => $index,
					'data' => $modules
				);
			}
		}
		return array(
			'code' => $index,
			'data' => $modules
		);

	}

	// 查询更多模块
	function _module_more ($args) {

		$this->load->library('json');

		// 配置基础路径
		$modules_dir = $this->config->item('modules');
		$db_dir = $this->config->item('db');
		$module = $db_dir . '/.module';

		// 读取模块数据
		$modules = array();
		$index = 0;
		$data = @file_get_contents($module);
		$data = $this->json->decode($data, true);
		foreach ($data as $v) {

			// 从指定页码读取
			if (isset($args['index']) && $args['index'] > $index++) {
				continue;
			}

			// 过滤模块数据
			$file = $modules_dir . '/' . $v['name'] . '/data.json';
			if (file_exists($file)) {
				$file = @file_get_contents($file);
				$file = $this->json->decode($file);
				if (intval($v['version']) > intval($file->version)) {
					$modules[] = $v;
				}
			} else {
				$modules[] = $v;
			}

			// 收集模块数据
			if (isset($args['index']) && count($modules) === 10) {
				return array(
					'code' => $index,
					'data' => $modules
				);
			}
		}
		return array(
			'code' => $index,
			'data' => $modules
		);

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