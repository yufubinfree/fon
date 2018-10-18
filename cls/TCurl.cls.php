<?php
class TCurl {
	private static $_instance;
    private $cookie; # 保存Cookie用的字符串
    private $curl; # 类所使用的CURL
    private $batchCurl = array(); # 批量请求源数据
    private $post   = array(); # 需要POST的信息

    private $config = array(
        'url'        => '', # 调用的URL
        'timeOut'    => 60, # 超时时间
        'header'     => 0,  # 是否将头信息作为数据流输出
        'retStr'     => TRUE, # 将返回作为文件流格式返回,而不是直接输出
        'follow'     => TRUE, # 跟随重定向
        'nobody'     => FALSE, # 启用时将不对HTML中的BODY部分输出
        'showAll'    => FALSE, # 是否显示所有返回数据
        'cookie'     => FALSE, # 是否携带COOKIE
        'httpheader' => array(), # 头信息 ["Content-Type: text/xml; charset=utf-8","Expect: 100-continue"]
        'rest'       => null, # 是否是rest请求
        'userpwd'    => null, # 用户名和密码
    );
    var $result = array(
        'finish'   => FALSE, # 请求是否已完成
        'info'     => '', # 返回的info信息
        'result'   => '', # 返回的结果信息保存
    ); # 请求返回的结果信息

	public function __construct($url='', $config=array(), $post=array()) {
		self::$_instance = $this;

        $this->config['url'] = $url;
        if(!empty($config)) {
            foreach($config as $k => $v) {
                $this->config[$k] = $v;
            }
        }
        $this->post = $post;
	}

	public static function getInstance() {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function setConfig($name, $value) {
        $this->config[$name] = $value;
    }

    public function getConfig($name) {
        return $this->config[$name];
    }

    public function setConfigAr($data = array()) {
        if(empty($data)) {
            return ;
        }
        foreach($data as $k => $v) {
            $this->config[$k] = $v;
        }
    }

    public function getConfigAll($name) {
        return $this->config;
    }

    public function setPost($data = array()) {
        $this->post = $data;
    }

    public function getPost() {
        return $this->post;
    }

    public function reset() {
        $this->curl->curl_reset();
    }
    /**
     * 使得生成的Curl请求支持CookIe
     */
    public function getCookie()
    {
        $ret = array();
        foreach($_COOKIE as $key => $val) {
            $ret[] = "{$key}={$val}";
        }

        $ret = implode('; ', $ret);
        return $ret;
    }

    public function curlInit() {
        $curl   = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $this->config['url'],
            CURLOPT_TIMEOUT        => $this->config['timeOut'],
            CURLOPT_HEADER         => $this->config['header'], 
            CURLOPT_RETURNTRANSFER => $this->config['retStr'],
            CURLOPT_FOLLOWLOCATION => $this->config['follow'],
            CURLOPT_HTTPHEADER     => $this->config['httpheader'],
            CURLOPT_NOBODY         => $this->config['nobody'],
            CURLOPT_POST           => !empty($this->post) && strtoupper($this->config['rest']) != 'POST',
            CURLOPT_POSTFIELDS     => is_array($this->post) 
                ? http_build_query($this->post)
                : $this->post,
            CURLOPT_COOKIE         => $this->config['cookie'] ? $this->getCookie() : '',
            CURLOPT_CUSTOMREQUEST  => $this->config['rest'],
            CURLOPT_USERPWD        => $this->config['userpwd'],
        ));
        return $curl;
    }

    /**
     * 将当前的请求加入批量请求中
     */
    public function addBatchCurl() {
        $this->batchCurl[] = $this->curlInit();
    }

    /**
     * 批量运行并发请求并返回结果
     */
    function execMore(){ 
        $multi_handle = curl_multi_init(); 

        # 构建请求
        $curl_array = array(); 
        foreach($this->batchCurl as $v) {
            curl_multi_add_handle($multi_handle, $v); 
        } 

        $running = 1; 
        while($running) {
            usleep(10000); 
            curl_multi_exec($multi_handle, $running); 
        }
         
        $res = array(); 
        foreach($this->batchCurl as $key => $source) 
        { 
            $res[$key] = array(
                'ret'    => curl_multi_getcontent($source), 
                'key'    => $key,
                'result' => curl_getinfo($source), # 取状态码
            );
            curl_multi_remove_handle($multi_handle, $source); 
            curl_close($source);
        } 
        curl_multi_close($multi_handle);         

        return $res; 
    } 

    /**
     * 多次请求相同的链接
     * @param  integer $times [description]
     * @return [type]         [description]
     */
    public function execSame($times = 1) {
        for($i = 0; $i<$times; $i++) {
            $this->addBatchCurl();
        }

        $this->result = $this->execMore();

        $result = array();
        if(!$this->config['showAll']) {
            foreach($this->result as $v) {
                $result[$v['key']] = $v['ret'];
            }
        } else {
            $result = $this->result;
        }

        return $result;
    }

    public function execOne() {
        $curl = $this->curlInit();

        $ret    = curl_exec($curl);
        $info   = curl_getinfo($curl);
        $result = array(
            'finish'   => TRUE,
            'info'     => $info,
            'ret'      => $ret,
            'post'     => $this->post,
        );

        $this->result = $result;
        curl_close($curl);

        return $this->config['showAll'] ? $result : $result['ret'];
    }
}