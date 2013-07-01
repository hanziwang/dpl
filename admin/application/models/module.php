<?php

/**
 * 模块模型
 */
class Module extends CI_Model {

	// 获取模块路径
	function base_dir ($args) {

		// 处理私有模块和公共模块的路径差异
		if (!empty($args['market']) && !empty($args['template'])) {
			$www_dir = $this->config->item('www');
			return $www_dir . '/' . $args['market'] . '/' . $args['template'] . '/modules/' . $args['name'] . '/';
		} else {
			$modules_dir = $this->config->item('modules');
			return $modules_dir . '/' . $args['name'] . '/';
		}

	}

	// 新建模块
	function create ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$modules_dir = $this->config->item('modules');
		$module_dir = $this->base_dir($args);
		$config_id = $this->config->item('id', 'config');

		// 创建模块根目录
		if (!file_exists($modules_dir)) {
			@mkdir($modules_dir, 0777);
		}

		// 创建模块目录
		if (file_exists($module_dir)) {
			return array(
				'code' => 400,
				'message' => '模块已经存在'
			);
		} else {
			@mkdir($module_dir, 0777);
		}

		// 拷贝并重命名文件
		$config_module = $this->config->item('module', 'config');
		$data_dir = dirname(BASEPATH) . '/data/module/' . $config_module . '/';
		$this->dir->copy($data_dir, $module_dir);
		$this->dir->chmod($module_dir, 0777);
		foreach (array('.css', '.js', '.php', '.less') as $v) {
			@rename($module_dir . $v, $module_dir . $args['name'] . $v);
		}

		// 默认配置信息
		$defaults = array(
			'name' => $args['name'],
			'nickname' => $args['nickname'],
			'width' => $args['width'],
			'author' => $args['author'],
			'category' => $args['category'],
			'description' => $args['description'],
			'imgurl' => $args['imgurl'],
			'id' => '',
			'modify_time' => '',
			'version' => '',
			'configid' => strval($config_id)
		);

		// 替换模块占位符
		$module_files = array(
			$args['name'] . '.css',
			$args['name'] . '.less',
			$args['name'] . '.js',
			$args['name'] . '.php',
			'skin/default.less'
		);
		foreach ($module_files as $v) {
			$data = @file_get_contents($module_dir . $v);
			$data = str_replace('{{module}}', $args['name'], $data);
			@file_put_contents($module_dir . $v, $data);
		}

