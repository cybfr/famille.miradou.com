<?php
include("skeleton.php");
htmlHeader("Stats");
pageHeader();
mainFrameHeader("Tirage au sort 2011");
?>
	<div id="mainFrameContent">
	</div>
	<script type="text/javascript">
	$(document).ready( function(){
		var count = 1400;
		$.get(ajaxQueryUrl + "?action=stat&count=" + count, function(data){
			$('#mainFrameContent').html(data);
			$('.slotmachinetitle').html('statistiques faites');
		});
		$('.slotmachinetitle').html('En attente des résulats');
		$('#effect').html('<img alt="loading" src="/images/ajax-loader.gif"></img>');
	});
	</script>
<?php 
mainFrameFooter('<a href="#" id="draw">Démonstration</a>
		<a href="#" id="reset">Remettre à zéro</a>
		<a href="#" id="opener">Texte</a>');
pageFooter();
htmlFooter();
?>