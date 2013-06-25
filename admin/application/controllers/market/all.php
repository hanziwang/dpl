<?php

/**
 * 所有市场控制器
 */
class All extends CI_Controller {

	function index () {

		$this->load->model('get');
		$market = $this->get->market();
		foreach ($market as &$v1) {
			$v1->color = explode(';', $v1->color);
			foreach ($v1->color as $k => &$v2) {
				if (!empty($v2)) {
					$v2 = explode(':', $v2);
					$v2 = trim($v2[1]);
				} else {
					unset($v1->color[$k]);
				}
			}
		}
		$data = array(
			'title' => '所有站点 &lsaquo; 站点管理',
			'version' => $this->config->item('version'),
			'market' => $market
		);

		$this->load->view('header', $data);
		$this->load->view('market/all');
		$this->load->view('footer');

	}

}