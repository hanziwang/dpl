<?php

/**
 * 所有市场控制器
 */
class All extends CI_Controller {

	function index () {

		$this->load->model('get');
		$markets = $this->get->market();
		foreach ($markets as &$v1) {
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
		$args = array(
			'title' => '所有站点 &lsaquo; 站点管理',
			'version' => $this->config->item('version'),
			'market_all' => $markets
		);
		$this->load->view('header', $args);
		$this->load->view('market/all');
		$this->load->view('footer');

	}

}