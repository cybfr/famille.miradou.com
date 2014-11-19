<?php
session_start ();
spl_autoload_register ( function ($class) {
	include 'classes/' . $class . '.php';
} );
$realm = new FamilyRealm ();
$currentUser = new MiradouAuth ( $realm );
?>
<div id="passwdInput" style="display: none;">
	<h3>saisissez votre nouveau mot de passe</h3>
	<form style="margin-top: 32px">
		<fieldset style="border: 0;">
			<table>
				<tr>
					<td><label for="password">nouveau mot de passe</label></td>
					<td><input type="password" name="passwordn" id="passwordn" value=""
						class="text ui-widget-content ui-corner-all" /></td>
				</tr>
				<tr>
					<td><label for="password">confirmez le mot de passe</label></td>
					<td><input type="password" name="passwordv" id="passwordv" value=""
						class="text ui-widget-content ui-corner-all" /></td>
				</tr>
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
	var ajaxQueryUrl = "https://famille.miradou.com/noel_ajax.php";
$(document).ready( function(){
	$.ajaxSetup({
		error: function(xhr, status, error) {
		alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
		     } 
		    });
	console.log("ajaxResetPw");
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
						alert("Le mot de passe de " + data.firstname + " a été modifié."+
								 "Vous pouvez maintenant l'utiliser pour vous connecter sur famille@miradou");
					} else {
						alert("le lien utilisé n'est pas valide");
					}
				},'jsonp')
				.error(function(data1, data2, data3){
					alert("error : " + data1 + data2 +data3 );
				});
				$( this ).dialog( "close" );
				location.replace("https://famille.miradou.com");
},
			"annuler" : function(){
				$( this ).dialog( "close" );
				location.replace("https://famille.miradou.com");
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
			"connexion": function() {
				// call verify/send email ajax query
				// if ok alert
				// else msg "no email recorded, contact webmaster"
				$.post(ajaxQueryUrl + "?action=sendPwRstMail",{ email: $('#pwEmail').val()}, function(data){
					alert(data);
				},'jsonp')
				.error(function(data1, data2, data3){
					test=data1;
				});
				$( this ).dialog( "close" );
				
			},
			"annuler": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
//			allFields.val( "" ).removeClass( "ui-state-error" );
			location.replace("https://famille.miradou.com/");
			
		}
	});
<?php 	if( $currentUser->validateKey($_REQUEST['key'] )) { ?>
		$( "#passwdInput" ).dialog( "open" );
<?php 	} else { ?>
		$( "#invalidKey" ).dialog( "open" );
<?php 	} ?>
});
</script>
