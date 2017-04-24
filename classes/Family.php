<?php
/**
 * @author fvuillemin
 *
 */
define ( "CONSTRAINT_SIZE", 2 );
class Family extends BaseFamily {
	public $basket;
	public $constraints;
	public $drawers;
	private $nextOrder = 0;
	private $currentUser;
	/**
	 */
	function __construct($currentUser) {
		$this->currentUser = $currentUser;
		include 'include/mysqlsecrets.php';
		$this->link = mysql_connect ( $server, $username, $password ) or die ( "Impossible de se connecter : " . mysql_error () );
		mysql_query ( "SET NAMES 'utf8'" );
		$query = "
 			SELECT T1 . *
		          FROM  `famille`.`membres` T1,  `famille`.`membres` T2
                          WHERE (
				 (
                                   ( T1.mother =  'janic' AND T1.father =  'alain' ) 
                                   OR ( T2.mother =  'janic' AND T2.father =  'alain' ) 
                                 ) AND ( T2.spouse = T1.id  ) 
                                 OR (T1.id = T2.id AND T1.spouse='' AND T1.father = 'alain') 
                               );
                ";
		$result = mysql_query ( $query );
		if ($result) {
			while ( $member = mysql_fetch_assoc ( $result ) ) {
				$this->members [$member ['id']] = new member ( $member );
			}
			foreach ( $this->members as $id => $member ) {
				$this->constraints [$id] = array (
						$member->id,
						$this->members [$member->spouse]->id 
				);
				$this->drawers [] = $member->id;
			}
			$this->add_constraint ( $this->getdbGiftDraw ( "2014", 'frv' ) );
			$this->add_constraint ( $this->getdbGiftDraw ( "2013", 'frv' ) );
			$this->add_constraint ( $this->getdbGiftDraw ( "2012", '6h8e8j7ajisck7vnvo6vkgti56' ) );
			$this->add_constraint ( $this->getdbGiftDraw ( "2011", '2c8lloigsh3bqe1p6726t55k71' ) );
			$this->checkGlobalConstraint ( $this->constraints );
		} else {
			$error = mysql_error ();
		}
	}
	/**
	 *
	 * @param unknown_type $member        	
	 * @return multitype:
	 */
	function checkEndDrawers($drawers) {
		if (count ( $drawers ) > CONSTRAINT_SIZE * CONSTRAINT_SIZE)
			return (FALSE);
	}
	function checkGlobalConstraint(array $constraints) {
		if (! is_array ( $constraints ))
			return FALSE;
		$intersect = reset ( $constraints );
		$constraint = next ( $constraints );
		while ( count ( $intersect ) != 0 && count ( $constraint ) != 0 ) {
			$intersect = array_intersect ( $intersect, $constraint );
			$constraint = next ( $constraints );
		}
		if (empty ( $intersect ))
			return (FALSE);
		return ($intersect);
	}
	private function constrained_basket($member_id) {
		$third = $this->constraints [$member_id];
		$first = array_diff ( $this->basket, $third );
		return (array_values ( $first ));
	}
	/**
	 *
	 * @param unknown_type $constraints        	
	 */
	public function add_constraint($constraints) {
		foreach ( $constraints as $member => $constraint ) {
			if (is_array ( $constraint )) {
				foreach ( $constraint as $element ) {
					$this->constraints [$member] [] = $element;
				}
			} else {
				$this->constraints [$member] [] = $constraint;
			}
		}
	}
	/**
	 *
	 * @param unknown_type $puller        	
	 * @param unknown_type $pulled        	
	 * @return string|string
	 */
	public function is_valid($puller, $pulled) {
		if (! (array_search ( $pulled, $this->constraints [$puller] ) === FALSE)) {
			error_log ( __FILE__ . __LINE__ . "is_falid failed @ $puller -> $pulled" );
			return (false);
		} else {
			if ($puller == $pulled) {
				echo "failed<br/>";
				var_dump ( $puller, $pulled, $this->constraints [$puller] );
			}
			return (true);
		}
	}
	/**
	 *
	 * @param member $puller        	
	 * @return FALSE | member
	 */
	function pull($puller) {
		// Purge $puller constraints
		$constrained_basket = $this->constrained_basket ( $puller );
		if (empty ( $constrained_basket )) {
			return (FALSE);
		}
		// TODO if more than 1 element belong to all others constraints, failed !!!
		// TODO if 1 element belong to all others constraints, pull it
		// $pulled = mt_rand(0, count($constrained_basket)-1);
		// shuffle($constrained_basket);
		// $pulled=0;
		$pulled = array_rand ( $constrained_basket, 1 );
		if (! $this->is_valid ( $puller, $constrained_basket [$pulled] )) {
			error_log ( "is_valid failed @ $puller" );
		}
		// error_log("puller : $puller, pulled: $constrained_basket[$pulled]");
		return ($constrained_basket [$pulled]);
	}
	/**
	 *
	 * @return string|string|unknown
	 */
	function getGiftDraw() {
		$this->basket = array_keys ( $this->members );
		shuffle ( $this->drawers );
		foreach ( $this->drawers as $member ) {
			$pulled = $this->pull ( $member );
			if ($pulled === FALSE) {
				return (FALSE);
			}
			// unset($this->basket[$this->members[$pulled]->id]);
			$this->basket = array_diff ( $this->basket, array (
					$pulled 
			) );
			$gift [$member] = $pulled;
		}
		return ($gift);
	}
	/**
	 *
	 * @return NULL
	 */
	function getValidGiftDraw() {
		$result = NULL;
		$drawing = NULL;
		// $result = $this->getdbGiftDraw();
		if ($result === NULL) {
			while ( ! $drawing )
				$drawing = $this->getGiftDraw ();
				// if( $this->currentUser->id == "janic" or $this->currentUser->id == "francoisregis" )
				// $this->storeGiftDraw($drawing);
			return ($drawing);
		} else {
			return ($result);
		}
	}
	function resetGiftDraw() {
	}
	function getUserGiftDraw() {
		$unknown = new member ( array (
				id => 'unknown' 
		) );
		unset ( $drawing );
		foreach ( $this->getValidGiftDraw () as $drawer => $drawn ) {
			if ($drawer != $this->currentUser->id)
				$drawing [$drawer] = $unknown->id;
			else
				$drawing [$drawer] = $drawn;
		}
		return ($drawing);
	}
	function storeGiftDraw($drawing) {
		foreach ( $drawing as $drawer => $drawn ) {
			$query = "
					REPLACE `famille`.`tirages`
					SET
					`annee`  = '2013',
					`date`   = '" . date ( 'Y-m-d H:i:s' ) . "',
					`tireur` = '$drawer',
					`tire`   = '$drawn',
					`user`   = '" . $this->currentUser->id . "'
					;";
			// `user` = '".session_id()."'
			if (! mysql_query ( $query, $this->link ))
				syslog ( LOG_ERR, "error updating draw, session id = " . session_id () . " : " . mysql_error () );
		}
	}
	/**
	 *
	 * @param unknown_type $year        	
	 * @param unknown_type $user        	
	 * @return resource|unknown
	 */
	function getdbGiftDraw($year = "2011", $user) {
		if (! isset ( $user ))
			$user = session_id ();
		$query = "SELECT `tireur`, `tire`, `order`
		FROM  `famille`.`tirages`, `famille`.`membres`
		WHERE  `annee` = $year && `membres`.`id` = `tirages`.`tireur`
				ORDER by `order` asc";
		$result = mysql_query ( $query, $this->link );
		if ($result === NULL) {
			return ($result);
		} else {
			while ( $row = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
				// $row = mysql_fetch_array($result);
				$drawing [$row ['tireur']] = $row ['tire'];
			}
			return ($drawing);
		}
	}
	/**
	 * Enter description here .
	 *
	 * ..
	 *
	 * @param string $fbId        	
	 */
	function loginFb($fbId) {
		$user = $this->getMemberByfbId ( $fbId );
		if ($user) {
			$_SESSION ['miUser'] = serialize ( $user );
		} else {
			$user = "wrong fbId";
		}
		return ($user);
	}
}
?>
