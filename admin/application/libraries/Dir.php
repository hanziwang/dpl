<?php

/**
 * 目录文件操作类
 */
class Dir {

	// 设置目录访问权限
	function chmod ($filename, $mode) {

		if (!is_dir($filename)) {
			return @chmod($filename, $mode);
		}
		$dh = opendir($filename);
		while (($file = readdir($dh)) !== false) {
			if ($file != '.' && $file[0] != '.') {
				$fullpath = $filename . '/' . $file;
				if (is_link($fullpath)) {
					return false;
				} elseif (!is_dir($fullpath) && !@chmod($fullpath, $mode)) {
					return false;
				} elseif (!$this->chmod($fullpath, $mode)) {
					return false;
				}
			}
		}
		closedir($dh);
		return @chmod($filename, $mode);

	}

	// 拷贝目录文件
	function copy ($source, $dest) {

		if (!is_dir($source)) {
			return false;
		}
		if (!file_exists($dest)) {
			if (!mkdir(rtrim($dest, '/'), 0777)) {
				return false;
			}
			@chmod($dest, 0777);
		}
		$handle = dir($source);
		while ($entry = $handle->read()) {
			if ($entry != '.' && $entry[0] != '.') {
				if (is_dir($source . '/' . $entry)) {
					$this->copy($source . '/' . $entry, $dest . '/' . $entry);
				} else {
					@copy($source . '/' . $entry, $dest . '/' . $entry);
				}
			}
		}
		return true;
	}

	// 获取目录的 md5 序列值
	function md5 ($dirname) {

		if (!is_dir($dirname)) {
			return false;
		}
		$md5 = array();
		$d = dir($dirname);
		while (false !== ($entry = $d->read())) {
			if ($entry != '.' && $entry[0] != '.') {
				if (is_dir($dirname . '/' . $entry)) {
					$md5[] = $this->md5($dirname . '/' . $entry);
				} else {
					$md5[] = md5_file($dirname . '/' . $entry);
				}
			}
		}
		$d->close();
		return md5(implode('', $md5));
	}

	// 删除非空目录
	function rmdir ($dirname) {

		if (is_dir($dirname)) {
			$this->chmod($dirname, 0777);
			$files = glob($dirname . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (substr($file, -1) === '/') {
					$this->rmdir($file);
				} else {
					unlink($file);
				}
			}
			return rmdir($dirname);
		} else {
			return true;
		}

	}

}