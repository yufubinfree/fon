<?php
defined('E_DEPRECATED')
    ? error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED)
    : error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE);

define('F_ROOT', __DIR__ . '/'); # 根目录
define('F_CONFIG', F_ROOT . 'cfg/'); # 配置文件
define('F_CLS', F_ROOT . 'cls/'); # 所有方法/类库
define('F_VIEW', F_ROOT . 'view/'); # 所有方法/类库

date_default_timezone_set('PRC');

ini_set('session.cache_expire',  180);
ini_set('session.use_trans_sid', 0);
ini_set('session.use_cookies',   1);
ini_set('session.auto_start',    0);
ini_set('max_execution_time',    0);

# 功能开启
session_start();

$initPath = array(
	'.php' => F_CONFIG,
	'.cls.php'   => F_CLS,
);

# 引用配置文件
foreach($initPath as $suffix => $path) {
	foreach (scandir($path) as $fileName) {
	    if(strpos($fileName, $suffix) === false) {
	        continue;
	    }

	    require($path . $fileName);
	}
}