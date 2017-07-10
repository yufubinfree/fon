<?php
function v() {
    $ret = debug_backtrace();
    echo '<pre>'; #print_r($ret); exit;
    $info = reset($ret);
    $args = func_get_args();//获得传入的所有参数的数组
    if(is_array($args['0']) && strtolower($args['0']['0']) == 'd') {
        echo "调用堆栈:\n";
        foreach($ret as $v) {
            echo print_r(array(
                'file'     => $v['file'],
                'line'     => $v['line'],
                'class'    => $v['class'],
                'function' => $v['function'],
                'type'     => $v['type'],
                'args'     => $args['0']['1'] ? $v['args'] : vToOne($v['args']),
            ), true);
        }
    }
    $time = '[' . time() . '|' . date("Y-m-d H:i:s", time()) . ']';
    echo "<pre><hr /><span style='color:red; font-weight:bold;'>{$time}</span> <span style='color:CornflowerBlue; font-weight:bold;'>{$info['file']}:{$info['line']}<br /><hr /></span>";
    foreach ($args as $k => $v) {
        echo '<div style="background-color:DarkSeaGreen; height:30px; text-align:center;line-height:28px; border-radius:5px; text-shadow: 1px 1px 1px #333; font-weight:bold; border:1px solid yellow; color:tomato; width:20%"">' . ++$k . '</div>';
        var_dump($v);
    }
    if(!is_array($args['0']) || strtolower($args['0']['0']) != 'd' || !$args['0']['2']) {
        exit;
    }
}

function vToOne($data) {
    $ret = array();
    foreach($data as $v) {
        $ret[] = is_array($v) || is_object($v) ? '[Array OR Object]' : $v;
    }

    return $ret;
}

function m() {
    $post_ori = array();
    $post_str = file_get_contents("php://input");
    parse_str($post_str, $post_ori);
    $post_str = empty($post_str) ? $_POST : $post_str;
    echo '<pre>';
    echo '<h3>URL</h3>';
    echo '<textarea style="width:500px; height:100px;" name="url">' . $_SERVER['SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'] . '</textarea>';
    echo '<h3>POSTJSON</h3>';
    echo '<textarea style="width:500px; height:100px;" name="con">' . json_encode($post_ori) . '</textarea>';
    exit;
}

// function l() {
//     $filepath = '/fon/log/fon_log.' . date('Y-m-d', time());
//     $con = file_get_contents($filepath);
//     file_put_contents($filepath, $con . print_r(func_get_args(), true));
// }

// function d() {
//     $filepath = '/fon/log/fon_log.' . date('Y-m-d', time());
//     file_put_contents($filepath, '');
// }

# 获取当前错误的配置
function e() {
    $info = array(
         'E_ERROR'             =>  E_ERROR,
         'E_WARNING'           =>  E_WARNING,
         'E_PARSE'             =>  E_PARSE,
         'E_NOTICE'            =>  E_NOTICE,
         'E_CORE_ERROR'        =>  E_CORE_ERROR,
         'E_CORE_WARNING'      =>  E_CORE_WARNING,
         'E_COMPILE_ERROR'     =>  E_COMPILE_ERROR,
         'E_COMPILE_WARNING'   =>  E_COMPILE_WARNING,
         'E_USER_ERROR'        =>  E_USER_ERROR,
         'E_USER_WARNING'      =>  E_USER_WARNING,
         'E_USER_NOTICE'       =>  E_USER_NOTICE,
         'E_STRICT'            =>  E_STRICT,
         'E_RECOVERABLE_ERROR' =>  E_RECOVERABLE_ERROR,
         'E_DEPRECATED'        =>  E_DEPRECATED,
         'E_USER_DEPRECATED'   =>  E_USER_DEPRECATED,
         'E_ALL'               =>  E_ALL,
    );
    $ret = array(
        'display_errors' => ini_get('display_errors'),
    );
    $errSet = ini_get('error_reporting');
    foreach($info as $k => $v) {
        $ret[$k] = $errSet & $v;
    }
    

    v($ret);
}

function j() {
    die(json_encode(func_get_args()));
}

function pp() {
    $ret = debug_backtrace();
    $info = reset($ret);
    $ret = "<pre>{$info['file']}:{$info['line']}\n\n";
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret .= print_r($v, true);
    }
    $ret .= '</pre>';
    echo $ret;
}

function p() {
    $info = reset(debug_backtrace());
    $ret = '<pre>';
    $ret .= "{$info['file']}:{$info['line']}\n\n";
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret .= '<h3>' . ++$k . "</h3>" . print_r($v, true);
    }
    $ret .= '</pre>';
    echo $ret;
    exit;
}
