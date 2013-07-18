<?php

/**
 * 更新业务数据接口控制器
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

}