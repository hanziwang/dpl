<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('template');
		$result = $this->template->select(array(
			'name' => 'test1370802842',
			'nickname' => '测试你大爷',
			'market' => '985',
			'description' => '测试下',
			'author' => '',
			'imgurl' => '',
			'id' => '',
			'modify_time' => '',
			'version' => '',
			'configid' => '',
			'attribute' => ''
		));
		var_dump($result);

	}

}