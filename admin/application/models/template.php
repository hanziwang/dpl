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
		$data_dir = dirname(BASEPATH) . '/data/template/';
		$this->dir->copy($data_dir, $template_dir);
		$this->dir->chmod($template_dir, 0777);
		foreach (array('.css', '.js') as $v) {
			@rename($template_dir . $v, $template_dir . $args['name'] . $v);
		}

		// 配置默认属性
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
			'configid' => $this->config->item('config')
		);

		// 写入属性配置
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

		// 读取属性配置
		$defaults = @file_get_contents($template_dir . 'data.json');
		$defaults = json_decode($defaults);

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
		$attribute = json_decode($args['attribute'], true);
		if (!empty($args['attribute']) && is_array($attribute)) {
			$defaults->attribute = $attribute;
		}

		// 写入属性配置
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

		$www_dir = $this->config->item('www');
		$template_dir = $www_dir . '/' . $args['market'] . '/' . $args['name'] . '/';

		// 读取属性配置
		$defaults = @file_get_contents($template_dir . 'data.json');
		return json_decode($defaults);

	}

	// 拷贝模板 todo
	function copy ($args) {

		$this->load->library('dir');

		// 配置基础路径
		$www_dir = $this->config->item('www');

		// 默认为当前市场
		if (empty($args['cmarket'])) {
			$args['cmarket'] = $args['market'];
		}

		$source_dir = $www_dir . '/' . $args['market'] . '/' . $args['name'] . '/';
		$template_dir = $www_dir . '/' . $args['cmarket'] . '/' . $args['cname'] . '/';

		//如果模板源不存在，直接跳出
		if (!file_exists($source_dir)) {
			return array(
				'code' => 400,
				'message' => '源模板不存在',
				'data' => $source_dir
			);
		}

		//如果模板已经拷贝过，直接跳出
		if (!file_exists($template_dir)) {
			@mkdir($template_dir, 0777);
		} else {
			return array(
				'code' => 400,
				'message' => '模板已经存在',
				'data' => $template_dir
			);
		}

		//遍历修改文件名称
		$source_files = array_diff(scandir($source_dir), array('.', '..', '.svn', '.md5'));

		foreach ($source_files as $v) {
			$filepath = $source_dir . $v;
			if (!is_dir($filepath)) {
				$dst = $template_dir . str_replace($args['name'], $args['cname'], $v);
				@copy($filepath, $dst);
				@chmod($dst, 0777);
			} else {
				$this->dir->copy_dir($filepath, $template_dir . $v);
				$this->dir->chmod_dir($template_dir . $v, 0777);
			}
		}

		//清除模板配置中的tmsId字段、最后修改时间、版本，并修改模板名称
		$cfg = @file_get_contents($template_dir . 'data.json');
		$cfg = json_decode($cfg);
		$cfg->name = $args['cname'];
		$cfg->nickname = $args['nickname'];
		$cfg->marketid = $args['cmarket'];
		$cfg->author = $args['author'];
		$cfg->description = $args['description'];
		$cfg->imgurl = $args['imgurl'];
		$cfg->id = '';
		$cfg->modify_time = '';
		$cfg->version = '';

		if (@file_put_contents($template_dir . 'data.json', json_encode($cfg))) {
			@chmod($template_dir . 'data.json', 0777);
			return array(
				'code' => 200,
				'message' => '模板拷贝成功',
				'data' => $template_dir
			);
		}

	}

	// 上传模板 todo
	function upload ($url, $args) {

		$libs = array('dir', 'zip', 'snoopy');
		$this->load->library($libs);

		$www_dir = $this->config->item('www');
		$tmp_dir = $this->config->item('tmp');
		$config_id = $this->config->item('config');

		// 创建临时目录
		@mkdir($tmp_dir .= date('/Ymd.His'), 0777);

		//配置文件操作目录
		$template_dir = $www_dir . '/' . $args['market'] . '/' . $args['name'];
		$cache_dir = $tmp_dir . '/' . $args['name'];

		//检测模板是否存在
		if (!file_exists($template_dir)) {
			return array(
				'code' => 400,
				'message' => '模板不存在',
				'data' => $template_dir
			);
		}

		//拷贝文件至缓存目录
		if ($this->dir->copy_dir($template_dir, $cache_dir)) {

			$this->dir->chmod_dir($cache_dir, 0777);

			//检测是否有私有模块库，没有则创建之
			if (!file_exists($cache_dir . '/modules')) {
				@mkdir($cache_dir . '/modules', 0777);
			}

			//插入最后修改时间字段
			$cfg = @file_get_contents($cache_dir . '/data.json');
			$cfg = json_decode($cfg);
			$cfg->modify_time = date('Y-m-d H:i:s');
			$cfg->configid = $cfg->configid ? $cfg->configid : $config_id;
			@file_put_contents($cache_dir . '/data.json', json_encode($cfg));
			@chmod($cache_dir . '/data.json', 0777);
		}

		//将模板文件打包到缓存目录（替换是用户修复zip类的路径处理bug）
		$this->zip->read_dir(str_replace("\\", '/', $cache_dir . '/'), false);
		$this->zip->archive($cache_dir . '.zip');

		//模拟上传打包后的压缩文件
		$snoopy = new Snoopy;
		$submit_vars['type'] = 'template';
		$submit_vars['method'] = 'post';
		$submit_vars['alt'] = 'zip';
		$submit_files['ufile'] = $cache_dir . '.zip';
		$snoopy->_submit_type = 'multipart/form-data';
		$snoopy->submit($url, $submit_vars, $submit_files);

		//请求发送成功后执行操作
		if ($snoopy->status == '200') {

			$result = json_decode(mb_convert_encoding($snoopy->results, 'utf-8', 'gbk'));

			//判断上传是否成功
			if ($result->status == '200') {

				//向缓存配置插入tmsId和version字段
				$cfg = @file_get_contents($cache_dir . '/data.json');
				$cfg = json_decode($cfg);
				$cfg->id = $result->tmsId;
				$cfg->version = $result->version;
				@file_put_contents($cache_dir . '/data.json', json_encode($cfg));

				//拷贝配置文件，生成模板md5串，旨在能被系统模块检索到
				@copy($cache_dir . '/data.json', $template_dir . '/data.json');
				@chmod($template_dir . '/data.json', 0777);
				@file_put_contents($template_dir . '/.md5', $this->dir->md5_dir($template_dir));
				@chmod($template_dir . '/.md5', 0777);

				return array(
					'code' => 200,
					'message' => '模板上传成功',
					'data' => $result
				);

			} else {
				return array(
					'code' => 400,
					'message' => '模板上传失败（tms接口错误）',
					'data' => $result
				);
			}

		} else {
			return array(
				'code' => 400,
				'message' => '模板上传失败（HTTP传输错误）'
			);
		}

	}

	// 下载模板 todo
	public function download ($url, $args) {

		$libs = array('dir', 'unzip');
		$this->load->library($libs);

		$www_dir = $this->config->item('www');
		$tmp_dir = $this->config->item('tmp');

		//创建临时缓存目录
		@mkdir($tmp_dir .= date('/Ymd.His'), 0777);
		$tmp_dir = $tmp_dir . '/' . $args['id'];

		$context = stream_context_create(array(
			'http' => array(
				'method' => 'GET',
				'timeout' => 5,
			)
		));

		//远程读取压缩包
		if (!$buffer = @file_get_contents($url, false, $context)) {
			return array(
				'code' => 400,
				'message' => 'tms接口无法访问',
				'data' => $url
			);
		}

		//写入压缩文件到磁盘
		@file_put_contents($tmp_dir . '.zip', $buffer);
		@chmod($tmp_dir . '.zip', 0777);

		//解压模板包并解析模板名称
		$files = $this->unzip->extract($cache_dir . '.zip');
		$template = explode('/', str_replace($cache_src, '', $files[0]));
		$template = $template[1];

		//读取缓存模板版本
		$server_cfg = @file_get_contents($cache_src . '/' . $template . '/data.json');
		$server_cfg = json_decode($server_cfg);
		$server_version = (float)$server_cfg->version;

		//处理本地模板文件
		$template_dir = $src . '/' . $server_cfg->marketid . '/' . $template;

		//读取本地模板版本
		if (file_exists($template_dir)) {
			$client_cfg = @file_get_contents($template_dir . '/data.json');
			$client_cfg = json_decode($client_cfg);
			$client_version = (float)$client_cfg->version;
		} else {
			$client_version = 0;
		}

		//版本过期，强制更新本地模板
		if ($server_version > $client_version) {
			if ($this->dir->copy_dir($cache_src . '/' . $template, $template_dir)) {

				$this->dir->chmod_dir($template_dir, 0777);

				//写入目录的md5序列值
				@file_put_contents($template_dir . '/.md5', $this->dir->md5_dir($template_dir));
				@chmod($template_dir . '/.md5', 0777);

				//删除数据库记录
				$this->db->delete('template', array('id' => $server_cfg->id));
				return array(
					'code' => 200,
					'message' => '模板下载成功',
					'data' => $template_dir
				);
			}
		} //版本一致，跳过更新操作
		elseif ($server_version == $client_version) {
			return array(
				'code' => 400,
				'message' => '本地模板已是最新版本',
				'data' => $template_dir
			);
		} //版本信息错误
		else {
			return array(
				'code' => 400,
				'message' => '模板版本信息错误',
				'data' => $template_dir
			);
		}

	}

}