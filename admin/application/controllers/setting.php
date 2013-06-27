<?php

/**
 * 设置控制器
 */
class Setting extends CI_Controller {

	function index () {

		$this->load->model('get');
		$args = array(
			'title' => '设置用户参数 &lsaquo; DPL',
			'version' => $this->config->item('version'),
			'config' => $this->get->config(),
			'setting' => $this->config->item('setting'),
			'src' => $this->config->item('src')
		);
		$this->load->view('header', $args);
		$this->load->view('setting');
		$this->load->view('footer');

	}

}