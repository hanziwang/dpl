<?php

/**
 * 上传模块接口控制器
 */
class Module_upload extends CI_Controller {

	function index () {

		$args = array(
			'name' => $this->input->get('name')
		);
		$url = $this->config->item('tms_file_module');
		$this->load->model('module');
		$data = $this->module->upload($url . 'index.htm', $args);
		echo $this->json->encode($data);

	}

}