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
		$data_dir = dirname(BASEPATH) . '/data/module/' . $config['config']['module'];
		$this->dir->copy($data_dir, $module_dir);
		$this->dir->chmod($module_dir, 0777);
		foreach (array('.css', '.js', '.php') as $v) {
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
			'configid' => $this->config->item('config')
		);

		//将基础模块拷进当前模块目录
		$source_files = array_diff(scandir($source_dir), array('.', '..', '.svn'));

		foreach ($source_files as $v) {
			$filepath = $source_dir . $v;
			if (!is_dir($filepath)) {
				$dst = $module_dir . $args['name'] . $v;
				@copy($filepath, $dst);
				@chmod($dst, 0777);
			} else {
				$this->dir->copy_dir($filepath, $module_dir . $v);
				$this->dir->chmod_dir($module_dir . $v, 0777);
			}
		}

		//预处理模版占位符
		$module_singles = array(
			'skin/default.less',
			$args['name'] . '.css',
			$args['name'] . '.js',
			$args['name'] . '.php'
		);

		foreach ($module_singles as $v) {
			$buffer = @file_get_contents($module_dir . $v);
			$buffer = str_replace('{module}', $args['name'], $buffer);
			@file_put_contents($module_dir . $v, $buffer);
			@chmod($module_dir . $v, 0777);
		}

		//写入模块配置
		if (@file_put_contents($module_dir . 'data.json', json_encode($cfg))) {
			@chmod($module_dir . 'data.json', 0777);
			return array(
				'code' => 200,
				'message' => '模块新建成功',
				'data' => $module_dir
			);
		}

	}

}