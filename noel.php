<?php include("skeleton.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
<!-- noel.php created on 23 sept. 2011 14:47:00 CEST -->
<?php html_head(""); ?>
<script type="text/javascript" src="js/slotmachine.js"></script>
<title>noel</title>
</head>
<body>
	<?php page_header("Tirage au sort 2013"); ?>
	<div id="effect">
		<div id="drawers"></div>
		<div id="drawn"></div>
	</div>
	<?php page_footer('	<a href="#draw" id="draw">Démonstration</a>
			<a href="#draw2011" id="draw2011">Tirage 2011</a>
			<a href="#draw2012" id="draw2012">Tirage 2012</a>
		<a href="#reset" id="reset" style="display: none">Remettre à zéro</a>
		<a href="#text" id="opener" style="display: none">Afficher le texte</a>
		<a href="#file" id="file" style="display: none" >Télécharger le fichier</a>
		<p id="wait-animation" style="display: none">Wait</p>'); ?>

</body>
</html>
