<?php

/**
 * 搜索模板控制器
 */
class Search extends CI_Controller {

	function index () {

		$this->load->model('get');
		$args = array(
			'version' => $this->config->item('version'),
			'filter' => $this->input->get('filter'),
			'market' => $this->input->get('market'),
			'q' => $this->input->get('q')
		);

		// 设置过滤参数
		$args['filter'] = $args['filter'] ? $args['filter'] : 'all';

		// 设置标题
		if ($args['filter'] === 'my') {
			$args['title'] = '我的模板 &lsaquo; 模板管理';
		} elseif ($args['filter'] === 'all') {
			$args['title'] = '所有模板 &lsaquo; 模板管理';
		} elseif ($args['filter'] === 'more') {
			$args['title'] = '更多模板 &lsaquo; 模板管理';
		}

		// 设置查询参数
		$args['query_string'] = $args['market'] ? '&market=' . $args['market'] : '';
		$args['query_string'] .= $args['q'] ? '&q=' . $args['q'] : '';

		// 读取市场列表
		$args['markets'] = $this->get->market();

		$this->load->view('header', $args);
		$this->load->view('template/search');
		$this->load->view('footer');

	}

}