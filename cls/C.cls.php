<?php
namespace F;
class C {
	private static $_n; // 自身

	private $_r; // redis
	private $_d; // 设置信息

	public static function _n() {
		if(!(self::$_n instanceof self)) {
			self::$_n = new self;
		}
		return self::$_n;
	}

	private function __construct() {
		$this->_r = new \redis();
		$this->_r->connect('127.0.0.1', 6379);
		$this->_d = D::_n();
	}

	public function _c(&$url, &$data) {
		$this->_d->runInit(); // 初始化
		$this->_d->setUrl($url); // 初始化URL
		$this->_d->r_data(json_decode($data, true)); // 初始化请求

		// 更改命令
		$this->_d->c_command($data);
		$command = $this->_d->rg_command();

		// 更改请求数据
		$cfg     = $this->getCallConfig($command);
		$call    = $this->changData($this->_d->rg_data(), $cfg);
		$data    = json_encode($call);

		$this->_d->r_dataAr($call);
		$this->_d->r_data($data);
		$this->_d->r_redisKey($this->_d->redisKey());

		// 返回数据
		//     按照设置的返回
		if(!empty($cfg['result'])) {
			$this->_d->r_needsReturn(true); // 设定需要返回
			$this->_d->r_return($cfg['result']); // 设定返回的数据
			$this->_d->r_returnDesc('指定'); 
			$this->_d->save();
			return self::$_n;
		}
		if($this->_d->cg_callUseSaveAll() || !empty($cfg['useSave'])) {
			$result = $this->_r->get($this->_d->rg_redisKey());
			if(!empty($result)) {
				$this->_d->r_needsReturn(true); // 设定需要返回
				$this->_d->r_return($result); // 设定返回的数据
				$this->_d->r_returnDesc('缓存' . $key); 
				$this->_d->save();
				return self::$_n;
			}
		}

		//     继续调用接口
		$this->_d->r_returnDesc('调用'); 
		return self::$_n;
	}

	public function _r() {
		return $this->_d->rg_needsReturn() ? $this->_d->rg_return() : false;
	}

	public function _s($data) {
		$this->_d->r_return($data); // 设定返回的数据
		$this->_d->r_returnDesc('调用接口');
		$this->_d->save();
	}
	
    private function changData($data, $cfg) {
    	if(empty($cfg)) {
    		return $data;
    	}
    	$data = empty($data) || is_string($data) ? array() : $data;
    	if(is_array($cfg['mdata']) && !empty($cfg['mdata'])) {
    		$data['commandInfo'] = array_merge($data['commandInfo'], $cfg['mdata']);
    	}
    	if(is_array($cfg['rdata']) && !empty($cfg['rdata'])) {
    		$data['commandInfo'] = $cfg['rdata'];
    	}
    	return $data;
    }	

	private function getCallConfig($command) {
		$callConfig = $this->_d->cg_call();
		if(empty($callConfig)) {
			return array();
		}
		return $callConfig[$command] ? $callConfig[$command] : array();
	}
}

// java返回错误时如何显示
// 设置调用的地址
// 设置调用时的参数
// 全局使用已调用的数据
// 展示所有的结果
// 只查看某些结果
// 排除某些结果
// 展示所有的调用过的链接
class D {
	private static $_n;
	private $redis;
	public static function _n() {
		if(!(self::$_n instanceof self)) {
			self::$_n = new self;
		}
		return self::$_n;
	}
	private function __construct() {
		$this->redis = new \redis();
		$this->redis->connect('127.0.0.1', 6379);
	}

	private $c = array(
		'url' => array(
			'sign'   => null,
			'newUrl' => null,
		),
		'callUseSaveAll' => false,
		'call' => array(
			// 'command' => [
			// 	'useSave' => false, // 是否使用缓存的数据
			// 	'show'    => false, // 是否展示返回结果
			// 	'result'  => '', // 请求返回的参数
			// 	'mdata'   => '', // 合并添加请求参数
			// 	'rdate'   => '', // 替换请求参数
			// ]
		),
	);


	private $r = array(
		'url'         => '', // 默认请求的url
		'realUrl'     => '', // 真实请求的url
		'command'     => '', // 请求的命令
		'data'        => '', // 请求的参数
		'dataAr'      => array(), // 请求的参数
		'needsReturn' => false, // 是否需要返回
		'return'      => array(), // 是否需要返回
		'returnDesc'  => '', // 返回的描述
		'redisKey'    => '', // 当前请求的redis key
		'returnAr'    => '', // 返回的数据
		'returnCount' => '', // 返回数据的文字数
	);

