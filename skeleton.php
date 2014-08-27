<?php
function htmlHeader($title){
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
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
<script type="text/javascript"
	src="/js/noel.js"></script>
<script type="text/javascript">
<!--
currentUser = eval(<?php echo json_encode($GLOBALS['currentUser']); ?>);
//-->
</script>
<style>
</style>
<script type="text/javascript" src="js/slotmachine.js"></script>
<title><?=$title?></title>
</head>

<?php
	}
function pageHeader(){
?>
<body>
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
		<li><a href="#">à propos</a>
			<ul class="subnav">
				<li><a href="#">about</a></li>
				<li><a href="license.php">License</a></li>
			</ul>
		</li>
	</ul>
</header>
<div id="spacer1"></div>
	<?php 	}
function mainFrameHeader($titre){
?>
<div id="mainFrame">
	<div class="mainFrameHeader">
		<h1 class="mainFrameTitle">
			<?php echo $titre?>
		</h1>
	</div>
<?php
}
function mainFrameFooter($footer){
?>
<div class="mainFrameFooter">
		<?php echo $footer; ?>
	</div>
</div>
<!-- End mainFrame -->
<?php
}
function pageFooter(){
?>
<footer>
	<div id="bottomleft"></div>
	<div id="bottom" style="text-align: center;">
		<a rel="license"
			href="https://creativecommons.org/licenses/by-sa/2.0/fr/"><img
			alt="Contrat Creative Commons"
			style="display: none; height: 20px; border-width: 0"
			src="https://i.creativecommons.org/l/by-sa/2.0/fr/88x31.png" /> </a>
			Les contenus de cette page sont publiés suivant les conditions de la <a
			rel="license"
			href="https://creativecommons.org/licenses/by-sa/2.0/fr/">Licence
			Creative Commons Paternité - Partage à l&#39;Identique 2.0 France</a>.<br>
			Le code source est sous <a href="http://www.gnu.org/licenses/gpl.html">GPLV3</a> et est disponible <a href="https://github.com/cybfr/famille.miradou.com">ici</a>.
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
</body>
	
<?php
	}
function htmlFooter(){
?>
</html>
<?php
}
?>