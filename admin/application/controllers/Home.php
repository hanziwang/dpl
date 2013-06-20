<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('module');
		$result = $this->module->copy('www/985/um-for-test', array(
			'name' => 'um-for-test-' . time(),
			'nickname' => '测试',
			'marketid' => '986',
			'width' => '540',
			'author' => '邦彦',
			'category' => '1,3,4',
			'description' => '测试',
			'imgurl' => ''
		));
		var_dump($result);

	}

}