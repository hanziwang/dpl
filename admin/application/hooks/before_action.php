<?php

// 预处理业务规范
function before_action () {
var_dump(111);exit;
	// 资源初始化
	$key = & get_instance()->config->item('db') . '/' . md5('c:1');
	var_dump($key);exit;
	if (!file_exists($key)) {
		echo '123';
	}

}