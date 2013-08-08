<?php

/**
 *  _                 _
 * | |_ _ __ ___  ___| |_ __ _  __ _
 * | __| '_ ` _ \/ __| __/ _` |/ _` |
 * | |_| | | | | \__ \ || (_| | (_| |
 *  \__|_| |_| |_|___/\__\__,_|\__, |
 *                             |___/
 * tms 标签函数集
 * @see http://wiki.tms.taobao.net/syntax:php:start
 */

/* = 打开错误报告
----------------------------------------------- */
error_reporting(E_ALL);

/* = 定义默认数据
----------------------------------------------- */
defined('_TMS_IMAGE') or define('_TMS_IMAGE', 'http://img.f2e.taobao.net/img.png');
defined('_TMS_LINK') or define('_TMS_LINK', 'http://www.taobao.com/');
defined('_TMS_TEXT') or define('_TMS_TEXT', 'string');

/* = 基础函数
----------------------------------------------- */
/**
 * 将 JSON 字符串转换为可读格式
 * @param string $json
 * @return string
 * @private
 */
if (!function_exists('_tms_format')) {

	function _tms_format ($json) {

		$result = '';
		$pos = 0;
		$strLen = strlen($json);
		$indentStr = '	';
		$newLine = "\n";
		$prevChar = '';
		$outOfQuotes = true;

		for ($i = 0; $i <= $strLen; $i++) {
			$char = substr($json, $i, 1);
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = !$outOfQuotes;
			} elseif (($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos--;
				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}
			$result .= $char;
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos++;
				}
				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}
			$prevChar = $char;
		}
		return $result;
	}

}

/**
 * 将 Unicode 转换为中文字符
 * @param string $str
 * @return string
 * @private
 */
if (!function_exists('_tms_replace_callback')) {

	function _tms_replace_callback ($str) {

		$str = strtr($str[0], array('\\u' => ''));
		return iconv('UCS-2', 'UTF-8', pack('H*', $str));

	}

}

/**
 * 导入标签数据文件
 * @param string $filename
 * @return void
 * @private
 */
if (!function_exists('_tms_import')) {

	function _tms_import ($filename) {

		// 清空数据堆栈
		$GLOBALS['_tms_import'] = array();
		$GLOBALS['_tms_export'] = array();

		// 从指定文件导入数据
		if (file_exists($filename)) {
			$data = @file_get_contents($filename);
			$data = json_decode($data, true);
			$GLOBALS['_tms_import'] = is_null($data) ? array() : $data;
		}

	}

}

/**
 * 导出标签数据文件
 * @param string $filename
 * @return void
 * @private
 */
if (!function_exists('_tms_export')) {

	function _tms_export ($filename) {

		// 导出数据到指定文件
		$import = $GLOBALS['_tms_import'];
		$export = $GLOBALS['_tms_export'];
		if (serialize($export) !== serialize($import)) {
			$data = json_encode($export);
			$data = preg_replace_callback('/\\\\u[0-9a-fA-Z]{4}/', array('Json', '_replace_callback'), $data);
			$data = _tms_format($data);
			@file_put_contents($filename, $data);
			@chmod($filename, 0777);
		}

	}

}

/**
 * 校验标签语法格式
 * @param string $code
 * @return void
 * @private
 */
if (!function_exists('_tms_syntax')) {

	function _tms_syntax ($file, &$code) {

		$GLOBALS['_tms_file'] = $file;

		// 补全标签分号
		$_code = $code;
		$rules = array("\"}')", "_end()", ".php')", ".php\")");
		foreach ($rules as $rule) {
			if (strpos($code, $rule) !== false) {
				$code = explode($rule, $code);
				$prev = array_shift($code) . $rule;
				foreach ($code as &$v) {
					$v = strpos($v, ';') !== 0 ? ';' . $v : $v;
				}
				$code = $prev . implode($rule, $code);
			}
		}
		if ($_code !== $code) {
			@file_put_contents($file, $code);
			@chmod($file, 0777);
		}

	}

}

