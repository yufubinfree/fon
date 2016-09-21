<?php
/**
 * GET过来的名字fonShowPageNum就是当前需要显示的页面
 */
class PageSplit extends ABcommonUse implements IFinstance {
	const tpl = 'PageSplit.htm';

	private static $_instance;
	private $defaultPerPage = 20; # 默认每页显示数
	private $pagekey = 'fonShowPageNum';
	private $pageInfo = array(
		'page'           => 1, # 当前页
		'perpage'        => 20, # 每页显示数
		'totalpage'      => 0, # 总页数
		'totalnum'       => 0, # 总条数
		'pagechosenum'   => 6, # 选择页数的个数
		'pagechosestart' => 0, # 选择页数的开始页数
		'pagechoseend'   => 0, # 选择页数的结尾页数
		'showFirstPage'  => false, # 显示选择第一页
		'showEndPage'    => false, # 显示选择最后一页
	);
	private $config = array(
		'setTotal' => true,
		'showhead' => true,
		'showend'  => true,
	);

	public function __construct() {
		parent::__construct();
		# 只允许有一个实例
		if(is_object(self::$_instance)) {
			$trace = Tools::trace(1);	
			die(__CLASS__ . "只能被实例化一次![{$trace['file']}:{$trace['line']}]");
		}
		self::$_instance = $this;
		
		$this->defaultSet();	
	}

	public static function getInstance() {
        if(!(self::$_instance instanceof self)) {
			self::$_instance = new self;
		}

		return self::$_instance;
    }	

	private function defaultSet() {
		$pagekey = $this->pagekey;
		$perpage = intval($_COOKIE['FONPAGESPLITPREPAGE'])
			? intval($_COOKIE['FONPAGESPLITPREPAGE'])
			: $this->defaultPerPage;
		if(!intval($_COOKIE['FONPAGESPLITPREPAGE'])) {
			$this->setPrePageNum($this->defaultPerPage);
		}

		$this->pageInfo['page']    = max(intval($_REQUEST[$this->pagekey]), 1);
		$this->pageInfo['perpage'] = $perpage;
	}

	public function setPrePageNum($num) {
		if(empty($num)) {
			return false;
		}

		return setCookie('FONPAGESPLITPREPAGE', $num, time()+60*60*24*30, '/', '.meilele.com');
	}

	# 设定分页总数
	public function setTotal($num) {
		$page         = $this->pageInfo['page'];
		$prepage      = $this->pageInfo['perpage'];
		$pagechosenum = $this->pageInfo['pagechosenum'];

		$totalpage = max(intval(ceil($num/$prepage)), 1);
		$page      = $page > $totalpage ? $totalpage : $page;

		$startpage = max(1, $page - $pagechosenum);
		$endpage   = min($totalpage, $startpage + $pagechosenum*2 - 1);
		$startpage = min($startpage, $endpage - $pagechosenum*2 + 1);
		$startpage = $startpage < 1 ? 1 : $startpage;

		$showPageAr = range($startpage, $endpage);

		$this->pageInfo['page']           = $page;
		$this->pageInfo['totalpage']      = $totalpage;
		$this->pageInfo['totalnum']       = $num;
		$this->pageInfo['pagechosestart'] = $startpage;
		$this->pageInfo['pagechoseend']   = $endpage;
		$this->pageInfo['showFirstPage']  = $startpage > 2;
		$this->pageInfo['showEndPage']    = $endpage < $totalpage;
		$this->pageInfo['showPageAr']     = $showPageAr;
		$this->pageInfo['href']           = $_SERVER['SCRIPT_URL'];
	}

	public function getPageInfo() {
		return $this->pageInfo;
	}

	public function fetch() {

		$this->smarty->assign('pageInfo', $this->pageInfo);
		$this->smarty->assign('type', 'pageSplitStr');
		// $this->smarty->assign('');

		return $this->smarty->fetch(self::tpl);
	}
}