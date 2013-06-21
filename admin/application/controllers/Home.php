<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('get');
		$result = $this->get->config();
		var_dump($result);

	}

}