/**
 * 抛出标签错误信息
 * @param string $error_msg
 * @return string
 * @private
 */
if (!function_exists('_tms_error')) {

	function _tms_error ($error_msg) {

		try {
			throw new Exception($error_msg);
		} catch (Exception $e) {
			$trace = $e->getTrace();
			$trace = $trace[3];
			$file = $GLOBALS['_tms_file'];
			$line = $trace['line'];
			$function = $trace['function'];
			$args = $trace['args'][0];
			$message = $e->getMessage();
			include APPPATH . 'errors/error_tms.php';

		}

	}

}

/**
 * 将标签参数解析为数组
 * @param string $args
 * @return array
 * @private
 */
if (!function_exists('_tms_parse_args')) {

	function _tms_parse_args ($args, $keys) {

		$args = json_decode($args, true);

		// 检查参数
		if (is_null($args) || empty($args)) {
			_tms_error('参数为空或格式错误');
		}

		// 检查字段
		foreach ($keys as $v) {
			if (!isset($args[$v])) {
				_tms_error('参数属性 ' . $v . ' 未设置');
			} elseif (in_array($v, array('name', 'row', 'defaultRow')) && empty($args[$v])) {
				_tms_error('参数属性 ' . $v . ' 为空');
			} elseif (strpos($args[$v], '(') !== false || strpos($args[$v], ')') !== false) {
				_tms_error('参数属性 ' . $v . ' 不能包含 "(" 或 ")" 符号');
			}
		}
		return $args;

	}

}

/**
 * 通用标签
 * @param string $args '{"key1":"value1","key2":"value2"}'
 * @param array $attributes
 * @return array
 * @private
 */
if (!function_exists('_tms_common')) {

	function _tms_common ($args = '{}', $attributes) {

		// 校验标签参数
		$keys = array('name', 'title', 'group');
		$args = _tms_parse_args($args, $keys);

		// 追加图片尺寸
		if (preg_match('/\[(\d+x\d+)\]$/', $args['title'], $match)) {
			if (isset($attributes['img'])) {
				$attributes['img'] .= '?x=' . $match[1];
			}
		}

		// 读取参数信息
		$name = $args['name'];
		$row = isset($args['row']) ? intval($args['row']) : 1;
		$row = isset($args['defaultRow']) ? intval($args['defaultRow']) : $row;

		// 填充文件数据
		if (isset($GLOBALS['_tms_import'][$name])) {
			$data = $GLOBALS['_tms_import'][$name];

			// 行数修正
			$count = count($data);
			if ($count > $row) {
				$data = array_slice($data, 0, $row);
			} elseif ($count < $row) {
				for ($i = 0; $i < $row - $count; $i++) {
					$data[] = $attributes;
				}
			}

			// 字段修正
			if (isset($args['fields'])) {
				foreach ($data as &$r) {
					$r1 = $attributes;
					foreach ($attributes as $k => $v) {
						$r1[$k] = isset($r[$k]) ? $r[$k] : $v;
					}
					$r = $r1;
				}
			}
			//unset($GLOBALS['_tms_import'][$name]);
		} else {
			$data = array();
			for ($i = 0; $i < $row; $i++) {
				$data[] = $attributes;
			}
		}
		$GLOBALS['_tms_export'][$name] = $data;
		return $data;

	}

}

