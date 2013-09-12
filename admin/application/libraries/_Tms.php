<?php

/**
_                         _
| |                       | |
| |_ _ __ ___  ___   _ __ | |__  _ __
| __| '_ ` _ \/ __| | '_ \| '_ \| '_ \
| |_| | | | | \__ \_| |_) | | | | |_) |
\__|_| |_| |_|___(_) .__/|_| |_| .__/
| |         | |
|_|         |_|
 * @see http://wiki.tms.taobao.net/dpl:tms.php
 */
class _tms {

	// 版本定义
	static $version = '20130912';

	// 变量按要求转换编码
	static function iconv ($in_charset, $out_charset, $var) {

		switch (gettype($var)) {
			case 'string':
				return @iconv($in_charset, $out_charset, $var);
			case 'object':
				$_var = new stdClass();
				foreach ($var as $k => $v) {
					$k = self::iconv($in_charset, $out_charset, $k);
					$_var->$k = self::iconv($in_charset, $out_charset, $v);
				}
				return $_var;
			case 'array':
				$_var = array();
				foreach ($var as $k => $v) {
					$k = self::iconv($in_charset, $out_charset, $k);
					$_var[$k] = self::iconv($in_charset, $out_charset, $v);
				}
				return $_var;
			default:
				return $var;
		}

	}

	// 对变量进行 JSON 格式编码
	static function json_encode ($value) {

		if ($value != self::iconv('UTF-8', 'UTF-8//IGNORE', $value)) {
			$value = self::iconv('GBK', 'UTF-8//IGNORE', $value);
			if (is_object($value)) {
				$value = get_object_vars($value);
			}
			if (is_array($value)) {
				return self::iconv('UTF-8', 'GBK//IGNORE', json_encode($value));
			} else {
				return $value;
			}
		} else {
			return json_encode($value);
		}

	}

	// 对 JSON 格式字符串进行编码
	static function json_decode ($json, $assoc = false) {

		if ($json === @iconv('UTF-8', 'UTF-8//IGNORE', $json)) {
			return json_decode($json, $assoc);
		} else {
			return self::iconv('UTF-8', 'GBK//IGNORE', json_decode(@iconv('GBK', 'UTF-8//IGNORE', $json), $assoc));
		}

	}

	// 输出 JSONP 格式的数据
	static function jsonp ($value, $callback = 'callback') {

		if (isset($_GET[$callback])) {
			$callback = htmlspecialchars($_GET[$callback], ENT_QUOTES);
			return $callback . '(' . self::json_encode($value) . ')';
		} else {
			return self::json_encode($value);
		}

	}

	// 获取客户端真实 IP 地址
	private static function _get_http_client_ip ($var = 'ip') {

		if (isset($_GET[$var])) {
			$var = htmlspecialchars($_GET[$var], ENT_QUOTES);
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$var = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$var = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$var = $_SERVER['REMOTE_ADDR'];
		}
		if (preg_match('/^[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}$/', $var)) {
			return $var;
		} else {
			return '127.0.0.1';
		}

	}

	// 判断是否内网 IP 地址
	static function is_taobao_ip ($var = 'ip') {

		$blocks = array(
			'42.120.72' => '0,255',
			'42.120.73' => '0,255',
			'42.120.74' => '0,255',
			'42.120.75' => '0,255',
			'115.236.52' => '106,106',
			'121.0.29' => '0,255',
			'121.0.31' => '120,127',
			'182.92.247' => '0,15',
			'202.165.107' => '100,101',
			'220.181.68' => '208,211'
		);
		$bytes = explode('.', self::_get_http_client_ip($var));
		$key = $bytes[0] . '.' . $bytes[1] . '.' . $bytes[2];
		if (array_key_exists($key, $blocks)) {
			$r = explode(',', $blocks[$key]);
			return ($bytes[3] >= $r[0] && $bytes[3] <= $r[1]);
		} else {
			return false;
		}

	}

	// 根据指定日期获取当前日期
	private static function _get_current_time ($date, $var = 'date') {

		$current_time = time();
		$regex = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}(\s[0-9]{2}:[0-9]{2}:[0-9]{2})?$/';
		if (isset($_GET[$var])) {
			$var = htmlspecialchars($_GET[$var], ENT_QUOTES);
			if (preg_match($regex, $var, $matches)) {
				$current_time = strtotime($matches[0]);
			}
		}
		$format = 'Y-m-d';
		if (preg_match($regex, $date, $matches)) {
			$format = isset($matches[1]) ? 'Y-m-d H:i:s' : $format;
		}
		return strtotime(date($format, $current_time));

	}

	// 判断是否某个日期
	static function is_date ($date, $var = 'date') {

		$current_time = self::_get_current_time($date, $var);
		return $current_time === strtotime($date);

	}

	// 判断是否某个日期之前
	static function is_before ($date, $var = 'date') {

		$current_time = self::_get_current_time($date, $var);
		return $current_time < strtotime($date);

	}

	// 判断是否某个日期之后
	static function is_after ($date, $var = 'date') {

		$current_time = self::_get_current_time($date, $var);
		return $current_time > strtotime($date);

	}

	// 判断是否在时间段内
	static function in_period ($start, $end, $var = 'date') {

		$current_time = self::_get_current_time($start, $var);
		return $current_time >= strtotime($start) && $current_time <= strtotime($end);

	}

	// 判断是否移动设备
	// @see http://detectmobilebrowsers.com/
	static function is_mobile ($var = 'device') {

		if (isset($_GET[$var])) {
			$var = htmlspecialchars($_GET[$var], ENT_QUOTES);
			return $var === 'mobile';
		} else {
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4));
		}

	}

}

?>