<?php

/**
 * 更新业务数据接口控制器
 */
class Update extends CI_Controller {

	function index () {

		usleep(500000);
		$args = array(
			'id' => $this->input->get('id')
		);
		$this->load->library('json');
		$this->load->model('api');
		$data = $this->api->update($args);
		echo $this->json->encode($data);

	}

	// 设置用户参数
	function setting () {

		$this->load->model(array('api', 'get', 'market'));
		$src = $this->config->item('src');
		$args = array(
			'id' => '1',
			'src' => $src . '/taobao'
		);
		$this->api->setting($args);
		$this->config->set_item('setting', $args);
		$this->config->set_item('www', $args['src'] . '/www');
		$markets = $this->get->market();
		foreach ($markets as $v) {
			$this->market->create(array(
				'id' => $v->id
			));
		}
		header('Location: ' . base_url('home'));

	}

}