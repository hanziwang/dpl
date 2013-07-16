<?php

/**
 * 编辑私有模块控制器
 */
class Edit extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'grid', 'module'));
		$args = array(
			'title' => '编辑模块 &lsaquo; 模块管理',
			'version' => $this->config->item('version'),
			'widths' => $this->grid->width(),
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template'),
			'name' => $this->input->get('name'),
			'category' => array()
		);

		// 读取模块信息
		$module = $this->module->select($args);
		$defaults = array(
			'nickname' => $module->nickname,
			'width' => $module->width,
			'author' => $module->author,
			'description' => $module->description,
			'imgurl' => $module->imgurl
		);

		// 设置模块分类
		if (isset($module->category)) {
			$args['category'] = explode(',', $module->category);
		}

		// 合并请求参数
		$args = array_merge($args, $defaults);

		// 设置查询参数
		$args['query_string'] = $args['market'] ? '?market=' . $args['market'] : '';
		$args['query_string'] .= $args['template'] ? '&template=' . $args['template'] : '';

		$this->load->view('template/module/nav', $args);
		$this->load->view('template/module/edit');

	}

}