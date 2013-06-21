<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('get');
		$result = $this->get->template(array(
			'filter' => 'update',
			'q' => '食品',
			'market' => '985'
		));
		var_dump($result);

	}

}