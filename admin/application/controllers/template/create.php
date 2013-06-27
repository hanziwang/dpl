<?php

/**
 * 新建模板控制器
 */
class Create extends CI_Controller {

	public function index () {

		$this->load->model('get');
		$market = $this->get->market();
		$args = array (
			'title' => '新建模板 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'market' => $market
		);
		$this->load->view('header', $args);
		$this->load->view('template/create');
		$this->load->view('footer');

	}

}