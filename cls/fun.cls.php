<?php
$GLOBALS['FON'] = array(
    'traceCount' => 0,
    'logPath'    => '/home/opt/logs/elog/',
    'arrayCode'  => array(),
);
register_shutdown_function('handle_fun_define');

function handle_fun_define() {
    // debug();
    if(isset($GLOBALS['FON']['elog']) && $GLOBALS['FON']['elog']) {
        flog(print_r(array(
            '总数'  => count($GLOBALS['FON']['elog']),
            '标识'  => array_column($GLOBALS['FON']['elog'], 'key'),
            '数据:' => $GLOBALS['FON']['elog'],
        ), true), 'elog', false);
        // flog(json_encode($GLOBALS['FON']['elog']), 'elog');
    }
    # 程序结束后添加的代码
    if(SHOW_XHPROF !== false && !defined('XHPROFSHOWED')) {
        define('XHPROFSHOWED', true);
        // stop profiler
        $xhprof_data = xhprof_disable();
        // display raw xhprof data for the profiler run
        # print_r($xhprof_data);
        # $XHPROF_ROOT = realpath(dirname(__FILE__) .'/..');
        $XHPROF_ROOT = realpath('/Users/yufubin/Documents/Code/xhprof/');
        include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
        include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
        // save raw data for this profiler run using default
        // implementation of iXHProfRuns.
        $xhprof_runs = new XHProfRuns_Default();
        // save the run under a namespace "xhprof_foo"
        $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
        echo "<hr />XHPROF:<a href='http://xhprof.dealmoon.com/index.php?run=$run_id&source=xhprof_foo'>http://xhprof.dealmoon.com/index.php?run=$run_id&source=xhprof_foo</a>";
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

function debug($set, $reverse = false, $file = '') {
    $ret = debug_backtrace();
    $info = reset($ret);
    $args = func_get_args();//获得传入的所有参数的数组
    $show = array();
    foreach($ret as $v) {
        $self = str_replace('/Users/yufubin/Documents/Code/', '', $v['file']);
        $self .= empty($v['class']) ? '' : " [{$v['class']}]";
        $self .= " :: {$v['function']} : {$v['line']}";
        $self = trim($self);
        $show[] = array(
            'self'     => $self,
            'file'     => $v['file'],
            'line'     => $v['line'],
            'class'    => $v['class'],
            'function' => $v['function'],
            'type'     => $v['type'],
            'args'     => $args['0'] ? $v['args'] : vToOne($v['args']),
        );
    }
    if($reverse) {
        $show = array_reverse($show);
    }
    $str = '<pre>';
    if (!empty($set) && is_array($set)) {
        foreach($show as $v) {
            $tmp_show = array();
            in_array('self', $set) ? $tmp_show['self'] = $v['self'] : '';
            in_array('file', $set) ? $tmp_show['file'] = $v['file'] : '';
            in_array('line', $set) ? $tmp_show['line'] = $v['line'] : '';
            in_array('class', $set) ? $tmp_show['class'] = $v['class'] : '';
            in_array('function', $set) ? $tmp_show['function'] = $v['function'] : '';
            in_array('type', $set) ? $tmp_show['type'] = $v['type'] : '';
            in_array('args', $set) ? $tmp_show['args'] = $v['args'] : '';
            $str .= count($tmp_show) == 1 ? reset($tmp_show) : print_r($tmp_show, true);
            $str .= "\n";
        }
    } else {
        foreach($show as $v) {
            $str .= print_r($v, true);
        }
    }
    $str .= '</pre><hr />' . ++$GLOBALS['FON']['traceCount'] . '<hr />';

    if(empty($file)) {
        echo $str;
    } else {
        flog($str, $file, true);
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

function filterUtf8($str)
{
    /*utf8 编码表：
    * Unicode符号范围           | UTF-8编码方式
    * u0000 0000 - u0000 007F   | 0xxxxxxx
    * u0000 0080 - u0000 07FF   | 110xxxxx 10xxxxxx
    * u0000 0800 - u0000 FFFF   | 1110xxxx 10xxxxxx 10xxxxxx
    *
    */
    $re = '';
    $str = str_split(bin2hex($str), 2);
    
    $mo =  1<<7;
    $mo2 = $mo | (1 << 6);
    $mo3 = $mo2 | (1 << 5);         //三个字节
    $mo4 = $mo3 | (1 << 4);          //四个字节
    $mo5 = $mo4 | (1 << 3);          //五个字节
    $mo6 = $mo5 | (1 << 2);          //六个字节
    
    for ($i = 0; $i < count($str); $i++) {
        if ((hexdec($str[$i]) & ($mo)) == 0) {
            $re .=  chr(hexdec($str[$i]));
            continue;
        }
        
        //4字节 及其以上舍去
        if ((hexdec($str[$i]) & ($mo6) )  == $mo6) {
            $i = $i +5;
            continue;
        }
        
        if ((hexdec($str[$i]) & ($mo5) )  == $mo5) {
            $i = $i +4;
            continue;
        }
        
        if ((hexdec($str[$i]) & ($mo4) )  == $mo4) {
            $i = $i +3;
            continue;
        }
        
        if ((hexdec($str[$i]) & ($mo3) )  == $mo3 ) {
            $i = $i +2;
            if (((hexdec($str[$i]) & ($mo) )  == $mo) &&  ((hexdec($str[$i - 1]) & ($mo) )  == $mo)  ) {
                $r = chr(hexdec($str[$i - 2])).
                chr(hexdec($str[$i - 1])).
                chr(hexdec($str[$i]));
                $re .= $r;
            }
            continue;
        }
        
        if ((hexdec($str[$i]) & ($mo2) )  == $mo2 ) {
            $i = $i +1;
            if ((hexdec($str[$i]) & ($mo) )  == $mo) {
                $re .= chr(hexdec($str[$i - 1])) . chr(hexdec($str[$i]));
            }
            continue;
        }
    }
    return $re;
}

function filterJsonEncodeError($data) {
    $fun = function($str) {
        return mb_convert_encoding($str, "UTF-8", "UTF-8");
    };
    if(!empty($data) && is_array($data)) {
        return array_map($fun, $data);
    }
    return $fun($data);
}

if(!function_exists("array_column")) {
    function array_column($array, $column_name) {
        return array_map(
            function($element) use($column_name) {
                return $element[$column_name];
            }
            , $array
        );
    }
}

/**
 * 针对二维数组的某个字段的中文排序
 * @param  [type] $arr  [description]
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function arrayMultiSort($arr, $name, $changeKey = true){
    $charter = function($str) {
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});  
        $s1=iconv('UTF-8','gb2312',$str);  
        $s2=iconv('gb2312','UTF-8',$s1);  
        $s=$s2==$str?$s1:$str;  
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return $str{0};
    };
    $newarr = array();
    foreach($arr as $key => $val){        
        $str = $val[$name];
        $num = ceil(strlen($str)/3)+1;    
        $k = ''; $n = 0;
        for($i=0; $i<=$num; $i++){        
            $m = substr($str, $i*3 - $n*2,3);
            if(!eregi("[^\x80-\xff]","$m")){    
                $str1 = substr($str,$i*3-$n*2,3);
                $k = $k . $charter($str1);
            }else{
                $m = substr($str, $i*3-$n*2, 1);
                $k = $k . $m;                
                $n++;                    
            }
        }
        $kj = 0;
        while(isset($newarr[$k.$kj])) { $kj++; }
        $newarr[$k.$kj] = $val;
    }
    ksort($newarr);                      
    return $changeKey ? array_values($newarr) : $newarr; 
}