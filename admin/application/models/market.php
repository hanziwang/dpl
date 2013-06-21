<?php

/**
 * 市场模型
 */
class Market extends CI_Model {

	// 创建市场
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

		// 写入页面组件
		http://www.taobao.com/go/market/5341/__header.php

	}

}