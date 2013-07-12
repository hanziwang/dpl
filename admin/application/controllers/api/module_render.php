<?php

/**
 * 渲染模块接口控制器
 */
class Module_render extends CI_Controller {

	function index () {

		$this->load->helper('tms');
		$this->load->library('json');
		$this->load->model(array('get', 'module'));
		$args = array(
			'filter' => $this->input->get('filter'),
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name')
		);

		// 过滤私有模板筛选
		if ($args['filter'] === 'private') {
			$args['template'] = $this->input->get('template');
		}

		// 渲染模块代码
		$data = $this->module->read($args);
		ob_start();
		_tms_import($data['json']);
		eval(' ?>' . $data['php'] . '<?php ');
		$data['php'] = ob_get_contents();
		ob_end_clean();

		echo $this->json->encode($data);

	}

}