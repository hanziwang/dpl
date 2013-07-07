<?php

/**
 * 拷贝模块控制器
 */
class Copy extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'layout', 'module'));
		$args = array(
			'title' => '拷贝模块 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'types' => $this->get->type(),
			'widths' => $this->layout->width(),
			'name' => $this->input->get('name'),
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
		$this->load->view('module/copy');
		$this->load->view('footer');

	}

}