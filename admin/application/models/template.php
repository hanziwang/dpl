<?php

/**
 * 模板模型
 */
class Template extends CI_Model {

	// 新建模板
	function create ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$market_dir = $www_dir . '/' . $args['market'] . '/';
		$template_dir = $market_dir . $args['name'] . '/';
		$config_id = $this->config->item('id', 'setting');

		// 创建市场根目录
		if (!file_exists($www_dir)) {
			@mkdir($www_dir, 0777);
		}

		// 创建市场目录
		if (!file_exists($market_dir)) {
			@mkdir($market_dir, 0777);
		}

		// 创建模板目录
		if (file_exists($template_dir)) {
			return array(
				'code' => 400,
				'message' => '模板已经存在'
			);
		} else {
			@mkdir($template_dir, 0777);
		}

		// 拷贝并重命名文件
		@mkdir($template_dir . 'modules', 0777);
		$data_dir = dirname(BASEPATH) . '/data/template/';
		$this->dir->copy($data_dir, $template_dir);
		$this->dir->chmod($template_dir, 0777);
		foreach (array('.css', '.js') as $v) {
			@rename($template_dir . $v, $template_dir . $args['name'] . $v);
		}

		// 默认配置信息
		$defaults = array(
			'name' => $args['name'],
			'nickname' => $args['nickname'],
			'marketid' => $args['market'],
			'description' => $args['description'],
			'author' => $args['author'],
			'imgurl' => $args['imgurl'],
			'id' => '',
			'modify_time' => '',
			'version' => '',
			'configid' => strval($config_id),
			'tag' => $args['tag'],
		);

