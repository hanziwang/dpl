<?php

/**
 * 更新业务数据控制器
 */
class Update extends CI_Controller {

	function index () {

		$config_id = $this->config->item('id', 'setting');
		$db_dir = $this->config->item('db');
		$args = array(
			'title' => '更新业务数据 &lsaquo; DPL',
			'version' => $this->config->item('version'),
			'config' => $config_id ? $config_id : '1',
			'fileperms' => substr(sprintf('%o', fileperms($db_dir)), -4)
		);
		$this->load->view('header', $args);
		$this->load->view('update');
		$this->load->view('footer');

	}

}