<?php
function my_autoloader($class) {
	include 'classes/' . $class . '.php';
}
spl_autoload_register ( 'my_autoloader' );
session_start ();
$currentUser = new MiradouAuth ( new FamilyRealm () );
$my = new Family ( $currentUser );
require 'include/StatFunctions.php';
draw_stat ( $my );
?>
<link rel="stylesheet" type="text/css" href="/css/stats.css" />
<script type="text/javascript">
	$('.mainFrameTitle').html('Test statistique');
	$('.mainFrameFooter').html('');
</script>