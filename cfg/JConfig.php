<?php
namespace FON;

/**
 * 
 */
class JConfig {
	private static $_instance;
	private $_JavaCallChangeConfigPath;
	private $_JavaCallChangeConfig;
	private $_host;

	# 一些基本的数据配置
	private $_config = array(
		'Host' => array(
			'BjHost' => 'http://106.184.2.121:8080',
		),
		'Token' => array(
			'1' => '', # 后台的默认Token
			'2' => '14386|108cbd393cc7cf1e1f07bb39e485a6d2', # 前台的默认Token
		),
	);

	public function __construct() {
		if(self::$_instance && $this !== self::$_instance) {
			die('请使用getInstance获取此对象');
		}
		$this->_JavaCallChangeConfigPath = F_CONFIG . '/JConfig/';

		# 初始化一些操作
		$this->_host = $this->_config['Host']['BjHost']; # 设置默认调用的Host

		self::$_instance = $this;
	}

	public static function getInstance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	# JAVA调用的数据的规则获取
	public function getJavaCallChangeData() {
		if(!empty($this->_JavaCallChangeConfig)) {
			return $this->_JavaCallChangeConfig;
		}
		foreach (scandir($this->_JavaCallChangeConfigPath) as $fileName) {
		    if(strpos($fileName, 'Config.php') === false) {
		        continue;
		    }

		    require($this->_JavaCallChangeConfigPath . $fileName);
		}

		return $this->_JavaCallChangeConfig;
	}

	/**
	 * 设定JavaCallChange的基本数据
	 * @param string  $command [调用的功能名]
	 * @param array   $data    [调用需要修改的数据]
	 * @param array   $config  [调用的配置信息]
	 *     host  => '', # 请求的Host 默认北京
	 *     #T    => 0,  # 调用默认配置的Token 0:不修改 1:后台 2:前台
	 *     ret   => mix, # 设置的话就不去调用,直接返回ret的值
	 *     #C    => array('返回设置中的KEY'=>"需要eval比对的值"), 目前data就是获取到的参数
	 */
	public function setJCCConfig($command = '', $data = array(), $config = array()) {
		if(!empty($config['host'])) {
			$this->_host = $config['host'];
		}

		# 验证设置时可能有的坑点
		if(isset($config['commandInfo'])) {
			die('JacaCallVirtual: ' . $command . '的commandInfo不允许配置!');
		}

		$configData = $config;
		$configData['host'] = empty($configData['host']) ? $this->_host : $configData['host'];

		if(!empty($data)) {
			$configData['commandInfo'] = $data;
		}

		if($config['token']) {
			$configData['token'] = $config['token'];
		}

		$this->_JavaCallChangeConfig[$command] = $configData;
	}
}