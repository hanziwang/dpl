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

		// 过滤私有模板筛选
		if ($args['filter'] === 'private') {
			$args['market'] = $this->input->get('market');
			$args['template'] = $this->input->get('template');
		}

		$this->load->library('json');
		$this->load->model('get');
		$data = $this->get->module($args);
		echo $this->json->encode($data);

	}

}