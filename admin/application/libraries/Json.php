<?php

/**
 * JSON 数据操作类
 */
class Json {

	// 格式化字符串
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
			} elseif ($char == ':') {
				$char .= ' ';
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

	// 编码变量
	function encode ($value) {

		$value = json_encode($value);
		$replace = "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))";
		return preg_replace('#\\\u([0-9a-fA-F]{4})#ie', $replace, $value);

	}

	// 编码字符串
	function decode ($json, $assoc = false) {

		$encoding = array('ASCII', 'GB2312', 'GBK', 'UTF-8');
		$json = @mb_convert_encoding($json, 'UTF-8', $encoding);
		return json_decode($json, $assoc);

	}

}