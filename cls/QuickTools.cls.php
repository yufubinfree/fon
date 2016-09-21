<?php
class QuickTools  {
    public $ttable;

    public function __construct() {}

	function randWords() {
        if(empty($_POST)) {
            v('a');
        }

		$useStr = trim($_REQUEST['useStr']);
		$legth  = (int) $_REQUEST['legth'];

        $str = preg_replace('/[\s\r\t\n]/', '', $useStr);
        $count = strlen($str) - 1;

        $ret = '';
        mt_srand();
        for($i=0; $i<$legth; ++$i) {
        	$k = mt_rand(0, $count-1);
        	$ret .= $str[$k];
        }

        echo Tools::print_ar(array(array(
        	'消息' => $ret,
        )));
	}

    function QrShow() {
        $ret = S::getInstance();

        v($ret);


        $tag = trim($_REQUEST['data']);
        $this->ttable->setTable(array(
            'action'    => '/ftools/' . __CLASS__ . '/' . __FUNCTION__ .'.app',
            'title'     => '扫码展示',
            'alert'     => '通过英文","来分割信息',
            'hide'      => !empty($tag),
            'method'    => 'method',
        ));
        $this->ttable->table('textarea', array(
            'tag_name' => '数据',
            'name'     => 'data',
            'value'    => $tag,
            'css'      => array(
                'width'  => '90%',
                'height' => '300px',
            ),
        ));
        if(!$tag) {
            echo $this->ttable->fetch();
            exit;
        }

        $body = $this->ttable->fetch(true);

        $data = explode(',', $tag);
        $pdata = array();
        foreach($data as $v) {
            // $v = trim($v);
            $pdata[] = array(
                '数据'   => $v,
                '二维码' => "<img src='http://images.meilele.com/admin/qr_code_show.php?qr={$v}' style='width:100px;height:100px; margin-top:80px; margin-bottom:50px;' alt='{$v}'>" , 
                '一维码' => "<img src='http://images.meilele.com/api/barcode.php?code=code39&f1=-1&thickness=20&resolution=3&text={$v}' style='max-width:300px;' alt='{$v}'>",
            );
        }

        $body .= $this->tools->print_ar($pdata);

        $this->tsmarty->setTitle('扫码展示');
        $this->tsmarty->setBody($body);
        $this->tsmarty->display();
    }

    

    function quickDiff() {
        $more = Tools::get_array_back($_POST['more']);
        $less = Tools::get_array_back($_POST['less']);
        
        $this->ttable->setTable(array(
            'action'    => '/ftools/' . __CLASS__ . '/' . __FUNCTION__ .'.app',
            'title'     => '比对工具',
            'alert'     => $msg,
            'hide'      => !empty($_POST),
        ));
        $this->ttable->table('textarea', array(
            'tag_name' => '数据A:',
            'name'     => 'more',
            'value'    => $_POST['more'],
            'css'      => array(
                'width'  => '85%',
                'height' => '300px',
            ),
        ));
        $this->ttable->table('textarea', array(
            'tag_name' => '数据B:',
            'name'     => 'less',
            'value'    => $_POST['less'],
            'css'      => array(
                'width'  => '85%',
                'height' => '300px',
            ),
        ));
        
        if(!$_POST) {
            echo $this->ttable->fetch();
            exit;
        }

        $body = $this->ttable->fetch(false);

        $ab = array_diff($more, $less);
        $ba = array_diff($less, $more);
        $aandb = array_intersect($less, $more);

        $abc = array_merge($ab, $ba);
        $body .= '<pre>';
        $body .= Tools::print_ar(array(
            array(
                'DIFF'  => print_r($abc, true),
                'A > B' => print_r($ab, true),
                'B > A' => print_r($ba, true),
                'A & B' => print_r($aandb, true),
            ),
        ));
        $body .= '</pre>';
        
        $this->tsmarty->setTitle('通用发版工具');
        $this->tsmarty->setBody($body);
        $this->tsmarty->display(); 
    }
}