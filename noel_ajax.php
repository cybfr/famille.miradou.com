<?php
// require "noel_class.php";
define("AJAX_FMT",  'jsonp');
function myAjaxFmt($data){
	if(!isset($_REQUEST['callback'])) exit('no callback for jsonp request');
	if(AJAX_FMT == 'jsonp'){
		return($_REQUEST['callback'].'('.json_encode($data).')');
	}
}
function my_autoloader($class) {
	include 'classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');
session_start();
$currentUser = new MiradouAuth(new FamilyRealm());
$my = new Family($currentUser);
if(!isset($_REQUEST['action'])) exit('no action specified');
switch ($_REQUEST['action']){
		case 'logout' :
/* TODO : should be something like $currentUser->logout();
 *
 */
		unset($_SESSION['miUser']);	break;
	case 'getcurrentuser' :		exit( myAjaxFmt($currentUser));
	case 'login' :
/* TODO : should be something like $currentUser->login($_REQUEST);
 *
 */
		if(isset($_REQUEST['fbId'])) {
			echo myAjaxFmt($currentUser->loginFb($_REQUEST['fbId']));
		}elseif(isset($_REQUEST['email']) && isset($_REQUEST['password'])){
			$user = $currentUser->loginMi($_REQUEST['email'], $_REQUEST['password']);
			echo myAjaxFmt($user);
		}else echo myAjaxFmt("login request error");
		break;
	case 'sendPwRstMail' : exit(myAjaxFmt($currentUser->sendPwResetMail($_REQUEST['email'])));
	case 'resetpw' 		: exit(myAjaxFmt($currentUser->resetPassword($_REQUEST['password'],$_REQUEST['key'])));
	case 'userdraw'		: exit(myAjaxFmt($my->getUserGiftDraw()));
	case 'reqdraw' 		: exit(myAjaxFmt($my->getValidGiftDraw()));
	case 'reqdrawLastLastYear' 	: exit(myAjaxFmt($my->getdbGiftDraw("2011",'2c8lloigsh3bqe1p6726t55k71')));
	case 'reqdrawLastYear' 	: exit(myAjaxFmt($my->getdbGiftDraw("2012",'6h8e8j7ajisck7vnvo6vkgti56')));
	case 'resetdraw' 	: exit(myAjaxFmt($my->resetGiftDraw()));
	case 'reqids' 		: exit(myAjaxFmt($my->getMembers()));
	case 'reqmember' :
		if(isset($_REQUEST['firstname']))
			echo myAjaxFmt($my->getMemberByFirstName($_REQUEST['firstname']));
		if(isset($_REQUEST['id']))
			echo myAjaxFmt($my->getMemberById($_REQUEST['id']));
		if(isset($_REQUEST['fbid']))
			echo myAjaxFmt($my->getMemberByfbId($_REQUEST['fbid']));
		break;
	case 'storeFamily' :
		echo '<h1>storeFamily</h1>';
		$my->storeFamily();
		break;
	case 'dump' :
		print_r($_SESSION);echo "<hr>";
		print_r($_REQUEST);echo "<hr>";
		if(isset($currentUser)) var_dump($currentUser); else echo "not logged<br>";
		break;
	case 'stat' 	:
		require 'include/StatFunctions.php';
		draw_stat($my);
		break;
	case 'unit_stat':
		require 'include/StatFunctions.php';
		unit_stat($my);
		break;
/* TODO : should be in antoher class / file
 *
 *
 */
	case 'getideas' :
		$myideas = new GiftIdeas($currentUser);
		exit(myAjaxFmt($myideas->getIdeas()));
	case 'addidea' :
		$myideas = new GiftIdeas($currentUser);
		exit(myAjaxFmt($myideas->addIdea($_REQUEST['idea'])));
	case 'delidea' :
		$myideas = new GiftIdeas($currentUser);
		exit(myAjaxFmt($myideas->removeIdea($_REQUEST['idea'])));
	default :
		echo myAjaxFmt('action '.$_REQUEST['action'].' is not implemented');
}
?>