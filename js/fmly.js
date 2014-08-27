/* @version 1.1 fixedMenu
 * @author Lucas Forchino
 * @webSite: http://www.jqueryload.com
 * jquery top fixed menu
 */
var ajaxQueryUrl = "https://famille.miradou.com/noel_ajax.php";
$(document).ready( function(){
	$('.menu > li > a').bind('click',function(){
		var hideMenu = function(){
	    	$('.menu li.active').removeClass('active');
	    	$('body').unbind('click');
	    	return false;
		};
	    if($(this).parent().hasClass('active')){ return true;
	    }
    	hideMenu();
	    $(this).parent().toggleClass('active');
	    $('body').click( hideMenu );
	    return(false);
	});
	$("#resetpwquery-form").dialog({
		autoOpen: false,
		height: 250,
		width: 350,
		modal: true,
		buttons: {
			"connexion": function() {
				// call verify/send email ajax query
				// if ok alert
				// else msg "no email recorded, contact webmaster" 
				$.post(ajaxQueryUrl + "?action=sendPwRstMail",{ email: $('#email').val()}, function(data){
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
	$( "#milogin-form" ).dialog({
		autoOpen: false,
		height: 250,
		width: 350,
		modal: true,
		buttons: {
			"connexion": function() {
				var url = ajaxQueryUrl + "?action=login";
				$.post(url,{ email: $('#login_email').val(), password: $('#password').val()}, function(user){
					if(typeof(user) == "string"){
						$("p.validateTips").text(user);
					}else{							
						miuser=user;
						$('#milogin-form').dialog( "close" );
			    		$("#loginmenu").addClass('hidden');
			    		$("#username").html(user.firstname + "<span class='arrow'></span>");
			    		$("#loggedmenu").removeClass('hidden');
					}
				},'jsonp')
				.error(function(data1, data2, data3){
						test=data1;
					});
			},
			"annuler": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
//			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
	$( "#milogin" ).click(function() {
    	$('.menu li.active').removeClass('active');
    	$('body').unbind('click');
		$( "#milogin-form" ).dialog( "open" );
		return(false);
	});
	$("#resetpwquery").click( function(){
		$( "#milogin-form" ).dialog( "close" );
		$('#resetpwquery-form').dialog("open");
		return false;
	});
	$("#logout").click(function(){
		$.get(ajaxQueryUrl + "?action=logout", function(){
			$("#loggedmenu").addClass('hidden');
			$("#loginmenu").removeClass('hidden');
			currentUser = null;
		});
	});
	$("#gglogin").click(function(){ 
		menu=this; 
		return false;
	});
	$("#fbLogin").click( myFbLogin );

		function myFbLogin(){
			this.Fb = 0;
			FB.login(function(response) {
				  if(response.status == "connected"){
					  $.get(ajaxQueryUrl + "?" + "action=login&fbId=" + response.authResponse.userID,
				    		function(user, textStatus, jqXHR){
						  	if( user ){
						  		currentUser = user;
					    		$("#loginmenu").addClass('hidden');
					    		$("#username").html(user.firstname + "<span class='arrow'></span>");
					    		$("#loggedmenu").removeClass('hidden');
						  	}else{ 
								FB.api('/me', function(reponse){ 
							  		alert( reponse.first_name + " n'est pas autorisé à accéder au site");
							  		FB.logout();
								});
						  		}
					  }, 'jsonp')
					  .error(function(data1, data2, data3){
						  alert("http get " + data1 + " - " + data2 + " - " + data3);
					  });
				  }else{ alert("Pas d'autorisation de facebook"); }
			  }, {scope:'email,read_stream,publish_stream,offline_access'});
		return false;
		}
    FB.init({ 
	    appId:'219799788042522', cookie:true, 
	    status:true, xfbml:true, oauth: true,
	    channelURL : 'https://famille.miradou.com/include/fbchannel.php'
	 });
});
