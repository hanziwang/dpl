<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('get');
		$result = $this->get->_template_common(array(
			'filter' => 'client',
			'key' => 'mei-index'
		));
		var_dump($result);

	}

}