<?php

/**
 * 市场模型
 */
class Market extends CI_Model {

	// 新建市场
	function create ($args) {

		$this->load->library('dir');

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$market_dir = $www_dir . '/' . $args['market'] . '/';

		// 创建市场根目录
		if (!file_exists($www_dir)) {
			@mkdir($www_dir, 0777);
		}

		// 创建市场目录
		if (!file_exists($market_dir)) {
			@mkdir($market_dir, 0777);
		}

		// 写入页头、导航、页尾文件
		$base_url = 'http://www.taobao.com/go/';
		$market_files = array(
			'__nav.php' => 'rgn/nav/' . $args['name'],
			'__header.php' => 'market/' . $args['name'] . '/',
			'__footer.php' => 'market/' . $args['name'] . '/'
		);
		foreach ($market_files as $k => $v) {
			$buffer = @file_get_contents($base_url . $v);
			if ($k === 'nav') {
				$nav = $buffer;
			}
			if ($k === 'header' && strpos($buffer, $nav)) {
				$buffer = str_replace($nav, '', $buffer);
			}
			@file_put_contents($market_dir . '__' . $k . '.php', $buffer);
		}
		return array(
			'code' => 200,
			'message' => '市场新建成功',
			'data' => $market_dir
		);

	}

}