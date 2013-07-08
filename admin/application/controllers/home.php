<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$args = array(
			'title' => '多终端版 &lsaquo; DPL',
			'version' => $this->config->item('version'),
			'setting' => $this->config->item('setting')
		);
		$this->load->view('header', $args);
		$this->load->view('home');
		$this->load->view('footer');

	}

}