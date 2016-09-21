<?php
/**
 * 一般工具类接口与抽象类存放点
 */


interface IFinstance {
    // const abc = 'abc';
    static public function getInstance();
}

interface IFcommonTools {
    public function setConfig();
    public function getConfig();
    public function setConfigAr();
    public function getConfigAr();
}

abstract class ABcommonUse{
    public $smarty;
    
    public function __construct() {
        $this->ttable = Ttable::getInstance();
        $this->smart  = new smarty();
    }

    // 清除smarty的变量设置
    public function cleanSmt() {
        $this->smarty->tpl_vars = array();

        return true;
    }

    public function msg($msg) {
        die(Tools::print_ar(array(array(
            '消息' => $msg,
        ))));
    }

    function checkPriv($mark = '', $url = '', $password = '', $title = '', $tag = '', $say = '') {
        $mark     = $mark ? $mark : 'FON_IS_NB';
        $password = self::$passwordStore[$mark] ? self::$passwordStore[$mark] : 'VojRaExAcMzcAgdGg0fz';
        $url      = $url ? $url : "/ftools/{$_REQUEST['fon__model']}/{$_REQUEST['fon__action']}.app";
        if($_COOKIE[$mark] == $password) {
           return;
        }
        $ttable = TTable::getInstance();
        $ttable->setTable(array(
            'name'   => 'myform',
            'title'  => $title ? $title : '考验你的时候到了!',
        ));
        $ttable->table('hidden', array(
            'name'     => 'submyanswer',
            'value'    => 'submyanswer',
        ));
        $ttable->table('hidden', array(
            'name'     => 'url',
            'value'    => $url,
        ));
        $ttable->table('input', array(
            'tag_name'    => $tag ? $tag : '小工具是不是很牛逼?',
            'name'        => 'answer',
            'value'       => '',
            'placeholder' => $say ? $say : $mark,
            'css'      => array(
                'height'    => '30px',
                'font-size' => '28px',
                'width'     => '98%',
            ),
        ));

        $body = $ttable->fetch(false);
        if($_REQUEST['submyanswer'] == 'submyanswer') {
            if(trim($_REQUEST['answer']) == $password) {
                setCookie($mark, $password, time()+60*60*24*30, '/', '.meilele.com');
                unset($_POST, $_REQUEST, $_GET);
                header("Location: {$url}");
            }
            $body .= '<hr /><h1>回答错误啦!</h1>'; 
        }
        $this->tsmarty->addBody($body);
        $this->tsmarty->display();
    }
}