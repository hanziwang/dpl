<?php

/**
 * 模块模型
 */
class Module extends CI_Model {

	// 获取模块路径
	function _base_dir ($args) {

		// 处理私有模块和公共模块的路径差异
		if (!empty($args['market']) && !empty($args['template'])) {
			$www_dir = $this->config->item('www');
			return $www_dir . '/' . $args['market'] . '/' . $args['template'] . '/modules/' . $args['name'] . '/';
		} else {
			$modules_dir = $this->config->item('modules');
			return $modules_dir . '/' . $args['name'] . '/';
		}

	}

	// 新建模块
	function create ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$modules_dir = $this->config->item('modules');
		$module_dir = $this->_base_dir($args);

		// 创建模块根目录
		if (!file_exists($modules_dir)) {
			@mkdir($modules_dir, 0777);
		}

		// 创建模块目录
		if (file_exists($module_dir)) {
			return array(
				'code' => 400,
				'message' => '模块已经存在'
			);
		} else {
			@mkdir($module_dir, 0777);
		}

		// 拷贝并重命名文件
		$config_module = $this->config->item('module', 'config');
		$data_dir = dirname(BASEPATH) . '/data/module/' . $config_module . '/';
		$this->dir->copy($data_dir, $module_dir);
		$this->dir->chmod($module_dir, 0777);
		foreach (array('.css', '.js', '.php', '.less') as $v) {
			@rename($module_dir . $v, $module_dir . $args['name'] . $v);
		}

		// 默认配置信息
		$defaults = array(
			'name' => $args['name'],
			'nickname' => $args['nickname'],
			'width' => $args['width'],
			'author' => $args['author'],
			'category' => $args['category'],
			'description' => $args['description'],
			'drafturl' => $args['drafturl'],
			'imgurl' => $args['imgurl'],
			'id' => '',
			'modify_time' => '',
			'version' => '',
			'configid' => $this->config->item('id', 'config')
		);

		// 替换模块占位符
		$module_files = array(
			'skin/default.less',
			$args['name'] . '.css',
			$args['name'] . '.js',
			$args['name'] . '.php'
		);
		foreach ($module_files as $v) {
			$data = @file_get_contents($module_dir . $v);
			$data = str_replace('{{module}}', $args['name'], $data);
			@file_put_contents($module_dir . $v, $data);
		}

		// 写入模块配置信息
		$file = $module_dir . 'data.json';
		if (@file_put_contents($file, $this->json->encode($defaults))) {
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => '模块新建成功',
				'data' => $module_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模块新建失败',
				'data' => $module_dir
			);
		}

	}

}