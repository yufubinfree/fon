<?php
// v(test20170607150424());
function test20170607150424() {
    $keyPart = 'HOMEPAGE';
    $keyPattern = array ( "^W_{$keyPart}_EN_\d+_", "^W_{$keyPart}_CN_\d+_", "^M_{$keyPart}");
    $str = '/(' . implode('|',$keyPattern) . ')/';
    // apc_clear_cache('user');
    // $a = ['W_HOMEPAGE_CN_FON1', 'FON2', 'FON3', 'FON4', 'FON5', 'FON6', 'FON7', '123', '321'];
    // foreach($a as $v) {
    //     apc_store($v, $v, 5);
    // }
    v((new \APCIterator('user', '/^W_HOMEPAGE_CN_\d+/'))->current()['key'], (new \APCIterator('user', $str))->current()['key']);

    // v(apc_cache_info());

    // v($apc->getTotalHits(), $apc->current());

    foreach($apc as $cache){
        v('have');
        var_dump($cache);
    }



    v('end');
    v(apc_fetch('W_HOMEPAGE_CN_1_NEWEST_LIST_OT_8BF2'));


    while ($apc->valid()) {
            $current = $apc->current();
            array_push($this->view['onlineUsers'], substr($current['key'], strlen(Cache::PREFIX) + 5));
            $apc->next();
        }


    echo '显示内容:<hr />';

    v(apc_fetch('W_HOMEPAGE_CN_1_NEWEST_LIST_OT_8BF2'));


    die("<hr />END");

}
