<?php
include("skeleton.php");
htmlHeader("Stats");
pageHeader();
mainFrameHeader("Tests statistiques");
?>
	<div id="mainFrameContent">
	</div>
	<script type="text/javascript">
	$(document).ready( function(){
		var count = 5000;
		$.get(ajaxQueryUrl + "?action=stat&count=" + count, function(data){
			$('#mainFrameContent').html(data);
			$('.mainFrameTitle').html('Statistiques faites');
		});
		$('.mainFrameTitle').html('En attente des résulats');
		$('#mainFrameContent').html('<img alt="loading" src="/images/ajax-loader.gif"></img>');
	});
	</script>
<?php 
mainFrameFooter('');
pageFooter();
htmlFooter();
?>