		// 写入配置信息
		$file = $module_dir . 'data.json';
		if (@file_put_contents($file, $this->json->encode($defaults))) {
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => '模块新建成功',
				'data' => $module_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模块新建失败',
				'data' => $module_dir
			);
		}

	}

	// 修改模块
	function update ($args) {

		$this->load->library('json');

		// 配置基础路径
		$module_dir = $this->base_dir($args);

		// 排除模块不存在的情况
		if (!file_exists($module_dir)) {
			return array(
				'code' => 400,
				'message' => '模块不存在',
				'data' => $module_dir
			);
		}

		// 读取配置信息
		$defaults = @file_get_contents($module_dir . 'data.json');
		$defaults = $this->json->decode($defaults);

		// 写入昵称参数
		if (!empty($args['nickname'])) {
			$defaults->nickname = $args['nickname'];
		}

		// 写入宽度参数
		if (!empty($args['width'])) {
			$defaults->width = $args['width'];
		}

		// 写入作者参数
		if (!empty($args['author'])) {
			$defaults->author = $args['author'];
		}

		// 写入描述参数
		if (!empty($args['description'])) {
			$defaults->description = $args['description'];
		}

		// 写入缩略图参数
		if (!empty($args['imgurl'])) {
			$defaults->imgurl = $args['imgurl'];
		}

		// 写入配置信息
		$defaults = $this->json->encode($defaults);
		$file = $module_dir . 'data.json';
		if (@file_put_contents($file, $defaults)) {
			@chmod($file, 0777);
			return array(
				'code' => 200,
				'message' => '模块修改成功',
				'data' => $module_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模块修改失败',
				'data' => $module_dir
			);
		}

	}

	// 查询模块
	function select ($args) {

		$this->load->library('json');

		// 配置基础路径
		$module_dir = $this->base_dir($args);

		// 读取配置信息
		$defaults = @file_get_contents($module_dir . 'data.json');
		return $this->json->decode($defaults);

	}

	// 拷贝模块
	function copy ($args) {

		$this->load->library(array('dir', 'json'));

		// 配置基础路径
		$module_dir = $this->base_dir($args);
		$path_dir = $this->config->item('src') . '/' . $args['path'] . '/';

		// 创建模块目录
		if (!file_exists($module_dir)) {
			@mkdir($module_dir, 0777);
		} else {
			return array(
				'code' => 400,
				'message' => '模块已经存在',
				'data' => $module_dir
			);
		}

		// 拷贝模块文件
		$handle = opendir($path_dir);
		$search = substr($args['path'], strpos($args['path'], '/') + 1);
		while ($file = readdir($handle)) {
			if ($file !== '.' && $file !== '..') {
				$file1 = $path_dir . $file;
				$file2 = $module_dir . str_replace($search, $args['name'], $file);
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

		// 清除 tmsId 字段、最后修改时间、版本
		$data = @file_get_contents($module_dir . 'data.json');
		$data = $this->json->decode($data);
		$data->name = $args['name'];
		$data->nickname = $args['nickname'];
		$data->width = $args['width'];
		$data->author = $args['author'];
		$data->category = $args['category'];
		$data->description = $args['description'];
		$data->imgurl = $args['imgurl'];
		$data->id = '';
		$data->modify_time = '';
		$data->version = '';

		// 写入配置信息
		$file = $module_dir . 'data.json';
		@file_put_contents($file, $this->json->encode($data));
		@chmod($file, 0777);
		return array(
			'code' => 200,
			'message' => '模块拷贝成功',
			'data' => $module_dir
		);

	}

	// 上传模块
	function upload ($url, $args) {

		$this->load->library(array('dir', 'json', 'zip', 'snoopy'));

		// 配置基础路径
		$module_dir = $this->base_dir($args);
		$db_dir = $this->config->item('db');
		$config_id = $this->config->item('id', 'setting');

		// 配置操作目录
		$cache_dir = $db_dir . '/' . md5(time()) . '/';
		@mkdir($cache_dir, 0777);

		// 拷贝到缓存目录
		$cache_dir .= $args['name'] . '/';
		$this->dir->copy($module_dir, $cache_dir);
		$this->dir->chmod($cache_dir, 0777);

		// 写入环境参数
		$file = $cache_dir . 'data.json';
		$data = $this->json->decode(@file_get_contents($file));
		$data->modify_time = date('Y-m-d H:i:s');
		$data->configid = $config_id;
		@file_put_contents($file, $this->json->encode($data));

		// 打包到缓存目录
		$ufile = dirname($file) . '.zip';
		$this->zip->read_dir($cache_dir, false);
		$this->zip->archive($ufile);

		// 上传压缩包
		$submit_vars['type'] = 'module';
		$submit_vars['method'] = 'post';
		$submit_vars['alt'] = 'zip';
		$submit_files['ufile'] = $ufile;
		$this->snoopy->_submit_type = 'multipart/form-data';
		$this->snoopy->submit($url, $submit_vars, $submit_files);

		// 网络传输错误
		if ($this->snoopy->status !== '200') {
			return array(
				'code' => 400,
				'message' => '模块上传失败（网络传输错误）'
			);
		}

		// 服务器接口错误
		$result = $this->snoopy->results;
		$result = $this->json->decode($result);
		if ($result->status !== '200') {
			return array(
				'code' => 400,
				'message' => '模块上传失败（服务器接口错误）',
				'data' => $result
			);
		}

		// 插入 tmsId 和 version 字段
		$data = $this->json->decode(@file_get_contents($file));
		$data->id = $result->tmsId;
		$data->version = $result->version;
		@file_put_contents($file, $this->json->encode($data));
		@copy($file, $module_dir . 'data.json');

		// 生成 md5 标记文件
		$md5 = $module_dir . '.md5';
		@file_put_contents($md5, $this->dir->md5($module_dir));
		@chmod($md5, 0777);
		return array(
			'code' => 200,
			'message' => '模块上传成功',
			'data' => $result
		);

	}

	// 下载模块
	public function download ($url, $args) {

		$this->load->library(array('dir', 'unzip'));

		// 配置基础路径
		$modules_dir = $this->config->item('modules');
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

		// 解析模块名称
		$ufiles = $this->unzip->extract($ufile);
		$ufiles[0] = str_replace($cache_dir, '', $ufiles[0]);
		$module_name = substr($ufiles[0], 0, strpos($ufiles[0], '/'));
		$cache_dir .= $module_name . '/';

		// 读取缓存信息
		$cache_data = @file_get_contents($cache_dir . 'data.json');
		$cache_data = $this->json->decode($cache_data);
		$cache_version = intval($cache_data->version);

		// 创建模块根目录
		if (!file_exists($modules_dir)) {
			@mkdir($modules_dir, 0777);
		}

		// 读取配置信息
		$module_dir = $modules_dir . '/' . $module_name . '/';
		if (file_exists($module_dir)) {
			$data = @file_get_contents($module_dir . 'data.json');
			$data = $this->json->decode($data);
			$version = intval($data->version);
		} else {
			@mkdir($module_dir, 0777);
			$version = 0;
		}

		// 版本一致无需更新
		if ($cache_version === $version) {
			return array(
				'code' => 400,
				'message' => '本地模块已是最新版本',
				'data' => $module_dir
			);
		}

		// 版本不一致需要更新
		if ($cache_version > $version) {
			$this->dir->copy($cache_dir, $module_dir);
			$this->dir->chmod($module_dir, 0777);
			$md5 = $module_dir . '.md5';
			@file_put_contents($md5, $this->dir->md5($module_dir));
			@chmod($md5, 0777);
			return array(
				'code' => 200,
				'message' => '模块下载成功',
				'data' => $module_dir
			);
		} else {
			return array(
				'code' => 400,
				'message' => '模块版本错误',
				'data' => $module_dir
			);
		}

	}

}