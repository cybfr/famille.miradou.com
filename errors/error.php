<?php include("skeleton.php");
$message[403]= 'Accès interdit.';
$message[404]= "Ressource non trouvée.";
$message[405]= "Méthode de requête non autorisée";
$message[406]= "Toutes les réponses possibles seront refusées.";
$message[407]= "Accès à la ressource autorisé par identification avec le proxy.";
$message[500]= 'Erreur interne';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
<?php html_head(""); ?>
<title>Error <?php echo  $_REQUEST['error']; ?></title>
</head>
<body>
	<?php page_header($message[$_REQUEST['error']]); ?>
	<div id="effect">
	</div>
	<?php page_footer(''); ?>

</body>
</html>
