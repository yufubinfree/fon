<?php
defined('E_DEPRECATED')
    ? error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED)
    : error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE);

define('F_ROOT', __DIR__ . '/'); # 根目录
define('F_CONFIG', F_ROOT . 'cfg/'); # 配置文件
define('F_CLS', F_ROOT . 'cls/'); # 所有方法/类库

