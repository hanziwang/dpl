<?php

/**
 * 栅格模型
 */
class Grid extends CI_Model {

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

	// 查询栅格
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

	// 查询宽度
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

	// 查询布局模板
	function template ($grid) {

		// 定义布局模板
		$layouts = array(
			'<div class="layout {grid} J_Layout">
	<div class="col-main">
		<div class="main-wrap J_Region">{module}</div>
	</div>
</div>',
			'<div class="layout {grid} J_Layout">
	<div class="col-main">
		<div class="main-wrap J_Region">{module}</div>
	</div>
	<div class="col-sub J_Region">{module}</div>
</div>',
			'<div class="layout {grid} J_Layout">
	<div class="col-main">
		<div class="main-wrap J_Region">{module}</div>
	</div>
	<div class="col-sub J_Region">{module}</div>
	<div class="col-extra J_Region">{module}</div>
</div>'
		);

		// 读取布局模板
		if (in_array($grid, array('grid-m', 'grid-m0'))) {
			$data = $layouts[0];
		} elseif (preg_match('/^grid-([a-z][0-9]+){2}$/', $grid)) {
			$data = $layouts[1];
		} elseif (preg_match('/^grid-([a-z][0-9]+){3}$/', $grid)) {
			$data = $layouts[2];
		} else {
			$data = '';
		}
		return str_replace('{grid}', $grid, $data);

	}

}