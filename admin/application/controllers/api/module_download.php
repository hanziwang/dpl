<?php

/**
 * 下载模块接口控制器
 */
class Module_download extends CI_Controller {

	function index () {

		$args = array(
			'id' => $this->input->get('id'),
			'name' => $this->input->get('name')
		);
		$url = $this->config->item('tms_file_module');
		$this->load->model('module');
		$data = $this->module->download($url . $args['id'] . '/index.htm', $args);
		echo $this->json->encode($data);

	}

}