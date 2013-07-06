<?php

/**
 * 新建模块接口控制器
 */
class Module_create extends CI_Controller {

	function index () {

		usleep(500000);
		$args = $this->input->post();
		$this->load->model('module');
		$data = $this->module->create($args);
		echo $this->json->encode($data);

	}

}