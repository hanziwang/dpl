<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('template');
		$result = $this->template->copy('985/um-for-test', array(
			'name' => time(),
			'nickname' => '你大爷',
			'marketid' => '968',
			'description' => '我大爷',
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