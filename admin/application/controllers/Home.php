<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');

	}

}