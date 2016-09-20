<?php
defined('E_DEPRECATED')
    ? error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED)
    : error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE);

define('F_ROOT', __DIR__ . '/'); # 根目录
define('F_CONFIG', F_ROOT . 'cfg/'); # 配置文件
define('F_CLS', F_ROOT . 'cls/'); # 所有方法/类库

require(F_ROOT . '/init.php'); # 初始化
\FON\J::getInstance()->setCallUrl('http://106.184.2.121:8080'); # alpha
// \FON\J::getInstance()->setCallUrl('http://173.255.246.189:8080'); # beta
// \FON\J::getInstance()->setAllUrl('lang', 'cn');
\FON\J::getInstance()->setSaveAllResult();
// \FON\J::getInstance()->setUseSaveAll();
// \FON\J::getInstance()->setSaveResult('LocalDeal/cityList');
 
// \FON\J::getInstance()->s();
// \FON\J::getInstance()->m('web/Deal/detail'); 
// \FON\J::getInstance()->m('Vote/vote');
// \FON\J::getInstance()->m('Vote/viewVote'); # 投票展示
// \FON\J::getInstance()->m('admin/Vote/list');
// \FON\J::getInstance()->m('admin/Vote/update');
// \FON\J::getInstance()->m('admin/Vote/detailList');
// \FON\J::getInstance()->m('admin/Vote/get'); # 编辑/投票结果
// \FON\J::getInstance()->m('Search/search'); # 投票编辑搜