<?php
require(__DIR__ . '/init.php'); # 初始化
$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest'; # ajax设定

\F\D::_n()->c_url(':8080', 'http://127.0.0.1:8080');
// \F\D::_n()->c_url(':8080', 'http://120.25.62.29:8080'); // it1
// \F\D::_n()->c_url(':8080', 'http://120.25.105.175:8080'); // it2
// \F\D::_n()->c_url(':8080', 'http://120.25.81.90:8080'); // it3
// \F\D::_n()->c_url(':8080', 'http://112.74.74.223:8080'); // it4
// \F\D::_n()->c_url(':8080', 'http://120.24.68.108:8080'); // it5


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

