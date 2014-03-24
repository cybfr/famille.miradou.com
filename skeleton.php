<?php if(0){ ?>
<!DOCTYPE html>
<?php
}
if(!defined('SKELETON')) define('SKELETON', TRUE);
// require 'noel_class.php';
// require("MiradouAuth.php");
// require("FamilyRealm.php");
function my_autoloader($class) {
	include 'classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');

session_start();
$currentUser = new MiradouAuth(new FamilyRealm());
if (SKELETON){
	function html_head($l){
?>
<link
	rel="stylesheet" type="text/css" href="/css/jquery-ui-1.8.13.custom.css" />
<link
	rel="stylesheet" type="text/css" href="/css/fonts.css" />
<link
	rel="stylesheet" type="text/css" href="/css/noel.css" />
<script
	type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script
	type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<!-- <script type="text/javascript" src="https://famille.miradou.com/js/jquery.backgroundPosition.js"></script> -->
<script type="text/javascript"
	src="/js/noel.js"></script>
<script type="text/javascript">
<!--
currentUser = eval(<?php echo json_encode($GLOBALS['currentUser']); ?>);
//-->
</script>
<style>
</style>
<?php
	}
	function page_header($titre){
?>
<header>
	<div id="headercenter">
		<div
			style="padding: 0 5px 0 5px; background-color: white; float: left;">miradou</div>
		<div style="margin-top: 1px; position: relative; top: -7px;">
			<img src="/images/logo-miradou.svg" style="height: 27px;"
				alt="logo miradou">
		</div>
	</div>
	<ul class="topnav menu">
		<li id="loginmenu"
			class="lastmenu <?php if ('visitor' != $GLOBALS['currentUser']->id) echo "hidden" ?>">
			<a href="#">connexion<span class="arrow"></span>
		</a>
			<ul class="subnav">
				<li><a href="#" id="fbLogin">avec facebook</a></li>
				<li><a href="#" id="gglogin">avec google</a></li>
				<li><a href="#" id="milogin">avec miradou</a></li>
			</ul>
		</li>
		<li id="loggedmenu"
			class="lastmenu <?php if('visitor' == $GLOBALS['currentUser']->id) echo "hidden" ?>">
			<a href="#" id="username"><?php echo $GLOBALS['currentUser']->firstname; ?><span
				class="arrow"></span> </a>
			<ul class="subnav">
				<li><a href="#">administration</a></li>
				<li><a href="#" id="logout">déconnexion</a></li>
			</ul>
		</li>
		<li><a href="#">about</a>
			<ul class="subnav">
				<li><a href="#">about</a></li>
				<li><a href="#">about</a></li>
			</ul>
		</li>
	</ul>
</header>
<div id="header2"></div>
<div id="slotmachine">
	<div class="slotmachineheader">
		<h1 class="slotmachinetitle">
			<?php echo $titre?>
		</h1>
	</div>
	<?php 	}
	function page_footer($footerhtml){
?>
	<div class="slotmachinefooter">
		<?php echo $footerhtml; ?>
	</div>
</div>
<!-- End SLOTMACHINE -->
<footer>
	<div id="bottomleft"></div>
	<div id="bottom" style="text-align: center;">
		<a rel="license"
			href="https://creativecommons.org/licenses/by-sa/2.0/fr/"><img
			alt="Contrat Creative Commons"
			style="display: none; height: 20px; border-width: 0"
			src="https://i.creativecommons.org/l/by-sa/2.0/fr/88x31.png" /> </a>
		Cette page peut être utilisée suivant les conditions de la<br> <a
			rel="license"
			href="https://creativecommons.org/licenses/by-sa/2.0/fr/">Licence
			Creative Commons Paternité - Partage à l&#39;Identique 2.0 France</a>.
	</div>
	<div id="bottomright"></div>
</footer>
<div id="milogin-form" title="Connexion avec miradou"
	style="display: none">
	<form>
		<fieldset>
			<p class="validateTips">All form fields are required.</p>
			<div>
				<label for="email">mail</label> <input type="text" name="email"
					id="login_email" value=""
					class="text ui-widget-content ui-corner-all" />
			</div>
			<div>
				<label for="password">mot de passe</label> <input type="password"
					name="password" id="password" value=""
					class="text ui-widget-content ui-corner-all" />
			</div>
			<a id="resetpwquery" href="#">mot de passe oublié ?</a>
		</fieldset>
	</form>
</div>
<div id="resetpwquery-form"
	title="Vous avez oublié votre mot de passe ?" style="display: none">
	<form>
		<fieldset>
			<p class="validateTips">Pour réinitialiser votre mot de passe,
				saisissez votre adresse mail. Vous recevrez un lien de
				réinitialisation du mot de passe.</p>
			<div>
				<label for="email">mail</label> <input type="text" name="email"
					id="email" value="" class="text ui-widget-content ui-corner-all" />
			</div>
		</fieldset>
	</form>
</div>
<div id="fb-root"></div>
<!-- <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js#appId=219799788042522&amp;xfbml=1&amp;oauth=1"></script> -->
<script
	type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<div
	id="log"
	style="display: none; border: 1px solid black; background-color: #ddd;"></div>
<?php
	}
}else{
	function html_head(){
}
function page_header(){
}
function page_footer(){
}
}
?>