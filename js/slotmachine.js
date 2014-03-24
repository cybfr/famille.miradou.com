/**
 * @returns {slotMachine}
 */
$(document).ready( function(){
	
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
//				$("head style").append("	.unknownid{ margin-top: 0;}");
				for(member in drawers){
//					$("head style").append("	." + drawers[member].id +
//							' { margin-top: -'+ (896+parseInt(drawers[member].pictureIdx)) + 'px;}');
					$('<div/>')
							.addClass('id_frame')
							.html('<img src=/id_pictures/famille.png style="margin-top: -' + (896-896+parseInt(drawers[member].pictureIdx)) + 'px"></img>')
							.appendTo("#drawers");
					$("<div/>")
							.addClass('id_frame')
							.html('<img src=/id_pictures/famille.png id="' + drawers[member].id + '_gift" class="unknownid"></img>')
							.appendTo("#drawn");
				}
			}, 'jsonp');
			$( "#draw, #reset, #opener, #file").button();
			$( "#draw2011, #draw2012").button();
			$( "#reset, #opener").hide();
			$( "#draw" ).click( this.draw );
			$( "#draw2011" ).click( this.draw );
			$( "#draw2012" ).click( this.draw );
			$( "#reset" ).click( this.reset );
			$( "#opener" ).click( this.text );
			$( "#file" ).click( this.file );
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
						txtFile = txtFile + "\n" + drawers[drawer].firstname + " fait un cadeau à " + drawers[gift[drawer]].firstname;
						$('#message ul').append( "<li><b>" + drawers[drawer].firstname + "</b> fait un cadeau à <b>" + drawers[gift[drawer]].firstname + "</b></li>");
						$( "#" + drawers[drawer].id + "_gift").switchClass( 'unknownid', gift[drawer], 8000,'easeOutBounce', function(){});
					}
					$(".id_frame > img").promise().done(function(){
						$( "#reset, #opener" ).button("enable");
						$( "#reset, #opener, #file" ).show();						
						$("#draw, #draw2011, #draw2012").hide();
					});
				}, 'jsonp');
			$( "#draw, #draw2011, #draw2012" ).button("disable");
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
				$( "#draw, #draw2011, #draw2012" ).button("enable");
			}
			$(".id_frame > img").promise().done(function(){
				$( "#reset, #opener, #file" ).hide();
				$( "#draw, #draw2011, #draw2012" ).show();
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
		    downloadLink.href = 'data:text/rtf;charset=utf-8,' + escape(txtFile);
		    downloadLink.download = "Resultat du tirage du " + date.toLocaleString() + ".txt";
		    downloadLink.click();
//		    document.body.removeChild(downloadLink);
		};
	}
	var mySlot = new slotMachine;
	mySlot.build();
});
