<?php
require(__DIR__ . '/init.php'); # 初始化
$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest'; # ajax设定

// $a = ''; for($i=0; $i<10; $i++) {$a .= 'CODE' . $i . ',PIN' . $i*10 . "\r\n"; }
// v(file_put_contents('/Users/yufubin/Desktop/' . date("YmdHis", time()) . '.csv', $a));

\F\D::_n()->c_url(':8080', 'http://127.0.0.1:8080');


// \F\D::_n()->c_call('mdata', 'admin/User/getUsersByIds', ['a'=>'b']);
// \F\D::_n()->c_call('rdate', 'admin/User/getUsersByIds', ['a'=>'b']);
// \F\D::_n()->c_call('result', 'admin/User/getUsersByIds', ['a'=>'b']);
\F\D::_n()->c_call('useSave', [
    'admin/Admin/info', 
    'admin/Role/info', 
    'admin/LocalDealBusiness/list', 
    'admin/Admin/list',
    'admin/LocalDealCity/list',
    'LocalDeal/cityList',
    'web/Season/list'
]);
// \F\D::_n()->callUseSaveAll(); # 使用所有缓存
\F\D::_n()->m([
    // 'admin/Vote/list'
]);
// \F\D::_n()->s(['returnAr', 'time', 'redisKey', 'dataAr', 'return',]);


// \F\D::_n()->c_call('save', [
//     'admin/User/getUsersByIds',
//     'admin/User/getUsersByIdB'
// ]);
// \F\D::_n()->c_result('admin/User/getUsersByIds', 0, [1,2,3], true);
// \F\D::_n()->c_resultSelf('admin/User/getUsersByIds', '123');

// \FON\JConfig::getInstance()->setJCCConfig('admin/selectDealWinUse', array(), array('ret'=>'{"result": {"code":0}, "responseData": {"winners": [{"userId": "12", "name": "tester", "email": "lishimin@mail.dealmoon.com", "ip": "192.168.1.134", "country": "美国", "source": "iphone", "score": "10", "gold": "0", "submit_time": "2016-10-28", "message": "很喜欢"}, {"userId": "12", "name": "tester", "email": "lishimin@mail.dealmoon.com", "ip": "192.168.1.134", "country": "美国", "source": "iphone", "score": "10", "gold": "0", "submit_time": "2016-10-28", "message": "很喜欢"} ] } }'));


// \FON\J::getInstance()->je(false); 
// \FON\J::getInstance()->setCallUrl('127.0.0.1:8080'); # 本地编辑器版本
// \FON\J::getInstance()->setCallUrl('120.24.68.108:8080'); # IT5

// \FON\J::getInstance()->setCallUrl('192.168.1.89:8080'); # 本地编辑器版本
// \FON\J::getInstance()->setCallUrl('192.168.1.118:8080'); # 本地编辑器版本
// \FON\J::getInstance()->setCallUrl('50.97.234.100:8080'); # 线上
// \FON\J::getInstance()->setCallUrl('120.25.62.29:8080'); # IT1
// \FON\J::getInstance()->setCallUrl('120.25.105.175:8080'); # IT2
// \FON\J::getInstance()->setSaveRead(['admin/Role/info', 'admin/Admin/info']); # 使用记录版本的

// \FON\J::getInstance()->setCallUrl('http://192.168.1.57:8080'); # 黄伟 - beyond

// \FON\J::getInstance()->setCallUrl('http://192.168.1.175:8080'); # 万恒-beyond
// \FON\J::getInstance()->setCallUrl('http://192.168.105.229:8081'); # 万恒-dealmoon
// \FON\J::getInstance()->setCallUrl('http://106.184.2.121:8080'); # 北京-alpha

// \FON\J::getInstance()-('http://173.255.246.189:8080'); # beta
// \FON\J::getInstance()->setCallUrl('http://50.116.3.240:8080'); # beta2
// \FON\J::getInstance()->setCallUrl('http://45.79.80.237:8080'); # beta4

// \FON\J::getInstance()->setCallUrl('http://120.24.68.108:8080'); # 阿里云测试
// \FON\J::getInstance()->setCallUrl('http://106.185.36.81:8080'); # dmjp1

// \FON\J::getInstance()->setAllUrl('lang', 'cn');
// \FON\J::getInstance()->setUseSaveAll();
// \FON\J::getInstance()->u(['admin/Admin/info', 'admin/Role/info']);
// \FON\J::getInstance()->setUseSave([
//     'admin/Admin/info', 
//     'admin/Role/info', 
//     'admin/LocalDealBusiness/list', 
//     'admin/Admin/list',
//     'admin/LocalDealCity/list',
// ]);
// \FON\J::getInstance()->s();

// \FON\J::getInstance()->m([ // 监视一条或多条命令
    // 'admin/ExchangeGoods/list',
    // 'admin/ActivityPrizesUser/createList'
    // 'admin/Comment2/list',
	// 'admin/Comment2/list',
	// 'admin/Comment/groupList'
	// 'admin/User/getUsersByIds'
	// 'admin/Comment2/update'
// ]); 

//


/*
\FON\JConfig::getInstance()->setJCCConfig('Exchange/scoreList', array(), array('host'=>'http://127.0.0.1:8080', 'ret' => '{
    "result": {
        "code": 0
    },
    "responseData": {
        "total": 446
    }
}', ));
 */


// \FON\J::getInstance()->m('Vote/viewVote'); # 投票展示
// \FON\J::getInstance()->m('admin/Vote/list');
// \FON\J::getInstance()->m('admin/Vote/update');i
// \FON\J::getInstance()->m('admin/Vote/detailList');
// \FON\J::getInstance()->m('admin/Vote/get'); # 编辑/投票结果
// \FON\J::getInstance()->m('Search/search'); # 投票编辑搜

