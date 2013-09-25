<?php

/**
 * 原型版本查询接口控制器
 */
class Tms_version extends CI_Controller {

	function index () {

		$args = array(
			'id' => $this->input->get('id')
		);
		$url = $this->config->item('tms_prototype');
		$url = $url . '?tmsId=' . $args['id'];
		echo @file_get_contents($url);

	}

}