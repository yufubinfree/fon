<?php
class CurlRequest {
	public function __construct() {
        $this->db     = $GLOBALS['db'];
        $this->smarty = $GLOBALS['smarty'];
    }

    function curlDisplayMM() {
        $url  = base64_decode($_POST['url']);
        $post = json_decode(base64_decode($_POST['postStr']), TRUE);
        ksort($post);

        $names = array();
        $values = array();
        foreach($post as $name => $value) {
            $names[] = $name;
            $values[] = is_array($value) 
                ? json_encode($value)
                : $value;
        }

        unset($_POST);
        $_POST['F__URL']       = $url;
        $_POST['F__POST_VAL']  = $values;
        $_POST['F__POST_NAME'] = $names;

        $this->curlDisplay();
    }

    // 简单的并发请求
    function curlDisplay()
    {
        $url       = trim($_POST['F__URL']); # 请求链接
        $times     = $_POST['F__TIMES'] ? $_POST['F__TIMES'] : 1; # 请求次数
        $time_out  = $_POST['F__TIME_OUT'] ? $_POST['F__TIME_OUT'] : 3600;

        $is_end = $_POST['F__REALPOST'] <> 'F__REALPOST';
        # 超时时间
        $table = TTable::getInstance();
        $table->setTable(array(
            'action'    => '/ftools/CurlRequest/curlDisplay.app',
            'title'     => '请求模拟',
            'hide'      => !$is_end,
        ));
        $table->table('hidden', array( 
            'tag_name' => '是否真实提交:',
            'name'     => 'F__REALPOST',
            'value'    => 'F__REALPOST',
        ));
        $table->table('input', array( 
            'tag_name' => '链接:',
            'name'     => 'F__URL',
            'value'    => $url,
            'css'      => array(
                'width'     => '99%',
                'height'    => '36px',
                'font-size' => '25px',
            ),
        ));
        $table->table('input', array( 
            'tag_name' => '次数:',
            'name'     => 'F__TIMES',
            'value'    => $times,
        ));
        $table->table('input', array( 
            'tag_name' => '超时:',
            'name'     => 'F__TIME_OUT',
            'value'    => $time_out,
        ));
        $table->table('input_add_ar', array( 
            'tag_name' => 'POST:',
            'name'  => array(
                'F__POST_NAME' => '名称',
                'F__POST_VAL'  => '数值',
            ),
            'value' => array(
                'F__POST_NAME' => $_POST['F__POST_NAME'],
                'F__POST_VAL'  => $_POST['F__POST_VAL'],
            ),
        ));
        

        echo $table->fetch();
        if($is_end) {
            return;
        }

        # 设定POST    
        $postData = array();
        foreach($_POST['F__POST_NAME'] as $k => $v) {
            $val       = $_POST['F__POST_VAL'][$k];
            $json      = json_decode(stripslashes($val), true);
            $real_vale = empty($json) ? $val : $json;
            $postData[$v]  = $real_vale;
        }
        if(empty($url) || empty($times) || empty($time_out)) {
            die('基本信息有误,请重新填写!');
        }

        $curl = TCurl::getInstance();
        $curl->setConfigAr(array(
            'url'     => $url,
            'showAll' => TRUE,
            'cookie'  => TRUE,
            'timeOut' => $time_out,
        ));
        $curl->setPost($postData);
        $ret = $curl->execSame($times);

        $data = array();
        foreach($ret as $key => $v) {
            $json_ret = json_decode($v['ret'], true);

            $idName   = 'cache_curlShowHtml' . $key;
            $backCon = !empty($json_ret) 
                ? print_r($json_ret, true) 
                : $v['ret'];
            $wName = $idName  . '.html';
            Tools::writeToSmatyCacheTempFile($wName, $backCon);
            $data[] = array(
                'url'   => FIXURLMain . '\\Tools\\templates\\templates_c\\' . $wName,
                'idName' => $idName,
            );
        }

        $this->smarty->assign('infoData', $data);
        $this->smarty->display('CurlRequest.htm');
        die();
    } 
}