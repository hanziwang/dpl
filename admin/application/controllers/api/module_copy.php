<?php

/**
 * 拷贝模块接口控制器
 */
class Module_copy extends CI_Controller {

	function index () {

		usleep(500000);
		$args = $this->input->post();
		$this->load->model('module');
		$data = $this->module->copy($args);
		echo $this->json->encode($data);

	}

}