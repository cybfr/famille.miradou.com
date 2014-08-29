<?php
require_once 'File/Fortune.php';
// Grab from a single fortune file:
try {
	$fortunes = new File_Fortune('/usr/share/games/fortunes/ascii-art');
	echo "<pre style='text-align: left; margin: auto; width: 40em' >".$fortunes->getRandom()."</pre>";
}catch (File_Fortune_Exception $e) {
    echo "Unable to retrieve fortune: " . $e->getMessage() . "\n";
}
?>
<script type="text/javascript">
	$('.mainFrameTitle').html('Bienvenue sur famille@miradou');
	$('.mainFrameFooter').html('');
</script>