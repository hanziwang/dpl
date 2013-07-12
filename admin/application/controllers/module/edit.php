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

		$this->load->view('header', $args);
		$this->load->view('module/edit');
		$this->load->view('footer');

	}

}