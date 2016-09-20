<?php
namespace FON;

$initPath = array(
	'Config.php' => F_CONFIG,
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