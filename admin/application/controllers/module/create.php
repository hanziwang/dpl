<?php

/**
 * 新建模块控制器
 */
class Create extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'grid'));
		$args = array (
			'title' => '新建公共模块 &lsaquo; 模块管理',
			'version' => $this->config->item('version'),
			'types' => $this->get->type(),
			'widths' => $this->grid->width()
		);
		$this->load->view('header', $args);
		$this->load->view('module/create');
		$this->load->view('footer');

	}

}