<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('get');
		$result = $this->get->_template_more(array('index'=>1));
		var_dump($result);

	}

}