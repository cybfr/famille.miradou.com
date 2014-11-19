<?php
/**
 * Enter description here ...
 * @author fvuillemin
 *
 */
require "Member.php";
class BaseFamily {
	protected $members;
	function __construct() {
		include 'include/mysqlsecrets.php';
		$this->link = mysql_connect ( $server, $username, $password ) or die ( "Impossible de se connecter : " . mysql_error () );
		mysql_query ( "SET NAMES 'utf8'" );
		$query = "SELECT * FROM `famille`.`membres` WHERE  `isDead` = 0 ORDER BY `membres`.`order` ASC";
		$result = mysql_query ( $query );
		while ( $member = mysql_fetch_assoc ( $result ) ) {
			$this->members [$member ['id']] = new Member ( $member );
		}
	}
	function getMembers() {
		return ($this->members);
	}
	/**
	 *
	 * @param string $firstname        	
	 */
	function getMemberByFirstName($firstname) {
		foreach ( $this->members as $member ) {
			if ($member->firstname == $firstname)
				return ($member);
		}
		return (false);
	}
	function getMemberByfbId($firstname) {
		foreach ( $this->members as $member ) {
			if ($member->fbId == $firstname)
				return ($member);
		}
		return (false);
	}
	function getMemberById($firstname) {
		foreach ( $this->members as $member ) {
			if ($member->id == $firstname)
				return ($member);
		}
		return (false);
	}
	function getMemberByMail($mailAddr) {
		foreach ( $this->members as $member ) {
			if ($member->email != "" && $member->email == $mailAddr)
				return ($member);
		}
		return (false);
	}
	/**
	 * Enter description here .
	 * ..
	 */
	function storeFamily() {
		$query = "CREATE TABLE  `famille`.`membres` (
				`id` VARCHAR( 32 ) NOT NULL ,
				`firstname` VARCHAR( 32 ) NOT NULL ,
				`lastname` VARCHAR( 32 ) NOT NULL ,
				`order` INT NOT NULL ,
				`email` VARCHAR( 64 ) ,
				`fbId` VARCHAR( 16 ) NOT NULL ,
				`password` VARCHAR( 16 ) NOT NULL ,
				`spouse` VARCHAR( 32 ) NOT NULL
				) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
		$dump = "array( <br>";
		foreach ( $this->members as $member ) {
			$query = "INSERT INTO  `famille`.`membres` (
			`id` ,
			`firstname` ,
			`lastname` ,
			`email`
			`order` ,
			`fbId` ,
			`password` ,
			`spouse`
			)VALUES (
			'$member->id',  '$member->firstname',  '$member->lastname', $member->email,
			'$member->order',  '$member->fbId',  '" . $member->getPassword () . "',
			'$member->spouse'
			);";
			$dump .= " '$member->id' => array(<br> 'id'=>'$member->id',<br>  'firstname'=>'$member->firstname',<br>
			'lastname'=>'$member->lastname',<br> 'email'=>'$member->email',<br>'order'=>'$member->order',<br>
			'fbId'=>'$member->fbId',<br>  'password'=>'" . $member->getPassword () . "',<br>
			'spouse'=>'$member->spouse'),<br>";
			// mysql_query($query,$this->link);
		}
		$dump .= ");";
		echo $dump;
	}
}
?>
