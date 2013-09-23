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
		$refer = $this->input->get('refer');
		header('Location:' . base_url('api/setting/download?refer=' . $refer));

	}

	// 写入数据
	function download () {

		$this->load->model(array('get', 'market'));
		$refer = $this->input->get('refer');

		// 写入市场数据
		$markets = $this->get->market();
		foreach ($markets as $v) {
			$this->market->create(array(
				'id' => $v->id
			));
		}

		// 来路判断
		if ($refer === 'setting') {
			header('Location: ' . base_url('setting'));
		}
		if ($refer === 'update') {
			header('Location: ' . base_url());
		}

	}

}