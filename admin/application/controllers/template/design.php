<?php

/**
 * 调试模板控制器
 */
class Design extends CI_Controller {

	function index () {

		$this->load->helper('tms');
		$this->load->library('json');
		$this->load->model(array('get', 'market', 'grid', 'template', 'module'));
		$authors = $this->get->author();
		$grids = $this->grid->grid();
		$args = array(
			'version' => $this->config->item('version'),
			'market' => $this->input->get('market'),
			'name' => $this->input->get('name'),
			'content' => "\r\n",
			'modules' => array(),
			'modules_css' => '',
			'modules_js' => '',
			'authors' => $this->json->encode($authors),
			'grids' => $this->json->encode(array_keys($grids))
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

		// 读取配置信息
		$defaults = $this->template->select(array(
			'market' => $args['market'],
			'name' => $args['name']
		));

		// 解析模板结构数据
		if (isset($defaults->attribute)) {
			foreach ($defaults->attribute as $layout) {
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
						$read = $this->module->read(array(
							'market' => $args['market'],
							'template' => $args['name'],
							'name' => $module['name']
						));

						// 读取模块数据
						$json = dirname($read['json']) . '/' . $module['guid'] . '.json';
						if (file_exists($json)) {
							$read['json'] = $json;
						}

						// 读取模块样式、脚本
						$args['modules_css'] .= $read['css'];
						$args['modules_css'] .= $read['skin/' . $module['skin']];
						$args['modules_js'] .= $read['js'];

						$args['modules'][] = array_merge($module, $read);
						$replace .= "{" . $module['guid'] . "}\r\n";
					}
					$start = strpos($template, '{module}');
					$template = substr_replace($template, $replace, $start, 8);
				}
				$args['content'] .= $template . "\r\n";
			}
		}

		$this->load->view('template/design', $args);

	}

}
