<?php

/**
 * 搜索私有模块控制器
 */
class Search extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'grid'));
		$args = array(
			'title' => '所有模块 &lsaquo; 模块管理',
			'version' => $this->config->item('version'),
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template'),
			'author' => $this->input->get('author'),
			'width' => $this->input->get('width'),
			'q' => $this->input->get('q')
		);

		// 设置查询参数
		$args['query_string'] = $args['market'] ? '?market=' . $args['market'] : '';
		$args['query_string'] .= $args['template'] ? '&template=' . $args['template'] : '';

		// 读取模块作者、宽度列表
		$args['authors'] = $this->get->author();
		$args['widths'] = $this->grid->width();

		$this->load->view('template/module/nav', $args);
		$this->load->view('template/module/search');

	}

}