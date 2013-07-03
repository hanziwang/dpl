<?php

/**
 * 拷贝模板控制器
 */
class Copy extends CI_Controller {

	public function index () {

		$this->load->model(array('get', 'template'));
		$args = array(
			'title' => '拷贝模板 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'markets' => $this->get->market(),
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name')
		);

		// 读取模块信息、合并请求参数
		$template = $this->template->select($args);
		$defaults = array(
			'nickname' => $template->nickname,
			'author' => $template->author,
			'description' => $template->description,
			'imgurl' => $template->imgurl
		);
		$args = array_merge($args, $defaults);

		$this->load->view('header', $args);
		$this->load->view('template/copy');
		$this->load->view('footer');

	}

}