<?php

/**
 * 编辑模块控制器
 */
class Edit extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'grid', 'module'));
		$args = array(
			'title' => '编辑模块 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'types' => $this->get->type(),
			'widths' => $this->grid->width(),
			'name' => $this->input->get('name')
		);

		// 读取模块信息、合并请求参数
		$module = $this->module->select($args);
		$defaults = array(
			'nickname' => $module->nickname,
			'category' => isset($module->category) ? explode(',', $module->category) : array(),
			'width' => $module->width,
			'author' => $module->author,
			'description' => $module->description,
			'imgurl' => $module->imgurl
		);
		$args = array_merge($args, $defaults);

		$this->load->view('header', $args);
		$this->load->view('module/edit');
		$this->load->view('footer');

	}

}