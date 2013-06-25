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
		$market_dir = $www_dir . '/' . $args['id'] . '/';

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
		$parts = array(
			'__header.php' => 'market/' . $args['id'] . '/',
			'__nav.php' => 'rgn/nav/' . $args['id'],
			'__footer.php' => 'market/' . $args['id'] . '/'
		);
		foreach ($parts as $k => $v) {
			$buffer = @file_get_contents($base_url . $v . $k);
			$file = $market_dir . $k;
			@file_put_contents($file, $buffer);
			@chmod($file, 0777);
		}
		return array(
			'code' => 200,
			'message' => '市场新建成功',
			'data' => $market_dir
		);

	}

}