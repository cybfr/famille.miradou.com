<?php
include("skeleton.php");
htmlHeader("Stats");
pageHeader();
mainFrameHeader("Tests statistiques");
?>
	<div id="mainFrameContent" class="long_text">
	</div>
	<script type="text/javascript">
	$(document).ready( function(){
		var count = 5000;
		$.get("https://famille.miradou.com/testAjaxLicense.php", function(data){
			$('#mainFrameContent').html(data);
			$('.mainFrameTitle').html('License');
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