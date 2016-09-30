<?php
require(__DIR__ . '/init.php'); # 初始化

\FON\J::getInstance()->setCallUrl('http://192.168.1.57:8080'); # 黄伟 - beyond

// \FON\J::getInstance()->setCallUrl('http://192.168.1.175:8081'); # 万恒-beyond
// \FON\J::getInstance()->setCallUrl('http://192.168.105.229:8081'); # 万恒-dealmoon
// \FON\J::getInstance()->setCallUrl('http://106.184.2.121:8080'); # 北京-alpha
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

// \FON\JConfig::getInstance()->setJCCConfig('admin/Medal/list', array(), array('host'=>'http://192.168.1.175:8081', 'ret'=>'{"result": {"code": 0 }, "responseData": {"total": 3, "medals": [{"id": 1, "medalName": "keef", "medalType": 1, "medalAlias": "飞达人33112434", "medalDesc": "good medal", "iconUrl": "https://www.baidu.com/img/bd_logo1.png", "createEditorId": 1, "createEditorName": "xliu", "updateEditorId": 1, "updateEditorName": "xliu", "createTime": 1474459370, "updateTime": 1474459370, "offlineTime": 1474708106, "approvalNum": 0, "status": 2 } ] } }'));
// \FON\JConfig::getInstance()->setJCCConfig('EditorLog/getEditorLogList', array('resType'=>'post'), array('host'=>'http://127.0.0.1:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/Medal/listApprovedUsers', array('resType'=>'post'), array('host'=>'http://127.0.0.1:8080', 'ret' => '{"result":{"code":0},"responseData":{"total":2,"medals":[{"id":150695,"name":"\u5927Mia\u7684\u65F6\u5C1A\u8D26\u53F7","avatar":"http://imgcache.dealmoon.com/fsvr.dealmoon.com/avatar/0d6/1e4/734/1aa/495/238/58f/50d/96a/14e/a2.jpg_200_200_2_91a7.jpg","level":"\u516B\u7EA7","countryCode":"US","postNum":88,"digestPostNum":62,"ip":"12.163.78.11","medals":[{"id":2,"userId":150695,"medalId":1,"approvalTime":1474679640,"approvalEditorId":1,"medalName":"test_medal","medalType":1,"medalAlias":"test_medal","medalDesc":"test","iconUrl":"https://www.baidu.com/img/bd_logo1.png"}]}]}}', ));

// \FON\JConfig::getInstance()->setJCCConfig('admin/Admin/info', array('resType'=>'post'), array('host'=>'http://127.0.0.1:8080', 'ret' => '{"result":{"code":0},"responseData":{"userId":1,"userName":"xliu","email":"xin.liu@mail.dealmoon.com","roles":[{"roleId":33,"roleName":"\u7CFB\u7EDF\u7BA1\u7406\u5458"}],"state":"activated","group":{},"privilege":"administrator"}}', ));


// \FON\JConfig::getInstance()->setJCCConfig('admin/Vote/list', array('resType'=>'post'), array('host'=>'http://127.0.0.1:8080'));
// 
// \FON\JConfig::getInstance()->setJCCConfig('admin/Medal/onlineMedal', array('resType'=>'post'), array('host'=>'http://192.168.1.60:8080', 'ret'=>'{"result":{"code":0},"responseData":{"id":24,"medalName":"123","medalType":2,"medalAlias":"321","medalDesc":"123","iconUrl":"http://fsvr.dealmoon.com/dealmoon/04d/1ae/1fc/7b3/ad8/52f/910/6e1/204/5d6/f8.png","createEditorId":1,"updateEditorId":1,"createTime":1475043485,"updateTime":1475043540,"onlineTime":1475043540,"approvalNum":0,"medalConditions":[{"id":46,"medalId":24,"conditionName":"\u6652\u8D27\u8D34\u6570","conditionKey":"postNum","conditionMode":3,"conditionValue":1},{"id":47,"medalId":24,"conditionName":"\u7CBE\u534E\u6652\u8D27\u5E16\u6570","conditionKey":"digestPostNum","conditionMode":3,"conditionValue":2}],"status":1}}'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/Medal/offlineMedal', array('resType'=>'post'), array('host'=>'http://192.168.1.60:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('Search/search', array('resType'=>'post'), array('host'=>"http://106.184.2.121:8080"));
