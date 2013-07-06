<?php

/**
 * 新建模块控制器
 */
class Create extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'layout'));
		$args = array (
			'title' => '新建模块 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'types' => $this->get->type(),
			'widths' => $this->layout->width()
		);
		$this->load->view('header', $args);
		$this->load->view('module/create');
		$this->load->view('footer');

	}

}