// \FON\JConfig::getInstance()->setJCCConfig('admin/selectDealWinUse', array(), array('ret'=>'{"result": {"code":0}, "responseData": {"winners": [{"userId": "12", "name": "tester", "email": "lishimin@mail.dealmoon.com", "ip": "192.168.1.134", "country": "美国", "source": "iphone", "score": "10", "gold": "0", "submit_time": "2016-10-28", "message": "很喜欢"}, {"userId": "12", "name": "tester", "email": "lishimin@mail.dealmoon.com", "ip": "192.168.1.134", "country": "美国", "source": "iphone", "score": "10", "gold": "0", "submit_time": "2016-10-28", "message": "很喜欢"} ] } }'));



// \FON\JConfig::getInstance()->setJCCConfig('EditorLog/getEditorLogList', array('resType'=>'post'), array('host'=>'http://127.0.0.1:8080'));

// \FON\JConfig::getInstance()->setJCCConfig('admin/Admin/info', array('resType'=>'post'), array('host'=>'http://127.0.0.1:8080', 'ret' => '{"result":{"code":0},"responseData":{"userId":1,"userName":"xliu","email":"xin.liu@mail.dealmoon.com","roles":[{"roleId":33,"roleName":"\u7CFB\u7EDF\u7BA1\u7406\u5458"}],"state":"activated","group":{},"privilege":"administrator"}}', ));

// \FON\JConfig::getInstance()->setJCCConfig('dealHeaderBanner/list', array(), array('host'=>'http://192.168.1.175:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/DealHeaderBanner/list', array(), array('host'=>'http://192.168.1.175:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/DealHeaderBanner/add', array(), array('host'=>'http://192.168.1.175:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/DealHeaderBanner/update', array(), array('host'=>'http://192.168.1.175:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/DealHeaderBanner/online', array(), array('host'=>'http://192.168.1.175:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/DealHeaderBanner/offline', array(), array('host'=>'http://192.168.1.175:8080'));




//
// \FON\JConfig::getInstance()->setJCCConfig('admin/Medal/onlineMedal', array('resType'=>'post'), array('host'=>'http://192.168.1.60:8080', 'ret'=>'{"result":{"code":0},"responseData":{"id":24,"medalName":"123","medalType":2,"medalAlias":"321","medalDesc":"123","iconUrl":"http://fsvr.dealmoon.com/dealmoon/04d/1ae/1fc/7b3/ad8/52f/910/6e1/204/5d6/f8.png","createEditorId":1,"updateEditorId":1,"createTime":1475043485,"updateTime":1475043540,"onlineTime":1475043540,"approvalNum":0,"medalConditions":[{"id":46,"medalId":24,"conditionName":"\u6652\u8D27\u8D34\u6570","conditionKey":"postNum","conditionMode":3,"conditionValue":1},{"id":47,"medalId":24,"conditionName":"\u7CBE\u534E\u6652\u8D27\u5E16\u6570","conditionKey":"digestPostNum","conditionMode":3,"conditionValue":2}],"status":1}}'));
// \FON\JConfig::getInstance()->setJCCConfig('admin/Medal/offlineMedal', array('resType'=>'post'), array('host'=>'http://192.168.1.60:8080'));
// \FON\JConfig::getInstance()->setJCCConfig('Search/search', array('resType'=>'post'), array('host'=>"http://106.184.2.121:8080"));










// $data = array();
// v(getAdvertisementList(1, 20, array_pad([], 20, 0), $data));
// function getAdvertisementList( $pageNum, $pageSize, $dealData, $data) {
//     $advertisementsPositionArray = array();
//     //localExist用于记录是否已经匹配到指定城市的deal，只取匹配到的TOP1
//     $localExist = false;
//     foreach($data['advertisements'] as $k=>&$v){
//         //local广告在PC首页固定35号位置进行展示---2016-10-17
//         if (!$localExist && $v['position'] == 15 && $v['type'] == 'local' && isset($v['images']) && count($v['images']) >= 4) {
//             $city = $v['localDeal']['local']['city']['id'];
//             $userCity = $_COOKIE['cityId'];
//             if ($city == $userCity) {
//                 $v['position'] = 35;
//                 $localExist = true;
//             }
//         }
//         $advertisementsPositionArray[$k] = $v['position'];
//     }
//     //过滤出当前页中的广告
//     foreach($data['advertisements'] as $k => &$v){
//         if( (($pageNum-1) * $pageSize) < $v['position'] && $v['position'] <= ($pageNum * $pageSize)  && $v['position']!= 15){
//             //删除已显示的广告的k
//             array_splice($advertisementsPositionArray,$k,100);

//             $num = count($advertisementsPositionArray);

//             $advertisements[] = $v;
            
//             //拼接Local城市
//             $url = $v['scheme']['schemeUrl'].'?'.$v['localDeal']['local']['city']['url'];
//             $advertisements[0]['scheme']['schemeUrl'] = $this->getSdk()->Link->schemeToUrl($url,false,'en')['url'];
//             //图片进行缩略
//             foreach($advertisements[0]['images'] as $imgK => &$imgV){

//                 $advertisements[0]['images'][$imgK] = $this->getSdk()->GenThumbImage->GenUrl($imgV, '200_200');
//             }

//             //将广告信息塞入deal列表中
//             array_splice($dealData['deals'],($v['position'] - $pageSize*($pageNum - 1)-$num-1),0,$advertisements);
//             //初始化变量
//             unset($advertisements);
//         }
//     }
//     return $dealData;
// }