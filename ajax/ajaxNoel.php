<?php
if (! isset ( $_SERVER ['HTTP_REFERER'] )) {
	?>
<link rel="stylesheet" type="text/css" href="/css/fmly.css" />

<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<a href="#draw" id="draw">Tirage 1015</a>
<a href="#drawLastYear" id="drawLastYear">Tirage 2014</a>
<a href="#drawLastLastYear" id="drawLastLastYear">Tirage 2013</a>
<a href="#reset" id="reset" style="display: none">Remettre à zéro</a>
<a href="#text" id="opener" style="display: none">Afficher le texte</a>
<a href="#file" download="résultat.txt" id="file" style="display: none">Télécharger
	le fichier</a>
<p id="wait-animation" style="display: none">Wait</p>
<?php
}
?>
<div id="effect">
	<div id="drawers"></div>
	<div id="drawn"></div>
</div>

<script type="text/javascript">
$('.mainFrameTitle').html("Tirage au sort");
$('.mainFrameFooter').html(
		'<a href="#draw" id="draw">Tirage 2015</a>'+
		'<a href="#drawLastYear" id="drawLastYear">Tirage 2014</a>'+
		'<a href="#drawLastLastYear" id="drawLastLastYear">Tirage 2013</a>'+
		'<a href="#reset" id="reset" style="display: none">Remettre à zéro</a>'+
		'<a href="#text" id="opener" style="display: none">Afficher le texte</a>'+
		'<a href="#file" download="résultat.txt" id="file" style="display: none">Télécharger le fichier</a>'+
		'<p id="wait-animation" style="display: none">Wait</p>');
		</script>
<script type="text/javascript" src="/js/noel.js"></script>
