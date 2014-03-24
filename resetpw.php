<?php include("skeleton.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
<!-- resetpw.php created on 23 sept. 2011  15:16:51 CEST -->
<?php html_head(""); ?>
<style type="text/css">
h2 { font: bold 16pt/36pt 'FontinSansRegular'; color: gray; }
</style>
<title>Entrez votre mot de passe</title>
</head>
<body>
<?php page_header(""); ?>
<?php ?>
<div style="height: 350px;"></div>
<?php page_footer(''); ?>
<div id="passwdInput" style="display: none;">
<h3>saisissez votre nouveau mot de passe</h3>
	<form style="margin-top: 32px">
		<fieldset style="border: 0;">
			<table><tr><td><label for="password">nouveau mot de passe</label></td>
				<td><input type="password" name="passwordn" id="passwordn" value="" class="text ui-widget-content ui-corner-all" /></td></tr>
				<tr><td><label for="password">confirmez le mot de passe</label></td>
				<td><input type="password" name="passwordv" id="passwordv" value="" class="text ui-widget-content ui-corner-all" /></td></tr>
			</table>
		</fieldset>
	</form>
</div>
<div id="invalidKey" style="display: none">
	<form>
	<h3>Le lien utilisé n'est plus valide</h3>
		<fieldset style="border: 0;">
			<p class="validateTips">Pour réinitialiser votre mot de passe,
				saisissez votre adresse mail. Vous recevrez un lien de
				réinitialisation du mot de passe.</p>
			<div>
				<label for="email">mail</label> <input type="text" name="email"
					id="pwEmail" value="" class="text ui-widget-content ui-corner-all" />
			</div>
		</fieldset>
	</form>
</div>
	<script type="text/javascript">
$(document).ready( function(){
	$("#passwdInput").dialog({
		autoOpen: false,
		height: 250,
		width: 350,
		modal: true,
		buttons: {
			"enregistrer les modifications": function(){
				key = 0;
				$.post( ajaxQueryUrl + '?action=resetpw', { password: $("#passwordn").val(), key: "<?php echo $_REQUEST['key']; ?>"}, function(data){
					if (data) {
						alert("Le mot de passe de " + data.firstname + " a été modifié");
					} else {
						alert("le lien utilisé n'est pas valide");
					}
				},'jsonp')
				.error(function(data1, data2, data3){
					alert("error : " + data1 + data2 +data3 );
				});
				$( this ).dialog( "close" );
},
			"annuler" : function(){
				$( this ).dialog( "close" );
			}
		}
	});
	$("#invalidKey").dialog({
		autoOpen: false,
		height: 250,
		width: 350,
		modal: true,
		position: { my: "center center", at: "center center", of: window, colision: "flip" },
		buttons: {
			"connexion": function(data) {
				// call verify/send email ajax query
				// if ok alert
				// else msg "no email recorded, contact webmaster"
				$.post(ajaxQueryUrl + "?action=sendPwRstMail",{ email: $('#pwEmail').val()}, function(data){
					alert(data);
				},'jsonp')
				.error(function(data1, data2, data3){
					test=data1;
				});
				$("#resetpwquery-form").dialog("close");
			},
			"annuler": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
//			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
<?php 	if( $currentUser->validateKey($_REQUEST['key'] )) { ?>
		$( "#passwdInput" ).dialog( "open" );
<?php 	} else { ?>
		$( "#invalidKey" ).dialog( "open" );
<?php 	} ?>
});
</script>
</body>
</html>