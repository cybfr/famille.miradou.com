<?php
/**
 * @author Copyright (c) 2012 François-Régis Vuillemin (frv) <frv@miradou.com>
 *
 * This file is part of famille@miradou
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
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
