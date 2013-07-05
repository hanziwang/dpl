<?php

/**
 * 布局模型
 */
class Layout extends CI_Model {

	// 栅格公式
	private $rules = array(
		'990' => array(
			'n' => 20,
			'c' => 50,
			'g' => 10
		),
		'950' => array(
			'n' => 24,
			'c' => 40,
			'g' => 10
		),
		'940' => array(
			'n' => 19,
			'c' => 50,
			'g' => 10
		),
		'320' => array(
			'n' => 1,
			'c' => 320,
			'g' => 0
		)
	);

	// 栅格查询
	function grid () {

		$setting = $this->config->item('setting');
		$layout = explode(',', $setting['layout']);
		$rule = $this->rules[$setting['width']];
		$data = array();
		foreach ($layout as $v1) {
			$r = array();
			preg_match_all('/([a-z])([0-9]+)?/i', str_replace('grid-', '', $v1), $match);
			foreach ($match[2] as $v2) {
				if ($v2 === '') {
					$r[] = '100%';
				} elseif (intval($v2) === 0) {
					$r[] = ($rule['n'] - array_sum($match[2])) * $rule['c'] - $rule['g'];
				} else {
					$r[] = $v2 * $rule['c'] - $rule['g'];
				}
			}
			$data[$v1] = $r;
		}
		return $data;

	}

	// 宽度查询
	function width () {

		$grid = $this->grid();
		$grid['grid-m'] = array(0);
		$data = array();
		foreach ($grid as $v) {
			$data = array_unique(array_merge($data, $v));
		};
		asort($data);
		return array_values($data);

	}

}