<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('template');
		$result = $this->template->upload('http://cms.taobao.com/dpl/api/module/index.htm', array(
			'name' => 'um-for-test',
			'nickname' => '你大爷',
			'market' => '985',
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