<?php
namespace FON;

/**
 * 投票用模拟类
 */
$T = JConfig::getInstance();
// $T->setJCCConfig('Vote/viewVote', array(), array('ret'=>'{"result":{"code":0},"responseData":{"id":18,"titleCn":"FONtest1","descCn":"FONdesc1","selectNum":1,"startTime":1473301136,"endTime":1474613940,"createTime":1473218318,"needLogin":true,"status":1,"editorId":1,"createEditorId":1,"imgUrl":"http://fsvr.dealmoon.com/dealmoon/136/2d8/35c/3eb/748/db0/d10/a55/871/e13/46.png","allowCustom":true,"userTotal":3,"detailTotal":3,"pageStatus":1,"voteItems":[{"id":99,"voteId":18,"imgUrl":"http://fsvr.dealmoon.com/dealmoon/136/2d8/35c/3eb/748/db0/d10/a55/871/e13/46.png","descCn":"\u9009\u62E91","voteNum":0,"hasother":0,"orderIndex":0},{"id":100,"voteId":18,"imgUrl":"http://fsvr.dealmoon.com/dealmoon/a18/821/31b/fe5/0c0/c14/0b1/ec8/d58/30f/bf.png","descCn":"\u9009\u62E92","voteNum":2,"hasother":0,"orderIndex":1},{"id":101,"voteId":18,"imgUrl":"http://fsvr.dealmoon.com/dealmoon/a40/a4a/97c/ebd/4ba/5d5/adb/5e7/28d/12b/64.png","descCn":"\u9009\u62E93","voteNum":1,"hasother":0,"orderIndex":2},{"id":102,"voteId":18,"descCn":"\u5176\u4ED6","voteNum":0,"hasother":1,"orderIndex":3}]}}'));

// $T = JConfig::getInstance();

// # 获取投票列表页信息，支持按查询条件过滤，默认返回全部信息。
// $T->setJCCConfig('admin/Vote/list', array(), array(
// 	'ret1' => file_get_contents(F_CONFIG . '/JConfig/data/admin_Vote_list'),
// ));

// # 更新投票状态，更新为已开始或已结束。
// $T->setJCCConfig('admin/Vote/updateStatus', array(), array(
//     'host' => '106.184.2.121:8080',

//     'ret1' => '{"result":{"code":0,"tip":"操作成功PHP"},"responseData":{"id":"22","titleCn":"标题","descCn":"描述","selectNum":"用户可选项目数","startTime":"1472572800","endTime":"1472672800","createTime":"创建时间","needLogin":"是否需要登录","status":"1","editorId":"编辑id","createEditorId":"创建编辑id","imgUrl":"图片url","allowCustom":"是否允许用户自定义","userTotal":"投票总用户数","editor":"编辑名修改","createEditor":"创建编辑名"}}',
//     '#C11' => array(
//         '#ret2' => '$command["id"]==113',
//         '#ret3' => '$command["id"]==112',
//     ),
//     '#ret31' => '{"result":{"code":0,"tip":"操作成功PHP"},"responseData":{"id":"112","titleCn":"标题","descCn":"描述","selectNum":"用户可选项目数","startTime":"1472572800","endTime":"1472672800","createTime":"创建时间","needLogin":"是否需要登录","status":"2","editorId":"编辑id","createEditorId":"创建编辑id","imgUrl":"图片url","allowCustom":"是否允许用户自定义","userTotal":"投票总用户数","editor":"编辑名修改","createEditor":"创建编辑名"}}',
//     '#ret21' => '{"result":{"code":2,"tip":"JAVA返回的操作异常说明"}}',
// ));
// $T->setJCCConfig('admin/Deal/search', array(), array(
//     'host' => '106.184.2.121:8080',
//     'ret1'  => file_get_contents(F_CONFIG . '/JConfig/data/admin_Deal_search'),
// ));

// $T->setJCCConfig('admin/Vote/add', array(), array(
//     'host' => '106.184.2.121:8080',
//     'ret1' => '{"result":{"code":0}}',
// ));
// $T->setJCCConfig('admin/Vote/update', array(), array(
//     'host' => '106.184.2.121:8080',
//     'ret1' => '{"result":{"code":0}}',
// ));

// # 投票编辑页/投票结果页
// $T->setJCCConfig('admin/Vote/get', array(), array(
//     'host' => '106.184.2.121:8080',
//     'ret1'  => file_get_contents(F_CONFIG . '/JConfig/data/admin_Vote_get'),
// ));

// $T->setJCCConfig('EditorLog/getEditorLogList', array(), array(
//     'host' => '106.184.2.121:8080',
//     // 'ret1'  => file_get_contents(F_CONFIG . '/JConfig/data/admin_Vote_get'),
// ));

