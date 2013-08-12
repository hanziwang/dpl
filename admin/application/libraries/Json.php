<?php

/**
 * JSON 数据操作类
 */
class Json {

	// 将 Unicode 转换为中文字符
	function _replace_callback ($str) {

		$str = strtr($str[0], array('\\u' => ''));
		return iconv('UCS-2', 'UTF-8', pack('H*', $str));

	}

	// 将数组转换为 Json 字符串
	function encode ($value) {

		//return preg_replace('#\\\u([0-9a-fA-F]{4})#ie', "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", json_encode($value));
		return preg_replace_callback('/\\\\u[0-9a-fA-Z]{4}/', array('Json', '_replace_callback'), json_encode($value));

	}

	// 将 Json 字符串转换为数组
	function decode ($json, $assoc = false) {

		return json_decode($json, $assoc);

	}

	// 格式化 Json 字符串
	function format ($json) {

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