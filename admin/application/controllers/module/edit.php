<?php

/**
 * 编辑模块控制器
 */
class Edit extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'grid', 'module'));
		$args = array(
			'title' => '编辑模块 &lsaquo; 模块管理',
			'version' => $this->config->item('version'),
			'types' => $this->get->type(),
			'widths' => $this->grid->width(),
			'name' => $this->input->get('name'),
			'category' => array(),
			'tag' => array()
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

		// 设置业务标签
		$setting = $this->config->item('setting');
		$args['tags'] = explode(',', $setting['tags']);
		if (isset($module->tag)) {
			$args['tag'] = explode(',', $module->tag);
		} else {
			$args['tag'] = array($setting['default']);
		}

		// 合并请求参数
		$args = array_merge($args, $defaults);

		$this->load->view('header', $args);
		$this->load->view('module/edit');
		$this->load->view('footer');

	}

}