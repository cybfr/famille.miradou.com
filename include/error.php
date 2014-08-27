<?php include("skeleton.php");
$message[403]= 'Accès interdit.';
$message[404]= "Ressource non trouvée.";
$message[405]= "Méthode de requête non autorisée";
$message[406]= "Toutes les réponses possibles seront refusées.";
$message[407]= "Accès à la ressource autorisé par identification avec le proxy.";
$message[500]= 'Erreur interne';

spl_autoload_register(function ($class) {
	include 'classes/' . $class . '.php';
});
htmlHeader($_REQUEST['error']);
pageHeader();
mainFrameHeader($message[$_REQUEST['error']]);
mainFrameFooter('');
pageFooter();
htmlFooter();
?>
