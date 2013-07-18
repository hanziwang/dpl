<?php

/**
 * 编辑模板控制器
 */
class Edit extends CI_Controller {

	function index () {

		$this->load->model(array('get', 'template'));
		$args = array (
			'title' => '编辑模板 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'markets' => $this->get->market(),
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name')
		);

		// 读取模板信息、合并请求参数
		$template = $this->template->select($args);
		$defaults = array(
			'nickname' => $template->nickname,
			'author' => $template->author,
			'description' => $template->description,
			'imgurl' => $template->imgurl
		);
		$args = array_merge($args, $defaults);

		// 设置业务标签
		$setting = $this->config->item('setting');
		$args['tags'] = explode(',', $setting['tags']);
		if (isset($template->tag)) {
			$args['tag'] = explode(',', $template->tag);
		} else {
			$args['tag'] = array($setting['default']);
		}

		$this->load->view('header', $args);
		$this->load->view('template/edit');
		$this->load->view('footer');

	}

}