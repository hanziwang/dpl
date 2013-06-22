<?php

/**
 * 设置控制器
 */
class Setting extends CI_Controller {

	function index () {

		$this->load->model('get_model', 'get');
		$result = $this->get->config();
		var_dump($result);

	}

}