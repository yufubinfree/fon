<?php
require('./init.php'); # 初始化

class Main {
	private $class;
	private $action;

	public function __construct() {
		if(empty($_REQUEST['r'])) {
			die('无效的路由参数!');
		}
		list($this->class, $this->action) = array(
			$this->fixName(reset(explode('/', $_REQUEST['r']))), 
			$this->fixName(end(explode('/', $_REQUEST['r'])))
		);
	}

	public function main() {
		// 获取跑的结果
		$obj    = new $this->class;
		$ret = call_user_method($this->action, $obj);

		echo $this->getHeader() . $ret . $this->getFooter();
	}

	/**
	 * 根据"-"的分割来首字母大写
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	public function fixName($str) {
		return implode('', array_map('ucfirst', explode('-', $str)));
	}

	public function getHeader() {
		return require(F_VIEW . 'header.php');
	}	

	public function getFooter() {
		return require(F_VIEW . 'footer.php');
	}
}

$main = new Main();

try{
	$main->main();
} catch(Exception $e) {
	v($e);
}
