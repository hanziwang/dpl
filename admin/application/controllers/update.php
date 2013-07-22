<?php

/**
 * 更新业务数据控制器
 */
class Update extends CI_Controller {

	function index () {

		$config_id = $this->config->item('id', 'setting');
		$args = array(
			'title' => '更新业务数据 &lsaquo; DPL',
			'version' => $this->config->item('version'),
			'config' => $config_id ? $config_id : '1'
		);
		$this->load->view('header', $args);
		$this->load->view('update');
		$this->load->view('footer');

	}

}