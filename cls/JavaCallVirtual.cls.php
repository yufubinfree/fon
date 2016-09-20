<?php
namespace FON;

/**
 * 模拟 PHP JAVA调用的类
 * 
 * if(\FON\J::getInstance()->changeCall($apiUrl, $data, $option)->neesReturn()) { return \FON\J::getInstance()->getReturn(); }
 * \FON\J::getInstance()->curlBackShow($apiUrl, $data, $response);
 */
class J extends FonBase
{
	private static $_instance; # 对象的单例
	private $_return; # 需要返回给接口调用的数据
	private $_show; # 是否显示查看数据
	private $_times          = 0; # 调用的次数信息
	private $_callData       = array(); # 每次调用信息的记录保存
	private $_monitor        = array(); # 需要监控的命令
	private $_callMData      = array(); # 监视的调用记录信息
	private $_configCall     = array(); # 调用的配置
	private $_selfBackReturn = array(); # 自定义返回了的规则
	private $_allConfig      = array();
	private $_callUrl        = ''; // 全局变更的调用链接
	protected $_dataPath     = '/fon/cfg/JConfig/data';	

	# 请求保存设置
	protected $_saveAll      = false; # 是否保存全部的请求
	protected $_saveResult   = array(); # 保存哪些请求

	# 在请求结束后才有结果
	protected $_data_url     = ''; # 真实请求的URL
	protected $_ret_ar       = array();  # 请求返回解压出的数组
	protected $_ret_str      = ''; # 请求返回的字符串
	protected $_data_ar      = array(); # 请求解压的数组
	protected $_data_str     = ''; # 请求的字符串
	protected $_data_command = ''; # 请求的命令

	protected $_useSave       = false; # 是否使用保存的结果作为返回 只有保存过的数据才能使用
	protected $_useSaveResult = ''; # 保存的数据
	protected $_useSaveKey    = array(); # 需要使用文件的命令

	protected $_msg          = ''; # 显示结果时,需要用户看到的信息

	public function setUseSaveAll() {
		$this->_useSave = true;
	}

	public function setUseSave($save) {
		$this->_useSaveKey[$save] = true;
	}

	public function useSave($command, $data) {
		$name = $this->_dataPath . '/' . str_replace('/', '_', $command) . '__' . md5($data);
		$ret = file_get_contents($name, $this->_ret_str);

		$this->_useSaveResult = $ret;

		return !empty($ret);
	}

	public function setSaveAllResult() {
		$this->_saveAll = true;
	}

	public function setSaveResult($command) {
		if(empty($command)) {
			return;
		}
		$this->_saveResult[$command] = true;
	}


	public function setCallUrl($url) {
		$this->_callUrl = $url;
	}

	public function setAllUrl($name, $value) {
		if(empty($name)) {
			return;
		}
		$this->_allConfig[$name] = $value;
	}

	public function __construct() {
		if(self::$_instance && $this !== self::$_instance) {
			die('请使用getInstance获取此对象');
		}
		self::$_instance = $this;

		$this->changeUrl = JConfig::getInstance()->getJavaCallChangeData();
	}

	public function save() {
		# 验证是否保存
		if(!$this->_saveAll # 全部保存不判断
			&& !$this->_saveResult[$this->_data_command]) {
			return;
		}

		# 验证结果是否需要保存
		if(empty($this->_ret_ar)) {
			return;
		}

		$name = $this->_dataPath . '/' . str_replace('/', '_', $this->_data_command) . '__' . md5($this->_data_str);
		file_put_contents($name, $this->_ret_str);
	}

