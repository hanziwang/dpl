<?php

/**
 * 更新接口控制器
 */
class Update extends CI_Controller {

	function index () {

		usleep(500000);
		$args = array(
			'id' => $this->input->get('id')
		);
		$this->load->library('json');
		$this->load->model('api');
		$data = $this->api->update($args);
		echo $this->json->encode($data);

	}

	// 设置用户参数
	function setting () {

		sleep(1);
		$config_id = $this->config->item('id', 'setting');
		$args = array(
			'id' => $config_id ? $config_id : '1'
		);
		$this->load->model('api');
		$this->api->setting($args);
		header('Location: ' . base_url('home'));

	}

}