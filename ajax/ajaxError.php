<?php
$message [403] = 'Accès interdit.';
$message [404] = "Ressource non trouvée.";
$message [405] = "Méthode de requête non autorisée";
$message [406] = "Toutes les réponses possibles seront refusées.";
$message [407] = "Accès à la ressource autorisé par identification avec le proxy.";
$message [500] = 'Erreur interne';
?>
<script type="text/javascript">
$('.mainFrameTitle').html('<?=$message[$_REQUEST['error']];?>');
$('.mainFrameFooter').html('');
</script>