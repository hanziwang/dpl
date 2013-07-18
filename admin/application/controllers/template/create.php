<?php

/**
 * 新建模板控制器
 */
class Create extends CI_Controller {

	function index () {

		$this->load->model('get');
		$markets = $this->get->market();
		$args = array (
			'title' => '新建模板 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'markets' => $markets
		);

		// 设置业务标签
		$setting = $this->config->item('setting');
		$args['tags'] = explode(',', $setting['tags']);
		$args['default'] = $setting['default'];

		$this->load->view('header', $args);
		$this->load->view('template/create');
		$this->load->view('footer');

	}

}