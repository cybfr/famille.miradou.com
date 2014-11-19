<?php
/**
 * Enter description here ...
 * @author fvuillemin
 *
 */
class Member {
	public $id = 'visitor';
	public $firstname = '';
	public $lastname = '';
	public $order = 14;
	public $fbId = 0;
	public $email = '';
	public $spouse;
	private $password = '';
	public $pictureIdx = 0;
	public $isDead = 0;
	function checkPassword($password) {
		if ($password === $this->password) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function getPassword() {
		return ($this->password);
	}
	function SetPassword($password) {
		$this->password = $password;
		$query = "UPDATE `famille`.`membres` SET `password` = '{$this->password}' WHERE `membres`.`id` = '$this->id'";
		return (mysql_query ( $query ));
	}
	/**
	 * Enter description here .
	 *
	 * ..
	 *
	 * @param unknown_type $firstname        	
	 */
	function __construct(array $member) {
		$this->id = 'visitor';
		foreach ( $member as $key => $value ) {
			$this->$key = $value;
		}
	}
	public function __toString() {
		return $this->id;
	}
	function SetSpouse($spouse) {
		$this->spouse = $spouse;
	}
	function GetSpouse() {
		return ($this->spouse);
	}
}
?>
