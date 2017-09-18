<?php
// require_once('/opt/dmcom/fon/fon.php');
// require_once('/opt/dmcom/fon/cls/fun.cls.php');
require(__DIR__ . '/init.php'); # 初始化

// $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest'; # ajax设定
// \F\D::_n()->c_url(':8080', 'http://127.0.0.1:8080');
// \F\D::_n()->callUseSaveAll(); # 使用所有缓存

// \F\D::_n()->c_url(':8080', 'http://120.25.62.29:8080'); // it1
// \F\D::_n()->c_url(':8080', 'http://120.25.105.175:8080'); // it2
// \F\D::_n()->c_url(':8080', 'http://120.25.81.90:8080'); // it3
// \F\D::_n()->c_url(':8080', 'http://112.74.74.223:8080'); // it4
// \F\D::_n()->c_url(':8080', 'http://120.24.68.108:8080'); // it5
\F\D::_n()->c_url(':8080', 'http://118.31.171.92:8080'); // it7
// \F\D::_n()->c_url(':8080', 'http://119.23.145.39:8080'); // ST1
// \F\D::_n()->c_url(':8080', 'http://120.78.14.64:8080'); // ST2


// \F\D::_n()->c_call('mdata', 'admin/User/getUsersByIds', ['a'=>'b']);
// \F\D::_n()->c_call('rdate', 'admin/User/getUsersByIds', ['a'=>'b']);
// \F\D::_n()->c_call('result', 'admin/User/getUsersByIds', ['a'=>'b']);
\F\D::_n()->c_call('useSave', array(
    'admin/Admin/info', 
    'admin/Admin/list',
    'admin/LocalDealBusiness/list', 
    'admin/LocalDealCity/list',
    'admin/Role/info', 
    'admin/User/getUsersByIds',
    'LocalDeal/cityList',
    'web/Season/list',
));
\F\D::_n()->m(array(
    // 'admin/Vote/list',
    // 'admin/Comment2/list',
    // 'admin/ExchangeGoods/list',
    // 'admin/ExchangeStatistocs/saleTotal',
    // 'admin/ExchangeStatistocs/trendList',
    // 'Score/getScoreLogList',
));
\F\D::_n()->s(// 是否展示
    array( // 选项
        // 'show'   => 1,
        // 'count'  => 1,
        'unique' => 1,
        // 'sortinfo' => 1, // 按照调用顺序展示
        'detail' => 
        array( // 细节的数据过滤
            // 'url', // 默认请求的url
            // 'realUrl', // 真实请求的url
            // 'redisKey', // 当前请求的rediskey
            'command', // 请求的命令
            'data', // 请求的参数
            'dataAr', // 请求的参数
            // 'needsReturn', // 是否需要返回
            // 'return', // 是否需要返回
            // 'returnDesc', // 返回的描述
            'returnAr', // 返回的数据
            // 'returnCount', // 返回数据的文字数
        ),
    )
);