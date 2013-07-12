<?php

/**
 * 图片上传接口控制器
 */
class Upload extends CI_Controller {

	function index () {

		$this->load->library('snoopy');
		$this->snoopy->_submit_type = 'multipart/form-data';
		$dirname = dirname($_FILES['photo']['tmp_name']);
		$name = $dirname . DIRECTORY_SEPARATOR . $_FILES['photo']['name'];
		@chmod($dirname, 0777);
		if (move_uploaded_file($_FILES['photo']['tmp_name'], $name)) {
			$_FILES['photo']['tmp_name'] = $name;
		}
		$this->snoopy->submit('http://tps.tms.taobao.com/photo/upload.htm?_input_charset=utf-8', $_REQUEST, $_FILES);
		echo $this->snoopy->results;

	}

}