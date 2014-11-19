<?php
spl_autoload_register ( function ($class) {
	include 'classes/' . $class . '.php';
} );
$myPage = new FamilleMiradouPage ();
$myPage->htmlHeader ( "" );
$myPage->pageHeader ();
$myPage->mainFrameHeader ( "" );
?>
<div id="mainFrameContent"></div>
<?php
if (! isset ( $_REQUEST ['page'] )) {
	$page = "Index";
} else {
	$page = $_REQUEST ['page'];
}
if (file_exists ( "./ajax/ajax" . $page . ".php" )) {
	$args = '{ ';
	foreach ( $_REQUEST as $key => $value ) {
		if ($key != "page") {
			$args .= "$key: \"$value\"";
		}
	}
	$args .= '}';
	?>
<script type="text/javascript">
	$(function() {
				$.get("https://famille.miradou.com/ajax/ajax<?=$page?>.php", <?=$args?>, function(data){
					$('#mainFrameContent').html(data);
					$('title').html("<?=$page?>");
					$("#scrobbler").addClass("hidden");
									});
				$("#scrobbler").removeClass("hidden");
				
		});
		</script>
<?php
}
$myPage->mainFrameFooter ( '' );
$myPage->pageFooter ();
$myPage->htmlFooter ();
?>