		// 写入默认配置信息
		$defaults = $this->json->encode($defaults);
		$file = $template_dir . 'data.json';
		if (@file_put_contents($file, $defaults)) {
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => '模板新建成功',
				'data' => $template_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模板新建失败',
				'data' => $template_dir
			);
		}

	}

	// 修改模板
	function update ($args) {

		$this->load->library('json');

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$template_dir = $www_dir . '/' . $args['market'] . '/' . $args['name'] . '/';

		// 排除模板不存在的情况
		if (!file_exists($template_dir)) {
			return array(
				'code' => 400,
				'message' => '模板不存在',
				'data' => $template_dir
			);
		}

		// 读取配置信息
		$defaults = @file_get_contents($template_dir . 'data.json');
		$defaults = $this->json->decode($defaults);

		// 写入昵称参数
		if (!empty($args['nickname'])) {
			$defaults->nickname = $args['nickname'];
		}

		// 写入描述参数
		if (!empty($args['description'])) {
			$defaults->description = $args['description'];
		}

		// 写入作者参数
		if (!empty($args['author'])) {
			$defaults->author = $args['author'];
		}

		// 写入缩略图参数
		if (!empty($args['imgurl'])) {
			$defaults->imgurl = $args['imgurl'];
		}

		// 写入布局参数
		if (!empty($args['attribute'])) {
			$attribute = $this->json->decode($args['attribute'], true);
			$defaults->attribute = $attribute;
		}

		// 写入标签参数
		if (!empty($args['tag'])) {
			$defaults->tag = $args['tag'];
		}

		// 写入配置信息
		$defaults = $this->json->encode($defaults);
		$file = $template_dir . 'data.json';
		if (@file_put_contents($file, $defaults)) {
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => '模板修改成功',
				'data' => $template_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模板修改失败',
				'data' => $template_dir
			);
		}

	}

	// 查询模板
	function select ($args) {

		$this->load->library('json');

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$template_dir = $www_dir . '/' . $args['market'] . '/' . $args['name'] . '/';

		// 读取配置信息
		$defaults = @file_get_contents($template_dir . 'data.json');
		return $this->json->decode($defaults);

	}

	// 拷贝模板
	function copy ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$market_dir = $www_dir . '/' . $args['market'] . '/';
		$path_dir = $www_dir . '/' . $args['path'] . '/';
		$template_dir = $market_dir . $args['name'] . '/';

		// 创建市场根目录
		if (!file_exists($www_dir)) {
			@mkdir($www_dir, 0777);
		}

		// 创建市场目录
		if (!file_exists($market_dir)) {
			@mkdir($market_dir, 0777);
		}

		// 模板已经存在
		if (!file_exists($template_dir)) {
			@mkdir($template_dir, 0777);
		} else {
			return array(
				'code' => 400,
				'message' => '模板已经存在',
				'data' => $template_dir
			);
		}

		// 拷贝模板文件
		$handle = opendir($path_dir);
		$search = substr($args['path'], strpos($args['path'], '/') + 1);
		while ($file = readdir($handle)) {
			if ($file !== '.' && $file !== '..') {
				$file1 = $path_dir . $file;
				$file2 = $template_dir . str_replace($search, $args['name'], $file);
				if (!is_dir($file1)) {
					@copy($file1, $file2);
					@chmod($file2, 0777);
					$data = @file_get_contents($file2);
					$data = str_replace($search, $args['name'], $data);
					@file_put_contents($file2, $data);
				} else {
					$this->dir->copy($file1, $file2);
					$this->dir->chmod($file2, 0777);
				}
			}
		}
		closedir($handle);

		// 写入配置信息
		$data = @file_get_contents($template_dir . 'data.json');
		$data = $this->json->decode($data);
		$data->name = $args['name'];
		$data->nickname = $args['nickname'];
		$data->marketid = $args['market'];
		$data->author = $args['author'];
		$data->description = $args['description'];
		$data->imgurl = $args['imgurl'];

		// 设置标签参数
		if (!empty($args['tag'])) {
			$data->tag = $args['tag'];
		}

		// 清除 tmsId 字段、最后修改时间、版本
		$data->id = '';
		$data->modify_time = '';
		$data->version = '';

		// 写入配置信息
		$file = $template_dir . 'data.json';
		@file_put_contents($file, $this->json->encode($data));
		@chmod($file, 0777);
		return array(
			'code' => 200,
			'message' => '模板拷贝成功',
			'data' => $template_dir
		);

	}

	// 上传模板
	function upload ($url, $args) {

		$this->load->library(array('dir', 'json', 'lessc', 'zip', 'snoopy'));

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$db_dir = $this->config->item('db');
		$config_id = $this->config->item('id', 'setting');

		// 配置操作目录
		$template_dir = $www_dir . '/' . $args['market'] . '/' . $args['name'] . '/';
		$cache_dir = $db_dir . '/' . md5(time()) . '/';
		@mkdir($cache_dir, 0777);

		// 编译 Less 模板
		$file1 = glob($template_dir . '*.less');
		$file2 = glob($template_dir . 'modules/*/*.less');
		$files = array_merge($file1, $file2);
		foreach ($files as $v) {
			$file = substr($v, 0, -5) . '.css';
			$data = @file_get_contents($v);
			@file_put_contents($file, $this->lessc->parse($data));
			@chmod($file, 0777);
		}

		// 拷贝到缓存目录
		$cache_dir .= $args['name'] . '/';
		$this->dir->copy($template_dir, $cache_dir);
		$this->dir->chmod($cache_dir, 0777);

		// 写入环境参数
		$file = $cache_dir . 'data.json';
		$data = $this->json->decode(@file_get_contents($file));
		$data->modify_time = date('Y-m-d H:i:s');
		$data->configid = strval($config_id);
		@file_put_contents($file, $this->json->encode($data));

		// 打包到缓存目录
		$ufile = dirname($file) . '.zip';
		$this->zip->read_dir($cache_dir, false);
		$this->zip->archive($ufile);

		// 上传压缩包
		$submit_vars['type'] = 'template';
		$submit_vars['method'] = 'post';
		$submit_vars['alt'] = 'zip';
		$submit_files['ufile'] = $ufile;
		$this->snoopy->_submit_type = 'multipart/form-data';
		$this->snoopy->submit($url, $submit_vars, $submit_files);

		// 网络传输错误
		if ($this->snoopy->status !== '200') {
			return array(
				'code' => 400,
				'message' => '模板上传失败（网络传输错误）'
			);
		}

		// 服务器接口错误
		$result = $this->snoopy->results;
		$result = @iconv('GBK', 'UTF-8//IGNORE', $result);
		$result = $this->json->decode($result);
		if ($result->status !== '200') {
			return array(
				'code' => 400,
				'message' => '模板上传失败（服务器接口错误）',
				'data' => $result
			);
		}

		// 插入 tmsId 和 version 字段
		$data = $this->json->decode(@file_get_contents($file));
		$data->id = $result->tmsId;
		$data->version = $result->version;
		@file_put_contents($file, $this->json->encode($data));
		@copy($file, $template_dir . 'data.json');

		// 生成 md5 标记文件
		$md5 = $template_dir . '.md5';
		@file_put_contents($md5, $this->dir->md5($template_dir));
		@chmod($md5, 0777);
		return array(
			'code' => 200,
			'message' => '模板上传成功',
			'data' => $result
		);

	}

	// 下载模板
	function download ($url, $args) {

		$this->load->library(array('dir', 'unzip'));

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$db_dir = $this->config->item('db');

		// 读取远程文件
		if (!$buffer = @file_get_contents($url)) {
			return array(
				'code' => 400,
				'message' => '服务器无法访问',
				'data' => $url
			);
		}

		// 写入缓存目录
		$cache_dir = $db_dir . '/' . md5(time()) . '/';
		@mkdir($cache_dir, 0777);
		$ufile = $cache_dir . $args['id'] . '.zip';
		@file_put_contents($ufile, $buffer);
		@chmod($ufile, 0777);

		// 解析模板名称
		$ufiles = $this->unzip->extract($ufile);
		$ufiles[0] = str_replace($cache_dir, '', $ufiles[0]);
		$template_name = substr($ufiles[0], 0, strpos($ufiles[0], '/'));
		$cache_dir .= $template_name . '/';

		// 读取缓存信息
		$cache_data = @file_get_contents($cache_dir . 'data.json');
		$cache_data = $this->json->decode($cache_data);
		$cache_version = intval($cache_data->version);

		// 创建市场根目录
		if (!file_exists($www_dir)) {
			@mkdir($www_dir, 0777);
		}

		// 创建市场目录
		$market_dir = $www_dir . '/' . $cache_data->marketid . '/';
		if (!file_exists($market_dir)) {
			@mkdir($market_dir, 0777);
		}

		// 读取配置信息
		$template_dir = $market_dir . $template_name . '/';
		if (file_exists($template_dir)) {
			$data = @file_get_contents($template_dir . 'data.json');
			$data = $this->json->decode($data);
			$version = intval($data->version);
		} else {
			@mkdir($template_dir, 0777);
			$version = 0;
		}

		// 版本一致无需更新
		if ($cache_version === $version) {
			return array(
				'code' => 400,
				'message' => '本地模板已是最新版本',
				'data' => $template_dir
			);
		}

		// 版本不一致需要更新
		if ($cache_version > $version) {
			$this->dir->copy($cache_dir, $template_dir);
			$this->dir->chmod($template_dir, 0777);
			$md5 = $template_dir . '.md5';
			@file_put_contents($md5, $this->dir->md5($template_dir));
			@chmod($md5, 0777);
			return array(
				'code' => 200,
				'message' => '模板下载成功',
				'data' => $template_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模板版本错误',
				'data' => $template_dir
			);
		}

	}

	// 读取模板文件
	function read ($args) {

		$this->load->library('lessc');

		// 配置基础路径
		$www_dir = $this->config->item('www');
		$market_dir = $www_dir . '/' . $args['market'] . '/';
		$template_dir = $market_dir . '/' . $args['name'] . '/';

		// 读取样式、脚本
		$data = array();
		$prefix = $template_dir . $args['name'];
		$file = $prefix . '.less';
		if (file_exists($file)) {
			$this->lessc->importDir = dirname($file);
			$data['css'] = trim(@file_get_contents($file));
			$data['css'] = $this->lessc->parse($data['css']);
		} else {
			$file = $prefix . '.css';
			$data['css'] = trim(@file_get_contents($file));
		}
		$file = $prefix . '.js';
		$data['js'] = trim(@file_get_contents($file));
		return $data;

	}

}