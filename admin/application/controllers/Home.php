<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('module');
		$this->module->create(array(
			'name' => 'um-for-test',
			'nickname' => '测试',
			'width' => '540',
			'author' => '邦彦',
			'category' => '1,3,4',
			'description' => '测试',
			'drafturl' => '',
			'imgurl' => ''
		));

	}

}