/* = 数据标签
----------------------------------------------- */
/**
 * 单行文本标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_text')) {

	function _tms_text ($args) {

		$attributes = array(
			'text' => _TMS_TEXT
		);
		return _tms_common($args, $attributes);

	}

}

/**
 * 多行文本标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_textArea')) {

	function _tms_textArea ($args) {

		$attributes = array(
			'text' => _TMS_TEXT
		);
		return _tms_common($args, $attributes);

	}

}

/**
 * 文字链接标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_textLink')) {

	function _tms_textLink ($args) {

		$attributes = array(
			'text' => _TMS_TEXT,
			'href' => _TMS_LINK
		);
		return _tms_common($args, $attributes);

	}

}

/**
 * 图片标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_image')) {

	function _tms_image ($args) {

		$attributes = array(
			'text' => _TMS_TEXT,
			'img' => _TMS_IMAGE
		);
		return _tms_common($args, $attributes);

	}

}

/**
 * 图片链接标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_imageLink')) {

	function _tms_imageLink ($args) {

		$attributes = array(
			'text' => _TMS_TEXT,
			'img' => _TMS_IMAGE,
			'href' => _TMS_LINK
		);
		return _tms_common($args, $attributes);

	}

}

/**
 * 自定义标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_custom')) {

	function _tms_custom ($args) {

		// 校验标签参数
		$keys = array('fields');
		$_args = _tms_parse_args($args, $keys);

		// 解析自定义字段
		$fields = explode(',', $_args['fields']);
		$attributes = array();
		$sizes = array();
		foreach ($fields as $v) {
			$field = explode(':', $v);
			$attributes[$field[0]] = $field[2];
			if (preg_match('/\[(\d+x\d+)\]\:img$/', $v, $match)) {
				$sizes[$field[0]] = $match[1];
			}
		}

		// 根据字段类型取值
		foreach ($attributes as $k => &$v) {
			switch ($v) {
				case 'string':
				case 'multilString':
				case 'html':
					$v = _TMS_TEXT;
					break;
				case 'href':
					$v = _TMS_LINK;
					break;
				case 'img':
					$v = _TMS_IMAGE . (isset($sizes[$k]) ? '?x=' . $sizes[$k] : '');
					break;
				case 'boolean':
					$v = 'true';
					break;
				case 'date':
					$v = date('YmdHis');
					break;
				case 'email':
					$v = 'youmame@example.com';
					break;
				default:
					$v = _TMS_TEXT;
			}
		}
		return _tms_common($args, $attributes);

	}

}

/**
 * 区块引用标签
 * @param string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_subArea')) {

	function _tms_subArea ($args) {

		$args = str_replace('/home/admin/go', '', $args);
		$args = 'http://www.taobao.com/go' . $args;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $args);
		$data = curl_exec($ch);
		curl_close($ch);
		$data = @iconv('GBK', 'UTF-8//IGNORE', $data);
		return eval(' ?>' . $data . '<?php ');

	}

}

/**
 * 资讯全自动抽取标签
 * @param string $args
 * @return array
 */
if (!function_exists('_tms_articleList')) {

	function _tms_articleList ($args) {

		$attributes = array(
			// 资讯编号
			'id' => '',
			// 标题1
			'title1' => _TMS_TEXT,
			// 标题2
			'title2' => _TMS_TEXT,
			// 标题3
			'title3' => _TMS_TEXT,
			// 作者序列号
			'authorId' => '',
			// 作者名
			'author' => '',
			// 作者链接
			'authorUrl' => _TMS_LINK,
			// 类目序列号
			'articleCatalogId' => '',
			// 类型
			'articleType' => '',
			// 标签
			'tag' => '',
			// 带链接的标签
			'tagLink' => '',
			// 权重
			'priority' => '',
			// 来源
			'source' => '',
			// 来源链接
			'sourceUrl' => _TMS_LINK,
			// 导语、摘要
			'articleAbstract' => '',
			// 正文
			'articleBody' => '',
			// 图1 1:1
			'image1' => _TMS_IMAGE,
			// 图2 250x165
			'image2' => _TMS_IMAGE . '?x=250x165',
			// 图3 190×150
			'image3' => _TMS_IMAGE . '?x=190x150',
			// 图4 110x90
			'image4' => _TMS_IMAGE . '?x=110x90',
			// 图5 110x70
			'image5' => _TMS_IMAGE . '?x=110×70',
			// 图6 165×120
			'image6' => _TMS_IMAGE . '?x=165×120',
			// 图7 260*230
			'image7' => _TMS_IMAGE . '?x=260*230',
			// 图8 115x155
			'image8' => _TMS_IMAGE . '?x=115x155',
			// 图9 165x150
			'image9' => _TMS_IMAGE . '?x=165x150',
			// 关联模板序列号
			'templateId' => '',
			// 链接
			'url' => _TMS_LINK,
			// 位置标签
			'positionTag' => '',
			// 文章正文存储路径
			'articlePath' => '',
			// 发布链接
			'publishedUrl' => _TMS_LINK,
			// 发布日期
			'publishDate' => ''
		);
		return _tms_common($args, $attributes);

	}

}

