<?php

/**
 * 拷贝模板接口控制器
 */
class Template_copy extends CI_Controller {

	function index () {

		usleep(500000);
		$args = $this->input->post();
		$this->load->model('template');
		$data = $this->template->copy($args);
		echo $this->json->encode($data);

	}

}