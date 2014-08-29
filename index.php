<?php
include("skeleton.php");
htmlHeader("Index");
pageHeader();
mainFrameHeader("Famille sur miradou");
?>
		<div id="mainFrameContent"></div>
<?php
if(!isset($_REQUEST['page'])){
	$page="ajaxIndex.php"; }else{
 $page = "ajax".$_REQUEST['page'].".php"; }
  if (file_exists("./".$page)){
	$urlParam='?';
	foreach ($_REQUEST as $key => $value) {
		if ($key != "page"){
			$urlParam="$urlParam$key=$value&"; }
		
	}
	?>

		<script type="text/javascript">
		$(document).ready( function(){
			var count = 5000;
			$.get("https://famille.miradou.com/<?=$page?><?=$urlParam?>", function(data){
				$('#mainFrameContent').html(data);
			});
			$('.mainFrameTitle').html('En attente des résulats');
			$('#mainFrameContent').html('<img alt="loading" src="/images/ajax-loader.gif"></img>');
		});
		</script>
	<?php
	}

	
mainFrameFooter('');
pageFooter();
htmlFooter();
?>