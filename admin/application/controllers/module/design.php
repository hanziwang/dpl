<?php

/**
 * 设计模块控制器
 */
class Design extends CI_Controller {

	public function index () {

		$this->load->helper('tms');
		$this->load->library('lessc');
		$this->load->model('module');
		$args = array (
			'title' => '设计模块 &lsaquo; 模块管理',
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template'),
			'name' => $this->input->get('name')
		);
		$path = $this->module->base_dir($args);
		$args['path'] = $path;

		// 处理模块文件编码
		$files['css'] = @file_get_contents($path . $args['name'] . '.css');
		$files['less'] = @file_get_contents($path . 'skin/default.less');
		$files['js'] = @file_get_contents($path . $args['name'] . '.js');
		$files['less'] = $this->lessc->parse($files['less']);
		$files['content'] = @file_get_contents($path . $args['name'] . '.php');
		$files['content'] = @iconv('GBK', 'UTF-8//IGNORE', $files['content']);
		$args = array_merge($args, $files);
		$this->load->view('module/design', $args);

	}

}