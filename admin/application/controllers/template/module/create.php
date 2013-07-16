<?php

/**
 * 新建私有模块控制器
 */
class Create extends CI_Controller {

	function index () {

		$this->load->model('grid');
		$args = array (
			'title' => '新建私有模块 &lsaquo; 模块管理',
			'version' => $this->config->item('version'),
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template'),
			'widths' => $this->grid->width()
		);

		// 设置查询参数
		$args['query_string'] = $args['market'] ? '?market=' . $args['market'] : '';
		$args['query_string'] .= $args['template'] ? '&template=' . $args['template'] : '';

		$this->load->view('template/module/nav', $args);
		$this->load->view('template/module/create');

	}

}