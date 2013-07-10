<?php

/**
 * 私有模块接口控制器
 */
class Module_private extends CI_Controller {

	function index () {

		$args = array(
			'filter' => 'private',
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template')
		);

		$this->load->library('json');
		$this->load->model('get');
		$data = $this->get->module($args);
		echo $this->json->encode($data);

	}

}