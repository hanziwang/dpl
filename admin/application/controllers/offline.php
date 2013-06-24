<?php

/**
 * 离线控制器
 */
class Offline extends CI_Controller {

	function index () {

		$this->load->view('header');
		$this->load->view('offline');
		$this->load->view('footer');

	}

}