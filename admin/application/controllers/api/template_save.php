<?php

/**
 * 保存模板接口控制器
 */
class Template_save extends CI_Controller {

	function index () {

		usleep(500000);
		$args = $this->input->post();
		$args = array_merge($args, array(
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name')
		));
		$this->load->model('template');
		$data = $this->template->update($args);
		echo $this->json->encode($data);

	}

}