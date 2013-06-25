<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$data = array(
			'title' => 'DPL &lsaquo; 多业务规范版',
			'version' => $this->config->item('version'),
			'config' => $this->config->item('config')
		);

		$this->load->view('header', $data);
		$this->load->view('home');
		$this->load->view('footer');

	}

}