// $T->setJCCConfig('admin/Vote/detailList', array(), array(
//     'host' => '106.184.2.121:8080',
//     'ret1'  => '{"result":{"code":0},"responseData":{"total":2,"itemDescCn":"CONTRAST CITY BAG","orderIndex":1,"itemTotal":2,"voteTotal":2,"users":[{"id":1,"username":"\u725F\u4F73\u658C","ip":"127.0.0.1","countryCode":"CN","countryName":"\u4E2D\u56FD","voteTime":1472626365,"voteItem":"CONTRAST CITY BAG"},{"id":2,"image":"http://tp1.sinaimg.cn/1644520780/180/0/1","username":"out_man","ip":"128.0.0.1","countryCode":"US","countryName":"\u7F8E\u56FD","voteTime":1472626395,"voteItem":"CONTRAST CITY BAG"}]}}',
//     'ret1'  => '{"result":{"code":0},"responseData":{"total":6,"users":[{"id":3,"username":"dealmoon001","ip":"128.0.0.2","countryCode":"CN","countryName":"\u4E2D\u56FD","voteTime":1472626295,"voteItem":"\u60AC\u77401"},{"id":4,"username":"dealmoon","ip":"128.0.0.3","countryCode":"US","countryName":"\u7F8E\u56FD","voteTime":1472626395,"voteItem":"\u60AC\u77401"},{"id":5,"image":"http://tp1.sinaimg.cn/5107597164/180/22871852134/1","username":"sunxungr001","ip":"128.0.0.4","countryCode":"CN","countryName":"\u4E2D\u56FD","voteTime":1472626495,"voteItem":"\u9009\u62E92"},{"id":6,"username":"d002","ip":"128.0.0.5","countryCode":"US","countryName":"\u7F8E\u56FD","voteTime":1472626595,"voteItem":"\u9009\u62E92"},{"id":7,"username":"liushuai","ip":"128.0.0.6","countryCode":"CN","countryName":"\u4E2D\u56FD","voteTime":1472626695,"voteItem":"\u9009\u62E93"},{"id":8,"username":"d004","ip":"128.0.0.7","countryCode":"CN","countryName":"\u4E2D\u56FD","voteTime":1472626795,"voteItem":"Others"}]}}',
// ));
// $T->setJCCConfig('Search/search', array(), array(
//     'host' => '106.184.2.121:8080',
//     // 'ret1'  => file_get_contents(F_CONFIG . '/JConfig/data/Search_search'),
// ));

// # 投票保存的接口
// $T->setJCCConfig('Vote/viewVote', array(), array(
//     'host' => '106.184.2.121:8080',
//     'token' => '14386%7C99c6033427077925e2bb37f98cc31414    ',
//     'ret1'   => '{"result":{"code":0},"responseData":{"id":1,"titleCn":"\u4F17\u6D4B\u4EA7\u54C1\u4F60\u6765\u6311\uFF01","descCn":"\u54C8\u55BD\uFF01\u541B\u541B\u53C8\u6765\u4E86\uFF0C\u6311\u9009\u51FA\u4F60\u6700\u559C\u6B22\u7684\u4F17\u6D4B\u4EA7\u54C1\u5427\uFF01","selectNum":3,"startTime":1473042843,"endTime":1473127676,"createTime":1472008733,"needLogin":true,"status":0,"editorId":175,"createEditorId":175,"imgUrl":"http://imgcache.dealmoon.com/img.dealmoon.com/images/c/16/06/22/576b848def64b.jpg_130_130_2_2bc0.jpg","allowCustom":true,"userTotal":1,"detailTotal":4,"pageStatus":1,"voteItems":[{"id":1,"voteId":1,"imgUrl":"http://imgcache.dealmoon.com/img.dealmoon.com/images/c/16/06/22/576b848def64b.jpg_130_130_2_2bc0.jpg","descCn":"CONTRAST CITY BAG","voteNum":2,"hasother":0,"orderIndex":1},{"id":2,"voteId":1,"imgUrl":"http://imgcache.dealmoon.com/img.dealmoon.com/data/sp/upload/image/2016/06/22/51e1fa.jpg_158_132_2_6240.jpg","descCn":"CROSS BODY BAG WITH METALLIC DETAIL","voteNum":2,"hasother":0,"orderIndex":2}]}}',
//     'ret1' => '{"result":{"code":0},"responseData":{"id":6,"titleCn":"test add vote-title","descCn":"test add vote-title","selectNum":2,"startTime":1473042843,"endTime":1473127676,"createTime":1472448891,"needLogin":true,"status":0,"editorId":175,"createEditorId":175,"allowCustom":true,"userTotal":0,"detailTotal":0,"pageStatus":1,"voteItems":[{"id":20,"voteId":6,"descCn":"vote item111","voteNum":0,"hasother":0,"orderIndex":0},{"id":21,"voteId":6,"descCn":"vote item222","voteNum":0,"hasother":0,"orderIndex":1},{"id":22,"voteId":6,"descCn":"vote item3","voteNum":0,"hasother":0,"orderIndex":2},{"id":23,"voteId":6,"descCn":"vote item 4","voteNum":0,"hasother":0,"orderIndex":3},{"id":24,"voteId":6,"descCn":"Others","voteNum":0,"hasother":1,"orderIndex":4}]}}',
//     // 'ret1'  => file_get_contents(F_CONFIG . '/JConfig/data/Search_search'),
// ));

// # 投票保存的接口
// $T->setJCCConfig('Vote/vote', array(), array(
//     'host' => '106.184.2.121:8080',
//     'token' => '14386%7C99c6033427077925e2bb37f98cc31414',
//     // 'ret1'  => file_get_contents(F_CONFIG . '/JConfig/data/Search_search'),
// ));
