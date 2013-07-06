<?php

/**
 * 编辑模块接口控制器
 */
class Module_edit extends CI_Controller {

	function index () {

		usleep(500000);
		$args = $this->input->post();
		$this->load->model('module');
		$data = $this->module->update($args);
		echo $this->json->encode($data);

	}

}