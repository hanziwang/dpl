<?php

/**
 * 模块搜索控制器
 */
class Search extends CI_Controller {

	function index () {

		$args = array(
			'version' => $this->config->item('version'),
			'filter' => $this->input->get('filter'),
			'author' => $this->input->get('author'),
			'width' => $this->input->get('width'),
			'q' => $this->input->get('q')
		);

		// 设置标题
		if ($args['filter'] === 'my') {
			$args['title'] = '我的模块 &lsaquo; 模块管理';
		} elseif ($args['filter'] === 'all') {
			$args['title'] = '所有模块 &lsaquo; 模块管理';
		} elseif ($args['filter'] === 'more') {
			$args['title'] = '更多模块 &lsaquo; 模块管理';
		}

		// 设置查询参数
		$args['query_string'] = $args['author'] ? '&author=' . $args['author'] : '';
		$args['query_string'] = $args['width'] ? '&width=' . $args['width'] : '';
		$args['query_string'] .= $args['q'] ? '&q=' . $args['q'] : '';

		// 读取模块作者列表
		$this->load->model('get');
		$args['authors'] = $this->get->authors();

		$this->load->view('header', $args);
		$this->load->view('module/search');
		$this->load->view('footer');

	}

}