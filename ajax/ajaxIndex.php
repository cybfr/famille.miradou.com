<?php
require_once 'File/Fortune.php';
// Grab from a single fortune file:
try {
	$fortunes = new File_Fortune ( '/usr/share/games/fortunes/ascii-art2' );
	echo "<pre style='text-align: left; margin: auto; width: 50em;background-color: black;color: orange;padding: 10px;border-radius: 10px;' >" . $fortunes->getRandom () . "</pre>";
} catch ( File_Fortune_Exception $e ) {
	echo "Unable to retrieve fortune: " . $e->getMessage () . "\n";
}
?>
<script type="text/javascript">
	$('.mainFrameTitle').html('Bienvenue sur famille@miradou');
	$('.mainFrameFooter').html('Courtesy of <a href="http://www.asciiartfarts.com">http://www.asciiartfarts.com</a>');
</script>