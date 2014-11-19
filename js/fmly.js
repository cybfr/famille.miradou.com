/* @version 1.1 fixedMenu
 * @author Lucas Forchino
 * @webSite: http://www.jqueryload.com
 * jquery top fixed menu
 */
var ajaxQueryUrl = "https://famille.miradou.com/noel_ajax.php";
//Used to detect initial (useless) popstate.
//If history.state exists, assume browser isn't going to fire initial popstate.
var popped = ('state' in window.history && window.history.state !== null), initialURL = location.href;

$(window).bind('popstate', function (event) {
	// Ignore inital popstate that some browsers fire on page load
	var initialPop = !popped && location.href == initialURL
	popped = true
	if (initialPop) return;
	 var match,
     pl     = /\+/g,  // Regex for replacing addition symbol with a space
     search = /([^&=]+)=?([^&]*)/g,
     decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
     query  = window.location.search.substring(1);

 urlParams = {};
 while (match = search.exec(query))
    urlParams[decode(match[1])] = decode(match[2]);
 var params = {};
 for(param in urlParams){
	if( param != "page" ) params[param] = urlParams[param];
 }
		$.get("https://famille.miradou.com/ajax/ajax"+location.pathname.substr(1)+".php", params, function(data){
			$('#mainFrameContent').html(data);
			$('title').html(urlParams['page']);
			$("#scrobbler").addClass("hidden");
		})
		.error(function(data1, data2, data3){
			test=data1;
			$('#mainFrameContent').load("/ajax/ajaxError.php?error="+data1.status);
			$("#scrobbler").addClass("hidden");
		});
		$("#scrobbler").removeClass("hidden");
});
$(function() {
	var loadMainContent = function(page, args){
		$.get("https://famille.miradou.com/ajax/ajax"+page+".php", args, function(data){
			$('#mainFrameContent').html(data);
			$('title').html(page);
			history.pushState({},page,"https://famille.miradou.com/"+page);
			$("#scrobbler").addClass("hidden");
		})
		.error(function(data1, data2, data3){
			test=data1;
			$('#mainFrameContent').load("/ajax/ajaxError.php?error="+data1.status);
			$("#scrobbler").addClass("hidden");			
		});
		$("#scrobbler").removeClass("hidden");
	};
	$('.menu > li > a').bind('click',function(){
		var hideMenu = function(){
	    	$('.menu li.active').removeClass('active');
	    	$('body').unbind('click');
//	    	return false;
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
			"Ré-initialer mon mot de passe": function() {
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
		height: 280,
		width: 350,
		modal: true,
		buttons: {
			"Mot de passe oublié ?": function() {
				$( this ).dialog( "close" );
				$('#resetpwquery-form').dialog("open");
			}
		},
		close: function() {}
	});
	$("#Connection").button();
	$("#Connection").click(function(){
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
	    		location.reload();
			}
		},'jsonp')
		.error(function(data1, data2, data3){
				test=data1;
		});
		return(false);
	});
	$( "#milogin" ).click(function() {
    	$('.menu li.active').removeClass('active');
    	$('body').unbind('click');
		$( "#milogin-form" ).dialog( "open" );
		return(false);
	});
	$("#resetpwquery").click( function(){
		return false;
	});
	$("#logout").click(function(){
		$.get(ajaxQueryUrl + "?action=logout", function(){
			$("#loggedmenu").addClass('hidden');
			$("#loginmenu").removeClass('hidden');
			currentUser = null;
			location.reload();
		})
		.error(function(data1,data2,data3){
			var test=data2;
		});
		return(false);
	});
	$("#About").click(function(){
    	$('.menu li.active').removeClass('active');
    	loadMainContent("About");
    	return(false);
	});
	$( "#navmenu li a" ).each(function( index ) {
		  var filename = this.id.substr(0,1).toUpperCase()+
					 this.id.substr(1).toLowerCase();
		  $( "#"+this.id ).click(function(){
		    	$('.menu li.active').removeClass('active');
		    	loadMainContent(filename);
		    	return(false);
		  });
	});
	$("#gglogin").click(function(){ 
    	$('.menu li.active').removeClass('active');
		return false;
	});
	$("#Fblogin").click( myFbLogin );

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
				    		location.reload();
					  	}else{ 
							FB.api('/me', function(reponse){ 
						  		alert( reponse.first_name + " n'est pas autorisé à se connecter à famille@miradou");
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
