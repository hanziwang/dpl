<?php

/**
 * 新建市场控制器
 */
class Market_create extends CI_Controller {

	function index () {

		$this->load->library('json');
		$this->load->model('market');
		$args = array(
			'id' => $this->input->get('id')
		);
		$data = $this->market->create($args);
		echo $this->json->encode($data);

	}

}