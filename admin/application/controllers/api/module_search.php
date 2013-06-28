<?php

/**
 * 搜索模块接口控制器
 */
class Module_search extends CI_Controller {

	function index () {

		$args = array(
			'filter' => $this->input->get('filter'),
			'author' => $this->input->get('author'),
			'width' => $this->input->get('width'),
			'q' => $this->input->get('q'),
			'index' => $this->input->get('index')
		);
		$this->load->library('json');
		$this->load->model('get');
		$data = $this->get->module($args);
		echo $this->json->encode($data);

	}

}