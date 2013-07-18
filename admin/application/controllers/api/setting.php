<?php

/**
 * 设置用户参数接口控制器
 */
class setting extends CI_Controller {

	function index () {

		usleep(500000);
		$this->load->model('api');
		$args = array(
			'id' => $this->input->get('id')
		);
		$this->api->setting($args);
		$ref = $this->input->get('ref');
		header('Location:' . base_url('api/setting/download?ref=' . $ref));

	}

	// 写入数据
	function download () {

		$this->load->model(array('get', 'market'));
		$ref = $this->input->get('ref');

		// 写入市场数据
		$markets = $this->get->market();
		foreach ($markets as $v) {
			$this->market->create(array(
				'id' => $v->id
			));
		}

		// 来路判断
		if ($ref === 'setting') {
			header('Location: ' . base_url('setting'));
		}
		if ($ref === 'update') {
			header('Location: ' . base_url());
		}

	}

}