/**
 * 全自动抽取输入和输出标签
 * @params string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_autoExtract')) {

	function _tms_autoExtract ($args) {

		// 本地全自动抽取标签是自定义标签的映射
		return _tms_custom($args);

	}

}

/**
 * 动态标签
 * @params string $args 标签参数
 * @return array
 */
if (!function_exists('_tms_dynamic')) {

	function _tms_dynamic ($args) {

		// 默认字段
		$defaults = array(
			// 请求地址
			'dataUrl' => '',
			// 字段解析路径
			'dataPath' => '',
			// 业务类型
			'dataType' => 'static',
			// 参数列表
			'dataPara' => '',
			// 字段映射
			'dataMap' => '',
			// 是否请求服务器（1 代表 true，0 代表 false）
			'dataServer' => '',
			// 取 cookie 字段值
			'dataCookie' => '',
			// 容灾数据
			'dataStatic' => ''
		);

		$data['dynamic'] = $defaults;
		$data['custom'] = _tms_custom($args);
		$data['stringify'] = json_encode($data);
		return $data;

	}

}

/* = 容器标签
----------------------------------------------- */

/**
 * 模块标签
 * @param string $args 标签参数
 * @return void
 */
if (!function_exists('_tms_module_begin')) {

	function _tms_module_begin ($args = '{}') {

		$keys = array('name');
		_tms_parse_args($args, $keys);

		// 线上模块标签会输出 spm 埋点容器
		echo '<div class="module">' . "\r\n";

	}

}

if (!function_exists('_tms_module_end')) {

	function _tms_module_end () {

		echo '</div>' . "\r\n";

	}

}

/**
 * 重复标签
 * 注：使用缓冲区解决片段重复的问题，不支持标签嵌套
 * @param string $args 标签参数
 * @return void
 */
if (!function_exists('_tms_repeat_begin')) {

	function _tms_repeat_begin ($args = '{}') {

		$keys = array('name', 'title', 'group', 'row');
		$args = _tms_parse_args($args, $keys);

		// 读取参数信息
		$name = $args['name'];
		$row = intval($args['row']);
		$attributes = array(
			'text' => 'true'
		);

		// 填充标签数据
		if (isset($GLOBALS['_tms_import'][$name])) {
			$data = $GLOBALS['_tms_import'][$name];

			// 行数修正
			$count = count($data);
			if ($count > $row) {
				$data = array_slice($data, 0, $row);
			} elseif ($count < $row) {
				for ($i = 0; $i < $row - $count; $i++) {
					$data[] = $attributes;
				}
			}
			//unset($GLOBALS['_tms_import'][$name]);
		} else {
			$data = array();
			for ($i = 1; $i <= $row; $i++) {
				$data[] = $attributes;
			}
		}
		$GLOBALS['_tms_repeat_row'] = $row;
		$GLOBALS['_tms_export'][$name] = $data;
		ob_start();

	}

}

if (!function_exists('_tms_repeat_end')) {

	function _tms_repeat_end () {

		$row = $GLOBALS['_tms_repeat_row'];
		$buffer = ob_get_contents();
		for ($i = 1; $i < $row; $i++) {
			echo $buffer;
		}
		//unset($GLOBALS['_tms_repeat_row']);
		ob_end_flush();

	}

}