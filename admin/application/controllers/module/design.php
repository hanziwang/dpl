<?php

/**
 * 调试模块控制器
 */
class Design extends CI_Controller {

	function index () {

		$this->load->helper('tms');
		$this->load->model(array('get', 'market', 'module'));
		$args = array(
			'version' => $this->config->item('version'),
			'market' => $this->input->get('market'),
			'template' => $this->input->get('template'),
			'name' => $this->input->get('name'),
			'skin' => $this->input->get('skin')
		);

		// 设置默认皮肤
		if (empty($args['skin'])) {
			$args['skin'] = 'default';
		}

		// 读取业务规范、市场
		$args['setting'] = $this->config->item('setting');
		$args['markets'] = $this->get->market();
		if (empty($args['market'])) {
			$markets = $args['markets'];
			$args['market'] = $markets[array_rand($markets)]->id;
		}

		// 读取栅格类型
		$defaults = $this->module->select($args);
		$args['grid'] = intval($defaults->width) === 0 ? 'grid-m' : 'grid-m0';

		// 读取页头、模块
		$market = $this->market->read(array(
			'id' => $args['market']
		));
		$header = $market['header'];
		$args['header'] = substr($header, 0, strpos($header, '</head>'));
		$args['module'] = $this->module->read($args);

		// 读取版本相关字段
		$args['tms_id'] = $defaults->id;
		$args['tms_version'] = intval($defaults->version);

		$this->load->view('module/design', $args);

	}

}