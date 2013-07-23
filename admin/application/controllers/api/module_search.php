<?php

/**
 * 搜索模块接口控制器
 */
class Module_search extends CI_Controller {

	function index () {

		$this->load->library('json');
		$args = array(
			'filter' => $this->input->get('filter'),
			'author' => $this->input->get('author'),
			'width' => $this->input->get('width'),
			'q' => $this->input->get('q'),
			'index' => $this->input->get('index')
		);

		// 模块宽度处理
		$args['width'] = $args['width'] !== '100%' ? $args['width'] : 0;

		// 过滤私有模块
		if ($args['filter'] === 'private') {
			$args['market'] = $this->input->get('market');
			$args['template'] = $this->input->get('template');
		}

		$this->load->model('get');
		$data = $this->get->module($args);
		echo $this->json->encode($data);

	}

}