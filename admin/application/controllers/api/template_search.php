<?php

/**
 * 搜索模板接口控制器
 */
class Template_search extends CI_Controller {

	function index () {

		$args = array(
			'filter' => $this->input->get('filter'),
			'market' => $this->input->get('market'),
			'q' => $this->input->get('q'),
			'index' => $this->input->get('index')
		);
		$this->load->library('json');
		$this->load->model('get');
		$data = $this->get->template($args);
		echo $this->json->encode($data);

	}

}