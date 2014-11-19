<?php
class MiradouAuth {
	private $AuthRealm;
	function __construct($authrealm) {
		$this->AuthRealm = $authrealm;
		if (isset ( $_SESSION ['miUser'] )) {
			$session_user = unserialize ( $_SESSION ['miUser'] );
		} else {
			$session_user = new member ( array () );
		}
		foreach ( $session_user as $key => $value ) {
			$this->$key = $value;
		}
	}
	function loginMi($email, $password) {
		$user = $this->AuthRealm->getMemberByMail ( $email );
		if ($user) {
			if ($user->checkPassword ( $password )) {
				$_SESSION ['miUser'] = serialize ( $user );
			} else {
				$user = "wrong password";
			}
		} else {
			$user = "wrong e-mail";
		}
		return ($user);
	}
	function getIdStyles() {
		$style = " 	.unknownid{	background-position: 0 -10px; background-image: url(/images/fmly_ids.png);}
				";
		foreach ( $this->AuthRealm->members as $member ) {
			$style .= "	." . $member->id . "{	background-position: 0 -" . $member->pictureIdx . "px; background-image: url(/images/fmly_ids.png);}
					";
		}
		return ($style);
	}
	/**
	 * Enter description here .
	 *
	 * ..
	 *
	 * @param string $fbId        	
	 */
	function loginFb($fbId) {
		$user = $this->AuthRealm->getMemberByfbId ( $fbId );
		if ($user) {
			$_SESSION ['miUser'] = serialize ( $user );
		} else {
			$user = "wrong fbId";
		}
		return ($user);
	}
	/**
	 * Enter description here .
	 *
	 * ..
	 *
	 * @param unknown_type $mailto_addr        	
	 * @return Ambiguous
	 */
	function sendPwResetMail($mailToAddr) {
		/* check e-mail addresse */
		$member = $this->AuthRealm->getMemberByMail ( $mailToAddr );
		error_log ( "sendPwResetMail($mailToAddr)" );
		if ($member === false) {
			return "Cette adresse ($mailToAddr) n'est pas enregistrée, contactez le ouaibmestre";
		}
		$key = sha1 ( $mailToAddr . microtime ( true ) . mt_rand ( 10000, 90000 ) );
		$query = "
			REPLACE INTO  `famille`.`pwresetrequests` SET
			`key`='$key',
			`date`='" . date ( DATE_ATOM ) . "',
			`email`='" . $member->email . "',
			`null`='0';
		";
		if (! mysql_query ( $query )) {
			if (mysql_errno () == 1062) {
				$msg = mysql_error ();
				if (strpos ( $msg, 'email', 0 )) {
					// TODO : cancel key then resend link
					error_log ( "already send a link to this address" );
					return "already send a link to this address";
				}
			}
			error_log ( "Error inserting key record.<hr>$query<hr>" . mysql_error () . "<hr>" . mysql_errno () );
			
			return "Error inserting key record.<hr>$query<hr>" . mysql_error () . "<hr>" . mysql_errno ();
		}
		error_log ( "sending mail" );
		$to = $mailToAddr;
		$fromAddr = "admin@miradou.com";
		$headers = "Reply-to: $fromAddr\n";
		$headers .= "From: $fromAddr\n";
		$headers .= "Errors-to: $fromAddr\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Transfer-Encoding: 8bit\n";
		$headers .= "Content-Type: text/plain; charset=utf-8\n";
		$site_url = "https://famille.miradou.com/Resetpw";
		$subject = "=?UTF-8?B?" . base64_encode ( "Votre demande de changement de mot de passe sur famille.miradou.com" ) . "?=";
		$url = $site_url . '?key=' . $key;
		$msg_body = "		Bonjour François-Régis,

		Vous avez demandé la réinitialisation de votre mot de passe pour miradou.
		Pour finaliser votre demande, veuillez cliquer sur ce lien :

		$url

		* Vous n’avez pas demandé ce changement ? *
		Si vous n’avez pas demandé un nouveau mot de passe, informez-nous en à :

		$url

		Merci,

		--
		l'équipe miradou
		";
		if (mail ( $mailToAddr, $subject, $msg_body, $headers )) {
			$msg = "Un lien vous a été envoyé pour mettre à jour votre mot de passe. Vérifiez votre mail dans quelques instants";
		} else {
			$msg = "There is some system problem in sending login details to your address. Please contact site-admin.";
		}
		error_log ( $msg );
		return ($msg);
	}
	function resetPassword($passwd, $key) {
		// TODO
		// check key validity=> get user
		$user = $this->validateKey ( $key );
		// update mysql : password for user
		if ($user) {
			$user->setPassword ( $passwd );
			$this->deleteKey ( $key );
		}
		// return link to ? page
		return $user;
	}
	function validateKey($key) {
		$sql = "
			SELECT * FROM famille.pwresetrequests WHERE `key` = \"$key\"";
		$result = mysql_query ( $sql );
		$keys = mysql_fetch_array ( $result );
		if ($keys) {
			return $this->AuthRealm->getMemberByMail ( $keys ['email'] );
		} else {
			return FALSE;
		}
	}
	private function deleteKey($key) {
		$query = "DELETE FROM famille.pwresetrequests WHERE `key` = \"$key\"";
		mysql_query ( $query );
	}
}
?>