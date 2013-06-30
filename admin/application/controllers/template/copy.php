<?php

/**
 * 拷贝模板控制器
 */
class Copy extends CI_Controller {

	public function index () {

		$this->load->model(array('get', 'template'));
		$markets = $this->get->market();
		$args = array (
			'title' => '拷贝模板 &lsaquo; 模板管理',
			'version' => $this->config->item('version'),
			'markets' => $markets,
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name')
		);
		$template = get_object_vars($this->template->select($args));
		$args = array_merge($args, $template);
		$this->load->view('header', $args);
		$this->load->view('template/copy');
		$this->load->view('footer');

	}

}