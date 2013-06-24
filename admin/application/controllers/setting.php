<?php

/**
 * 设置控制器
 */
class Setting extends CI_Controller {

	function index () {

		$this->load->view('header');
		$this->load->view('setting');
		$this->load->view('footer');

	}

}