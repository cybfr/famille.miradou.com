<?php
class GiftIdeas extends member{
	public $ideas=array();
	function __construct($member){
		foreach ($member as $attribute=>$value){
			$this->$attribute = $value;
		}
		$query = "SELECT *
		FROM  `famille`.`giftideas`
		WHERE  `memberid` LIKE  '$member->id'";
		$result=mysql_query($query);
		while($idea = mysql_fetch_assoc($result)){
			$this->ideas[] = $idea['idea'];
		}
	}
	function addIdea($idea){
		$query = "INSERT INTO  `famille`.`giftideas` (
		`idea` ,
		`memberid` ,
		`date`
		)
		VALUES (
		'$idea',  '$this->id',  ''
		);";
		if(mysql_query($query)) return TRUE;
		return FALSE;
	}
	function removeIdea($idea){
		$query = "DELETE FROM `famille`.`giftideas` WHERE `giftideas`.`idea` = '$idea'";
		$result=mysql_query($query);
		if($result) return TRUE;
		$err = mysql_error();
		return FALSE;
	}
	function getIdeas(){
		foreach ($this->ideas as $idea){
		}
		return $this->ideas;
	}
}
?>