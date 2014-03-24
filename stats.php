<?php include("skeleton.php"); ?>
<!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
<!-- noel.php created on 23 sept. 2011 14:47:00 CEST -->
<?php html_head(""); ?>
<style type="text/css">
table.stat {
	border-collapse: collapse;
	font-size: 10pt;
	}
.stat thead tr { border: none; }
.stat thead th:nth-child(1){ 	border-width: 0; }
.stat thead th:nth-child(2){ 	border-width: 2px 1px 2px 2px;}
.stat thead th:last-child{ border-width:2px 2px 2px 1px;}
.stat thead th {	text-align: center; border-width: 2px 1px; width: 10ex; }
.stat tbody tr:nth-child(odd){ background-color : #eee; }
.stat tbody tr:nth-child(even){ background-color : #ddd; }
.stat tbody tr:nth-child(1) th { border-width: 2px 2px 0 2px; }
.stat tbody th { border-width: 0px 2px; text-align: right; }
.stat th { padding: 0px 2px; }
.stat tr:last-child { border-width: 0 2px 2px 2px; }
.stat tr { border-width: 0 2px; border-style: solid; border-color: gray; }
.stat td, th { border-width: 0px 1px; border-style: solid; border-color: gray; }
</style>
<title>statistiques</title>
</head>
<body>
<?php page_header("Tirage au sort 2011"); ?>
	<div id="effect">
	</div>
	<script type="text/javascript">
	$(document).ready( function(){
		var count = 1400;
		$.get(ajaxQueryUrl + "?action=stat&count=" + count, function(data){
			$('#effect').html(data);
			$('.slotmachinetitle').html('statistiques faites');
		});
		$('.slotmachinetitle').html('En attente des résulats');
		$('#effect').html('<img alt="loading" src="/images/ajax-loader.gif"></img>');
	});
	</script>
<?php page_footer('<a href="#" id="draw">Démonstration</a>
		<a href="#" id="reset">Remettre à zéro</a>
		<a href="#" id="opener">Texte</a>'); ?>
	</body>
</html>

