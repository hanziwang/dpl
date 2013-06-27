<?php

/**
 * 图片上传接口控制器
 */
class Upload extends CI_Controller {

	function index () {

		$this->load->library('snoopy');
		$this->snoopy->_submit_type = 'multipart/form-data';
		$this->snoopy->submit('http://tps.tms.taobao.com/photo/upload.htm?_input_charset=utf-8', $_REQUEST, $_FILES);
		echo $this->snoopy->results;

	}

}