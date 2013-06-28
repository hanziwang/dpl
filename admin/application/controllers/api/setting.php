<?php

/**
 * 设置接口控制器
 */
class setting extends CI_Controller {

	function index () {

		usleep(500000);
		$args = array(
			'id' => $this->input->get('id')
		);
		$this->load->model('api');
		$this->api->setting($args);
		header('Location: ' . base_url('setting'));

	}

}