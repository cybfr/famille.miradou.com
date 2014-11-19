<?php
class GiftIdeas extends Member {
	public $ideas = array ();
	function __construct($member) {
		foreach ( $member as $attribute => $value ) {
			$this->$attribute = $value;
		}
		include 'include/mysqlsecrets.php';
		$this->link = mysql_connect ( $server, $username, $password ) or die ( "Impossible de se connecter : " . mysql_error () );
		mysql_query ( "SET NAMES 'utf8'" );
		$query = "SELECT *
		FROM  `famille`.`giftideas`
		WHERE  `memberid` LIKE  '$member->id'";
		$result = mysql_query ( $query );
		while ( $idea = mysql_fetch_assoc ( $result ) ) {
			$this->ideas [] = $idea ['idea'];
		}
	}
	function addIdea($idea) {
		$query = "INSERT INTO  `famille`.`giftideas` (
		`idea`, `memberid`,	`date`
		)
		VALUES (
		'" . mysql_real_escape_string ( stripslashes ( $idea ) ) . "',  '$this->id',  NOW()
		);";
		error_log ( $query );
		
		if (mysql_query ( $query ))
			return TRUE;
		$err = mysql_error ();
		error_log ( $err );
		
		return FALSE;
	}
	function removeIdea($idea) {
		// var_dump($idea);
		$query = "DELETE FROM `famille`.`giftideas` WHERE (`giftideas`.`idea` = '" . mysql_real_escape_string ( $idea ) . "' AND `memberid` = '$this->id')";
		error_log ( $query );
		$result = mysql_query ( $query );
		if ($result)
			return TRUE;
		$err = mysql_error ();
		error_log ( $err );
		return FALSE;
	}
	function getIdeas() {
		foreach ( $this->ideas as $idea ) {
		}
		return $this->ideas;
	}
}
?>