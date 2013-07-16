<?php

/**
 * 更新业务数据控制器
 */
class Update extends CI_Controller {

	function index () {

		$args = array(
			'title' => '更新业务数据 &lsaquo; DPL',
			'version' => $this->config->item('version')
		);
		$this->load->view('header', $args);
		$this->load->view('update');
		$this->load->view('footer');

	}

}