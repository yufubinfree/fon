<?php
class S extends Smarty {
	public static $_instance;

	public function __construct() {
		if(self::$_instance instanceof self) {
			return self::$_instance;
		}

		$this->SmartyConfig();

		self::$_instance = $this;
	}

	private function SmartyConfig() {

	}
	
	public static function getInstance() {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }

        return self;
    }
}