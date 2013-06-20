<?php

/**
 * 设置控制器
 */
class Setting extends CI_Controller {

	function index () {

		$this->load->model('client');
		$args = array('id' => '1');
		$result = $this->client->setting($args);
		var_dump($result);

	}

}