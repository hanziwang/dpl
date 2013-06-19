<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('template');
		$result = $this->template->copy(array(
			'name' => 'um-for-test',
			'new_name' => 'um-test',
			'nickname' => '你大爷',
			'market' => '985',
			'new_market' => '985',
			'description' => '我大爷',
			'author' => '',
			'imgurl' => '',
			'id' => 'aac54ed4-93a1-4747-8624-61cb4455b84a',
			'modify_time' => '',
			'version' => '',
			'configid' => '',
			'attribute' => ''
		));
		var_dump($result);

	}

}