	private $m = array(); // 监控的请求
	private $s = array();
	private $filterShow = array();

	public function runInit() {
		$this->r = array();
	}

	public function setUrl(&$url) {
		$this->r['url'] = $url;
		$this->r['realUrl'] = $url;
		// 没有设置的话,就不用继续配置了
		if(empty($this->c['url']['sign']) || empty($this->c['url']['newUrl'])) {
			return $url;
		}
		$this->r['realUrl'] = $url = strpos($url, $this->c['url']['sign']) ? $this->c['url']['newUrl'] : $url;
		return $url;
	}

	public function c_url($sign, $url) {
		$this->c['url']['sign']   = $sign;
		$this->c['url']['newUrl'] = $url;
	}

	// 	'useSave' => false, // 是否使用缓存的数据
	// 	'show'    => false, // 是否展示返回结果
	// 	'result'  => '', // 请求返回的参数
	// 	'mdata'   => '', // 合并添加请求参数
	// 	'rdate'   => '', // 替换请求参数
	
	public function c_call($name, $command, $data = true) {
		if(empty($command)) {
			return ;
		}
		if(is_array($command)) {
			$command = array_filter($command);
			foreach($command as $c) {
				$this->c['call'][$c][$name] = $data;
			}
		}
		$this->c['call'][$command][$name] = $data;
	}

	public function c_command($data) {
		$data = json_decode($data, true);
		if(empty($data) || empty($data['command'])) {
			return '';
		}
		$this->r['command'] = str_replace(array("\\"), array(''), $data['command']);
		return $this->r['command'];
	}

	// 所有只有有内存就都走内存
	public function callUseSaveAll() {
		$this->c['callUseSaveAll'] = true;
	}

	public function __call($name, $arg) {
		if(strpos($name, 'cg_') !== false) {
			$key = substr($name, 3);
			return $this->c[$key];
		}
		if(strpos($name, 'rg_') !== false) {
			$key = substr($name, 3);
			return $this->r[$key];
		}
		if(strpos($name, 'r_') !== false) {
			$key = substr($name, 2);
			$this->r[$key] = $arg['0'];
			return $arg;
		}
    }

    public function redisKey() {
		return $this->r['command'] . '::' . md5(json_encode($this->r['data']));
    }

    public function save() {
    	$this->r['redisKey'] = $this->redisKey();
    	$this->redis->set($this->r['redisKey'], $this->r['return']);
    	$this->r['time'] = time();
    	$this->r['date'] = date('Y-m-d H:i:s', $this->r['time']);

    	$this->s[] = $this->r;
    }

    public function m($commands) {
    	if(empty($commands)) {
			return ;
		}
		$this->m = !is_array($this->m) ? array() : $this->m;
		if(is_array($commands)) {
			$this->m = array_merge($this->m, array_unique($commands));
		} else {
			$this->m[] = $commands;
		}
    }

    public function s($filterShow) {
    	$this->filterShow = $filterShow;
		register_shutdown_function(array($this, 'finalShow'));
	}

	public function finalShow() {
		if(empty($this->s) || empty($this->filterShow['show'])) {
			return;
		}
		$cfg = $this->filterShow;
		$ret = array();
		echo '<pre>';
		$split = "\n" . str_repeat('-', 66) . "\n\n";
		if($cfg['count']) {
			echo '共' . count($this->s). '次调用.' . $split;
		}
		if(!empty($this->m)) {
			echo '监控请求:' . implode(', ', $this->m) . $split;
		}
		$uniqueAr = array();
		$sortinfo = '';
		foreach($this->s as $k => $v) {
			$uniqueAr[$v['command']] += 1;
			$sortinfo .= "[{$v['date']}:{$v['returnDesc']}] {$v['command']} \n";
			$this->s[$k]['returnAr'] = json_decode($v['return'], true);
			$this->s[$k]['returnCount'] = mb_strlen($v['return']);
		}
		if($cfg['unique']) {
			$unique = '';
			arsort($uniqueAr);
			foreach($uniqueAr as $command => $v) {
				$unique .= "[{$v}:{$command}]\n";
			}
			echo $unique . $split;
		}
		if($cfg['sortinfo']) {
			echo $sortinfo . $split;
		}
		if($cfg['detail']) {
			$show = array();
			foreach($this->s as $k => $v) {
		    	if(!empty($this->m) && !in_array($v['command'], $this->m)) {
		    		continue;
		    	}
				foreach($v as $key => $val) {
					if(!in_array($key, $cfg['detail'])) {
						continue;
					}
					$show[$k][$key] = $val;
				}
			}
			empty($show) ? '' : p($show);
		}
	}
}