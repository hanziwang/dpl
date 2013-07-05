<?php

/**
 * 下载模板接口控制器
 */
class Template_download extends CI_Controller {

	function index () {

		$args = array(
			'id' => $this->input->get('id'),
			'name' => $this->input->get('name')
		);
		$url = $this->config->item('tms_file_template');
		$this->load->model('template');
		$data = $this->template->download($url . $args['id'] . '/index.htm', $args);
		echo $this->json->encode($data);

	}

}