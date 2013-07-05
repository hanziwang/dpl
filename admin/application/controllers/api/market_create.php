<?php

/**
 * 新建市场接口控制器
 */
class Market_create extends CI_Controller {

	function index () {

		$this->load->library('json');
		$args = array(
			'id' => $this->input->get('id')
		);
		$this->load->model('market');
		$data = $this->market->create($args);
		echo $this->json->encode($data);

	}

}