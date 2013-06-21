<?php

/**
 * 首页控制器
 */
class Home extends CI_Controller {

	function index () {

		$this->load->model('module');
		$result = $this->module->download('http://cms.taobao.com/dpl/api/module/1408c02d-63a5-40cd-85a7-d5624a4e894f/index.htm', array(
			'id' => '1408c02d-63a5-40cd-85a7-d5624a4e894f'
		));
		var_dump($result);

	}

}