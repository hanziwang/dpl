<?php

/**
 * 设计模块控制器
 */
class Design extends CI_Controller {

	public function index () {

		$this->load->helper('tms');
		$this->load->library('lessc');
		$this->load->model('module');
		$setting = $this->config->item('setting');
		$args = array (
			'title' => '设计模块 &lsaquo; 模块管理',
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template'),
			'name' => $this->input->get('name')
		);
		$path = $this->module->base_dir($args);
		$args['path'] = $path;
		$files['css'] = @file_get_contents($path . $args['name'] . '.css');
		$files['less'] = @file_get_contents($path . 'skin/default.less');
		$files['js'] = @file_get_contents($path . $args['name'] . '.js');
		$files['less'] = $this->lessc->parse($files['less']);
		$files['content'] = @file_get_contents($path . $args['name'] . '.php');
		$files['content'] = @iconv('GBK', 'UTF-8//IGNORE', $files['content']);
		$files['render_callback'] = @file_get_contents($data_dir = dirname(BASEPATH) . '/data/render_callback/' . $setting['module'] . '.js');
		$args = array_merge($args, $files);
		$this->load->view('module/design', $args);

	}

}