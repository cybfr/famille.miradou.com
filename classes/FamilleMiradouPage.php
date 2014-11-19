<?php
class FamilleMiradouPage {
	public function htmlHeader($title) {
		session_start ();
		$GLOBALS ['currentUser'] = new MiradouAuth ( new FamilyRealm () );
		$css_file = "css" . str_replace ( ".php", ".css", $_SERVER ['PHP_SELF'] );
		$js_file = "js" . str_replace ( ".php", ".js", $_SERVER ['PHP_SELF'] );
		?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
<link rel="stylesheet" type="text/css"
	href="/css/jquery-ui-1.8.13.custom.css" />
<link rel="stylesheet" type="text/css" href="/css/fonts.css" />
<link rel="stylesheet" type="text/css" href="/css/fmly.css" />
		<?php if (file_exists($css_file)) { ?>
	<link rel="stylesheet" type="text/css" href="<?=$css_file?>" />
		<?php } ?>	
	<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/fmly.js"></script>
<script type="text/javascript">
	<!--
	currentUser = eval(<?php echo json_encode($GLOBALS['currentUser']); ?>);
	//-->
	</script>
		<?php if (file_exists($js_file)) { ?>
	<script type="text/javascript" src="<?=$js_file?>"></script>
		<?php } ?>	
	<style>
</style>
<title><?=$title?></title>
</head>
	
	<?php
	}
	public function pageHeader() {
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
				<a href="#" id="milogin">Connection</a>
			</li>
			<li id="loggedmenu"
				class="lastmenu <?php if('visitor' == $GLOBALS['currentUser']->id) echo "hidden" ?>">
				<a href="#" id="username"><?php echo $GLOBALS['currentUser']->firstname; ?><span
					class="arrow"></span></a>
				<ul class="subnav">
					<li><a href="#">Administration</a></li>
					<li><a href="/Logout" id="logout">Déconnection</a></li>
				</ul>
			</li>
			<li><a href="/About" id="About">À propos</a></li>
			<li id="navmenu"><a href="#">Navigation<span class="arrow"></span></a>
				<ul class="subnav">
					<li><a href="/Index" id="index">Accueil</a></li>
					<li><a href="/Noel" id="noel">Tirage au sort</a></li>
					<li><a href="/Stat" id="stat">Tests statistiques</a></li>
					<li><a href="/Gift" id="gift">Idées de cadeaux</a></li>
				</ul></li>
		</ul>
	</header>
	<div id="spacer1"></div>
		<?php
	}
	public function mainFrameHeader($titre) {
		?>
	<div id="mainFrame">
		<div class="mainFrameHeader">
			<img id="scrobbler" alt="loading" src="/images/ajax-loader.gif"
				style="position: absolute; margin: 3px" class="hidden">
			<h1 class="mainFrameTitle">
				<?php echo $titre?>
			</h1>
		</div>
	<?php
	}
	public function mainFrameFooter($footer) {
		?>
	<div class="mainFrameFooter">
			<?php echo $footer; ?>
		</div>
	</div>
	<!-- End mainFrame -->
	<?php
	}
	public function pageFooter() {
		?>
	<footer>
		<div id="bottomleft"></div>
		<div id="bottom" style="text-align: center;">
			Les contenus de cette page sont publiés suivant les conditions de la
			<a rel="license"
				href="https://creativecommons.org/licenses/by-sa/2.0/fr/">Licence
				Creative Commons Paternité - Partage à l&#39;Identique 2.0 France</a>.<br>
			Le code source est sous <a
				href="http://www.gnu.org/licenses/gpl.html">GPLV3</a> et est
			disponible <a href="https://github.com/cybfr/famille.miradou.com">ici</a>.
		</div>
		<div id="bottomright"></div>
	</footer>
	<div id="milogin-form" title="Connectez-vous à famille@miradou"
		style="display: none">
		<form>
			<fieldset>
				<p class="validateTips">Entrez votre adresse mail et votre mot de
					passe :</p>
				<div>
					<label for="email"></label> <input type="text" name="email"
						id="login_email" value="" placeholder="Adresse email"
						class="text ui-widget-content ui-corner-all" style="width: 20em;" />
				</div>
				<div>
					<label for="password"></label> <input type="password"
						name="password" id="password" value="" placeholder="Mot de passe"
						class="text ui-widget-content ui-corner-all" /> <a
						href="Connection" id="Connection">Connection</a>
				</div>
				<p>ou connectez-vous avec</p>
				<div style="display: inline-block;">
					<a href="/Fblogin" id="Fblogin"><img alt="Facebook"
						src="/images/facebooklogo.jpg"
						style="width: 40px; display: inline-block; vertical-align: bottom; border-radius: 5px;"></a>
					<div id="customBtn" class="customGPlusSignIn">
						<span class="icon"><span
							style="background: rgba(87, 50, 50, 0.72); width: 40px; height: 40px; display: inline-block; border-radius: 5px;"></span></span>
					</div>
				</div>
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
	<script type="text/javascript"
		src="https://connect.facebook.net/fr_FR/all.js"></script>
	<div id="log"
		style="display: none; border: 1px solid black; background-color: #ddd;"></div>
	<!-- Placez ce script JavaScript asynchrone juste devant votre balise </body> -->
	<script type="text/javascript">
	      (function() {
	       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	       po.src = 'https://apis.google.com/js/client:plusone.js';
	       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	     })();
	    </script>
</body>
		
	<?php
	}
	public function htmlFooter() {
		?>
	</html>
<?php
	}
}
?>