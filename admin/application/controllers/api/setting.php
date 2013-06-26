<?php

/**
 * 设置接口控制器
 */
class setting extends CI_Controller {

	function index () {

		sleep(1);
		$args = array(
			'id' => $this->input->get('id')
		);
		$this->load->library('json');
		$this->load->model('api');
		$data = $this->api->setting($args);
		echo $this->json->encode($data);

	}

}