<?php
$GLOBALS['FON'] = array(
    'traceCount' => 0,
    'logPath'    => '/home/opt/logs/elog/',
    'arrayCode'  => array(),
);
register_shutdown_function('handle_fun_define');

function handle_fun_define() {
    if($GLOBALS['FON']['elog']) {
        flog(print_r(array(
            '总数'  => count($GLOBALS['FON']['elog']),
            '标识'  => array_column($GLOBALS['FON']['elog'], 'key'),
            '数据:' => $GLOBALS['FON']['elog'],
        ), true), 'elog', false);
        // flog(json_encode($GLOBALS['FON']['elog']), 'elog');
    }
}

function vc() {
    $info = reset(debug_backtrace());
    $file = explode('/', $info['file']);
    list($three, $two, $one) = array(end($file), prev($file), prev($file));
    $ret .= "";
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret .= 
        "\033[44;33m" . str_pad(  ++$k . " - {$one}/{$two}/{$three}:{$info['line']} *" , 80, '*') . "\033[0m\n\033[40;36m" 
        . print_r($v, true) . 
        "\033[0m\n" . str_repeat("*-", 40) . "\n\n";
    }
    $ret .= "\n";
    echo $ret;
    exit;
}

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
    // var_dump(!is_array($args['0']) || strtolower($args['0']['0']) != 'd' || !$args['0']['2']);
    if(!is_array($args['0']) || strtolower($args['0']['0']) != 'd' || !$args['0']['2']) {
        exit;
    }
}

function debug() {
    $ret = debug_backtrace();
    $info = reset($ret);
    $args = func_get_args();//获得传入的所有参数的数组
    echo '<pre>';
    foreach($ret as $v) {
            echo print_r(array(
                'self'     => $v['file'] . '::' . $v['function'] . ':' . $v['line'],
                'file'     => $v['file'],
                'line'     => $v['line'],
                'class'    => $v['class'],
                'function' => $v['function'],
                'type'     => $v['type'],
                'args'     => $args['0'] ? $v['args'] : vToOne($v['args']),
            ), true);
    }
    echo '</pre><hr />' . ++$GLOBALS['FON']['traceCount'] . '<hr />';
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

function fdate($time, $format = 'Y-m-d H:i:s') {
    return $time ? date($format, $time) : date($format);
}

function flog($con, $filename = '', $add = true, $path = '') {
    $path = empty($path) ? $GLOBALS['FON']['logPath'] : $path;
    $split = "\n\n" . str_repeat('######******', 6) . "\n\n";
    $filename = empty($filename) ? 'flog.' . fdate('', 'Y-m-d') : $filename;
    $handle = fopen($path . $filename, $add ? 'a+' : 'w+');
    fwrite($handle, $con . $split);
    fclose($handle);
}

// 进程结束后统一记录
function elog() {
    $debug = debug_backtrace();
    $info = reset($debug);
    $id = uniqid();
    $ret = array(
        'key'   => $id,
        'state' => fdate() . " - {$info['file']}:{$info['line']}\n\n",
        'con'   => array(),
    );
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret['con'][] = print_r($v, true);
    }
    $GLOBALS['FON']['elog'][] = $ret;
}

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

function pl() {
    $ret = debug_backtrace();
    $info = reset($ret);
    $ret = fdate() . " - {$info['file']}:{$info['line']}\n\n";
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret .= print_r($v, true);
    }
    $ret .= "\n";
    return $ret;
}

function ps() {
    $debug = debug_backtrace();
    $info = reset($debug);
    $ret = array(
        'state' => fdate() . " - {$info['file']}:{$info['line']}\n\n",
        'con'   => array(),
    );
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret['con'][] = print_r($v, true);
    }
    $ret['con'] .= "\n";
    return $ret;
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
        $ret .= '<h3>' . ++$k . "</h3>" . print_r($v, true) . "\n\n";
    }
    $ret .= '</pre>';
    echo $ret;
    exit;
}

function cp() {
    $info = reset(debug_backtrace());
    $file = explode('/', $info['file']);
    list($three, $two, $one) = array(end($file), prev($file), prev($file));
    $ret .= "";
    $args = func_get_args();//获得传入的所有参数的数组
    foreach ($args as $k => $v) {
        $ret .= 
        "\033[44;33m" . str_pad(  ++$k . " - {$one}/{$two}/{$three}:{$info['line']} *" , 80, '*') . "\033[0m\n\033[40;36m" 
        . print_r($v, true) . 
        "\033[0m\n" . str_repeat("*-", 40) . "\n\n";
    }
    $ret .= "\n";
    echo $ret;
}

$GLOBALS['T'] = 0;

function _arrayCode($array, $add = array()) {
    if(empty($array)) {
        return array();
    }
    $ret = array();
    foreach($array as $k => $v) {
        $add[] = $k;
        if(!empty($v) && is_array($v)) {
            _arrayCode($v, $add);
            array_pop($add);
            continue;
        }
        $newAdd = $add;
        $head = array_shift($newAdd);
        $key = $head . join('', array_map(function($value) { return "[{$value}]"; }, $newAdd));
        array_pop($add);
        $ret[$key] = $v;
    }
    if(!empty($ret)) {
        $GLOBALS['FON']['arrayCode'] = array_merge($GLOBALS['FON']['arrayCode'], $ret);
    }
}

function g($type) {
    switch (strtoupper($type)) {
        case 'GET':
            _arrayCode($_GET);
            break;
        case 'POST':
            _arrayCode($_POST);
            break;
        default:
            _arrayCode($_REQUEST);
            break;
    }
    $ret = '';
    if(!empty($GLOBALS['FON']['arrayCode'])) {
        foreach ($GLOBALS['FON']['arrayCode'] as $k => $v) {
            $ret .= "{$k}:{$v}\n";    
        }
    }
    echo $ret;
    die();
}