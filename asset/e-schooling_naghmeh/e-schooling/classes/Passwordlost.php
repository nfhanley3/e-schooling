<?php 
class Passwordlost {
	private $_db = null;
	
	public function __construct() {
		$this->_db = Database::getInstance();
	}
	
	public static function check($email){
		if ($email){
			$check = $this->_db->get('users', array())
		}
	}
}