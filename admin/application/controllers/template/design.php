<?php

/**
 * 调试模板控制器
 */
class Design extends CI_Controller {

	function index () {

		$this->load->helper('tms');
		$this->load->model(array('get', 'market', 'grid', 'template', 'module'));
		$args = array(
			'version' => $this->config->item('version'),
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name'),
			'content' => "\r\n",
			'modules' => array()
		);

		// 读取业务规范
		$args['setting'] = $this->config->item('setting');

		// 读取页头、导航、页尾
		$args = array_merge($args, $this->market->read(array(
			'id' => $args['market']
		)));

		// 读取样式、脚本
		$args = array_merge($args, $this->template->read(array(
			'market' => $args['market'],
			'name' => $args['name']
		)));

		// 读取模板配置信息
		$defaults = $this->template->select(array(
			'market' => $args['market'],
			'name' => $args['name']
		));

		// 解析模板结构数据
		$attribute = $defaults->attribute;
		foreach ($attribute as $layout) {
			$template = $this->grid->template($layout->grid);
			foreach ($layout->region as $region) {
				$replace = "\r\n";
				if (empty($region)) {
					$start = strpos($template, '{module}');
					$template = substr_replace($template, $replace, $start, 8);
					continue;
				}
				foreach ($region as $module) {
					$module = get_object_vars($module);
					$data = $this->module->read(array(
						'market' => $args['market'],
						'template' => $args['name'],
						'name' => $module['name']
					));
					$args['css'] .= $data['css'];
					$args['css'] .= $data['skin-' . $module['skin']];
					$args['js'] .= $data['js'];
					$args['modules'][] = array_merge($module, $data);
					$replace .= "{" . $module['guid'] . "}\r\n";
				}
				$start = strpos($template, '{module}');
				$template = substr_replace($template, $replace, $start, 8);
			}
			$args['content'] .= $template . "\r\n";
		}

		$this->load->view('template/design', $args);

	}

}