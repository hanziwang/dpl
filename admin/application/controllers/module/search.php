<?php

/**
 * 搜索模块控制器
 */
class Search extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'grid'));
		$args = array(
			'version' => $this->config->item('version'),
			'filter' => $this->input->get('filter'),
			'author' => $this->input->get('author'),
			'width' => $this->input->get('width'),
			'q' => $this->input->get('q')
		);

		// 设置过滤参数
		$args['filter'] = $args['filter'] ? $args['filter'] : 'all';

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
		$args['query_string'] .= $args['width'] !== '' ? '&width=' . $args['width'] : '';
		$args['query_string'] .= $args['q'] ? '&q=' . $args['q'] : '';

		// 读取模块作者、宽度列表
		$args['authors'] = $this->get->author();
		$args['widths'] = $this->grid->width();

		$this->load->view('header', $args);
		$this->load->view('module/search');
		$this->load->view('footer');

	}

}