<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('get');
		$result = $this->get->_module_private(array(
			'market' => 843,
			'template' => 'mei-index-2012'
		));
		var_dump($result);

	}

}