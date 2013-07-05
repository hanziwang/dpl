<?php

/**
 * 编辑模板接口控制器
 */
class Template_edit extends CI_Controller {

	function index () {

		usleep(500000);
		$args = $this->input->post();
		$this->load->model('template');
		$data = $this->template->update($args);
		echo $this->json->encode($data);

	}

}