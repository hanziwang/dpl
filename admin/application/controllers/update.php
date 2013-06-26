<?php

/**
 * 更新控制器
 */
class Update extends CI_Controller {

	function index () {

		$this->load->model('get');
		$data = array(
			'title' => '更新业务数据 &lsaquo; DPL',
			'version' => $this->config->item('version')
		);
		$this->load->view('header', $data);
		$this->load->view('update');
		$this->load->view('footer');

	}

}