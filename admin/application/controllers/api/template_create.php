<?php

/**
 * 新建模板接口控制器
 */
class Template_create extends CI_Controller {

	function index () {

		$args = $this->input->post();
		$this->load->model('template');
		$data = $this->template->create($args);
		echo $this->json->encode($data);

	}

}