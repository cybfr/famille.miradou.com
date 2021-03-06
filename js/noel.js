/*   vim: set ts=2:
 *
 * @returns {slotMachine}
 */
var ajaxQueryUrl = "https://famille.miradou.com/noel_ajax.php";

$(document).ready( function(){
	console.log("noel.js");
	function  slotMachine() {
		var date = new Date();
		var txtFile = "Tirage du " + date.toLocaleString() + "\n";

		var gift;
		var drawers=0;
		var dialog = $('<div id="message"></div>')
		.dialog({
			autoOpen: false,
			title: 'Texte',
			width: 480
		});
			
		dialog.html("<ul/>");
		this.build = function(){
			$.get(ajaxQueryUrl + "?action=reqids", function(famille, textStatus, jqXHR){
				drawers = famille;
				for(member in drawers){
					$('<div/>')
							.addClass('id_frame')
							.html('<img src=/images/fmly_ids.png alt="'+member+'"style="margin-top: -' + (896-896+parseInt(drawers[member].pictureIdx)) + 'px"></img>')
							.appendTo("#drawers");
					$("<div/>")
							.addClass('id_frame')
							.html('<img src=/images/fmly_ids.png alt="unknown" id="' + drawers[member].id + '_gift" class="unknownid"></img>')
							.appendTo("#drawn");
				}
			}, 'jsonp');
			$( "#draw, #reset, #opener, #file").button();
			$( "#drawLastLastYear, #drawLastYear").button();
			$( "#reset, #opener").hide();
			$( "#draw" ).click( this.draw );
			$( "#drawLastLastYear" ).click( this.draw );
			$( "#drawLastYear" ).click( this.draw );
			$( "#reset" ).click( this.reset );
			$( "#opener" ).click( this.text );
			$( "#file" ).on('click', function(event) {
				mySlot.file(); 
			});
		};
	/**
	 * @returns {Boolean}
	 */
		this.draw= function(){
			$.get(ajaxQueryUrl + "?action=" + "req" + this.id, 
				function(data){
					jQuery.easing.def = "easeOutElastic";
					gift = eval(data);
					var drawer=null;
					for( drawer in drawers){
						if(typeof gift[drawer] != 'undefined'){
							txtFile = txtFile + "\n" + drawers[drawer].firstname + " fait un cadeau à " + drawers[gift[drawer]].firstname;
							$('#message ul').append( "<li><b>" + drawers[drawer].firstname + "</b> fait un cadeau à <b>" + drawers[gift[drawer]].firstname + "</b></li>");
							$( "#" + drawers[drawer].id + "_gift").switchClass( 'unknownid', gift[drawer], 8000,'easeOutBounce', function(){});
						}
					}
					$(".id_frame > img").promise().done(function(){
						$( "#reset, #opener" ).button("enable");
						$( "#reset, #opener, #file" ).show();						
						$("#draw, #drawLastLastYear, #drawLastYear").hide();
					});
				}, 'jsonp');
			$( "#draw, #drawLastLastYear, #drawLastYear" ).button("disable");
			return false; 
		};
		this.reset = function(){
			$.get(ajaxQueryUrl + "?action=resetdraw", 
					function(data){
			}, 'jsonp');
			$( "#reset, #opener" ).button("disable");
			for(member in drawers){
//				$( "#" + drawers[member].id + "_gift" ).attr('style','background-position: 0 0;');
				$('.'+member).switchClass(member,'unknownid');
				$( "#draw, #drawLastLastYear, #drawLastYear" ).button("enable");
			}
			$(".id_frame > img").promise().done(function(){
				$( "#reset, #opener, #file" ).hide();
				$( "#draw, #drawLastLastYear, #drawLastYear" ).show();
					dialog.html('<ul></ul>');
			});
			return(false);
		};
		this.text = function(){
			dialog.dialog('open');
			return false;
		};
		this.file = function(){
		    var downloadLink = document.createElement("a");
		    downloadLink.href = 'data:text/rtf;charset=utf-8,' + encodeURIComponent(txtFile);
		    downloadLink.download = "Resultat du tirage du " + date.toLocaleString() + ".txt";
		    var t=document.createTextNode("Resultat du tirage du " + date.toLocaleString() + ".txt");
		    downloadLink.appendChild(t);
		    document.body.appendChild(downloadLink);
		    
		    downloadLink.click();
		    return false;
//		    document.body.removeChild(downloadLink);
		};
	}
	var mySlot = new slotMachine;
	mySlot.build();
});
