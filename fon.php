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
    'admin/Admin/list',
    'admin/LocalDealBusiness/list', 
    'admin/LocalDealCity/list',
    'admin/Role/info', 
    'admin/User/getUsersByIds',
    'LocalDeal/cityList',
    'web/Season/list',
    // 'admin/Comment2/list',
    'admin/Deal/list',
]);
// \F\D::_n()->callUseSaveAll(); # 使用所有缓存
\F\D::_n()->m([
    // 'admin/Vote/list',
    // 'admin/Comment2/list',
]);
// \F\D::_n()->s(false);
\F\D::_n()->s(// 是否展示
    0, 
    [ // 选项
        'count'  => 1,
        'unique' => 1,
        // 'sortinfo' => 1, // 按照调用顺序展示
        // 'detail' => 1, // 细节调用
    ],
    [ // 细节的数据过滤
        'returnAr', 
        'time', 
        'redisKey', 
        'data', 
        'dataAr', 
        'return',
    ]
);


// test20170712112450();