	public static function getInstance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self;
		}
		# 清除之前的日志

		return self::$_instance;
	}

	public function neesReturn() {
		return !empty($this->_return);
	}

	public function getReturn() {
		$return = $this->_return;
		$this->_return = null;

		return $return;
	}

	public function changeCall(&$url, &$dataOri, &$option) {
		$data = json_decode($dataOri, true);

		if(($this->_useSave || $this->_useSaveKey[$data['command']]) && $this->useSave($data['command'], $dataOri)) {
			# 返回设定的信息
			$this->_return = $this->_useSaveResult;
			$this->_selfBackReturn[] = $data['command'];
			$this->curlBackShow('配置系统返回', json_encode($data), $this->_return);
			return self::$_instance;
		}

		# 全局的修改
		if(!empty($this->_callUrl)) {
			$url = $this->_callUrl;
		}

		if(!empty($this->_allConfig)) {
			foreach ($this->_allConfig as $key => $value) {
				$data[$key] = $value;
			}
			$dataOri = json_encode($data);
		}

        # 没有匹配的就让他去吧
		if(empty($data['command']) || !array_key_exists($data['command'], $this->changeUrl)) {
			return self::$_instance;
		}

        # 有匹配的就做些相应的处理吧.
		$config = $this->changeUrl[$data['command']];
		$command = $data['commandInfo'];
		$realDataOri = $data;

		# 根据指定的值返回不同的结果
		if(isset($config['#C']) && !empty($config['#C']) && is_array($config['#C'])) {
			foreach($config['#C'] as $retChose => $eval)	{
				eval('$useNew = ' . $eval . ' ? true : false;');
				if($useNew) {
					$config['ret'] = $config[$retChose];
				}
			}
		}

		# 验证配置文件
		$configRet = json_decode($config['ret'], true);
		if(!empty($config['ret']) && empty($configRet)) {
			# 返回设置错误!
			die('配置文件返回值设置错误!不是JSON!' . "<br />\n" . $config['ret']);
		}

        # host处理
		if(isset($config['host'])) {
			$url = $config['host'];
		}

        # token处理
		if(isset($config['token'])) {
			$data['token'] = urldecode(trim($config['token'])); # 累次%7C[就是|]这类的JAVA那边不会自动转化
		}
		if(isset($config['commandInfo'])) {
			foreach ($config['commandInfo'] as $k => $v) {
				$data['commandInfo'][$k] = $v;
			}
		}

		# 返回设定的信息
		if(isset($config['ret'])) {
			$this->_return = $config['ret'];
			$this->_selfBackReturn[] = $data['command'];
			$this->curlBackShow('配置系统返回', json_encode($data), $this->_return);
		}

		$dataOri = json_encode($data);

		return self::$_instance;
	}

	/**
	 * 显示
	 * @param  [type] $apiUrl   调用JAVA的URL
	 * @param  [type] $data     调用JAVA的DATA
	 * @param  [type] $response JAVA返回的数据
	 * 
	 * @return [type]           [description]
	 */
	function curlBackShow($apiUrl, $data, $response) {
		# 返回的数据更新对象
		$this->_data_url     = $apiUrl;
		$this->_ret_ar       = json_decode($response, true);
		$this->_ret_str      = $response;
		$this->_data_ar      = $data_ar = json_decode($data, true);
		$this->_data_str     = $data;
		$this->_data_command = $data_ar['command'];

		$ret = array(
			'Command'    => $data_ar['command'],
			'Host'       => $apiUrl,
			'CallJson'   => $data,
			'CallAr'     => $data_ar,
			'Response'   => $response,
			'ResponseAr' => json_decode($response, true),
		);

		# 保存返回的结果
		$this->save();
		if(!empty($this->_useSaveResult)) {
			array_unshift($ret, '<h3 style="color:red; text-align:center;">自定义文件使用: ' . $this->_dataPath . '/' . str_replace('/', '_', $this->_data_command) . '__' . md5($data) . '</h1>');
		}

		# 高亮自定义返回的	
		if(in_array($data_ar['command'], $this->_selfBackReturn)) {
			array_unshift($ret, '<h3 style="color:red; text-align:center;">自定义的返回: ' . $data_ar['command'] . '</h1>');
		}

		$this->_callData[] = $ret;

		if(isset($this->_monitor[$data_ar['command']])) {
			$this->_callMData[] = $ret;
		}
	}

	function __destruct() {
		if(!$this->_show) {
			return;
		}

		if(!empty($this->_callMData)) {
			return $this->_showFormat($this->_callMData);
		}
		$data = empty($this->_monitor) ? $this->_callData : $this->_callMData;

		if(!empty($data)) {
			$this->_showFormat($data);
		}
	}

	function _showFormat($data) {
		pp($data);
	}

	/**
	 * monitor 监视一个命令
	 * @param  string $command [需要监视的命令]
	 * @param  array  $cfg     [一些可能有的监视设置]
	 * @return [type]          [description]
	 */
	function m($command = '', $cfg = array()) {
		if(empty($command)) { 
			return; 
		}

		$this->_show = true;
		$this->_monitor[$command] = $cfg;
	}

	/**
	 * show 是否展示头信息
	 * @return [type] [description]
	 */
	function s() {
		$this->_show = true;
	}
}