<?php
include("skeleton.php"); 
spl_autoload_register(function ($class) {
	include 'classes/' . $class . '.php';
});
htmlHeader("Index");
pageHeader();
mainFrameHeader("Famille sur miradou");
phpinfo();
mainFrameFooter('');
pageFooter();
htmlFooter();
?>