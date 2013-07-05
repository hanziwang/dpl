<?php

/**
 * 上传模板接口控制器
 */
class Template_upload extends CI_Controller {

	function index () {

		$args = array(
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name')
		);
		$url = $this->config->item('tms_file_template');
		$this->load->model('template');
		$data = $this->template->upload($url . 'index.htm', $args);
		echo $this->json->encode($data);

	}

}