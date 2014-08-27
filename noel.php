<?php 
include("skeleton.php"); 
spl_autoload_register(function ($class) {
	include 'classes/' . $class . '.php';
});

session_start();
$currentUser = new MiradouAuth(new FamilyRealm());

// <!-- noel.php created on 23 sept. 2011 14:47:00 CEST -->
 
$year = date("Y");
$lastyear = date("Y",time() - (365 * 24 * 60 * 60));
$lastlastyear = date("Y",time() - (2 * 365 * 24 * 60 * 60));
htmlHeader("Noël");
pageHeader();
mainFrameHeader("Tirage au sort ".$year);
?>
	<div id="effect">
		<div id="drawers"></div>
		<div id="drawn"></div>
	</div>
<?php 
mainFrameFooter('
		<a href="#draw" id="draw">Démonstration</a>
		<a href="#drawLastLastYear" id="drawLastLastYear">Tirage '.$lastlastyear.'</a>
		<a href="#drawLastYear" id="drawLastYear">Tirage '.$lastyear.'</a>
		<a href="#reset" id="reset" style="display: none">Remettre à zéro</a>
		<a href="#text" id="opener" style="display: none">Afficher le texte</a>
		<a href="#file" id="file" style="display: none" >Télécharger le fichier</a>
		<p id="wait-animation" style="display: none">Wait</p>'); 
pageFooter();
htmlFooter();
?>