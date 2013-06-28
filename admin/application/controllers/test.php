<?php

class Test extends CI_Controller {

	function index () {

		$this->load->model('grid');
		var_dump($this->grid->width());

	}

}