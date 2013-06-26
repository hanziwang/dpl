<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$data = array(
			'title' => '多业务规范版 &lsaquo; DPL',
			'version' => $this->config->item('version'),
			'setting' => $this->config->item('setting')
		);

		$this->load->view('header', $data);
		$this->load->view('home');
		$this->load->view('footer');

	}

}