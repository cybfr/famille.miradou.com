/**
 * 
 */
$(".mainFrameTitle").html('Idées de <img alt="cadeau" src="/images/cadeau.png"  style="vertical-align: middle;">');

(function($) {
    $(function() {
        /*
        Carousel initialization
        */
        $('.jcarousel')
            .jcarousel({
                // Options go here
            });

        /*
         Prev control initialization
         */
        $('.jcarousel-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                // Options go here
                target: '-=1'
            });

        /*
         Next control initialization
         */
        $('.jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                // Options go here
                target: '+=1'
            });

        /*
         Pagination initialization
         */
/*        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination({
                // Options go here
            }); */
    });
})(jQuery);
$(document).ready( function(){
	console.log("ajaxGift");
	var ajaxQueryUrl = "https://famille.miradou.com/noel_ajax.php";
	var giftDispIdx=1;
	var giftNbDispItem=3;
	var giftShowItem = function(giftItem){
		$(giftItem).switchClass("giftUnactive","giftActive",0);
			};
	var giftHideItem = function(giftItem){
		$(giftItem).switchClass("giftActive","giftUnactive",0);
	};
	$(".delidea").button({
		icons: {
	    	primary: "ui-icon-trash"
		},
		text: false
	})
	.click(function(){
		var idea = $(this).parent()[0].innerHTML;
		var index = idea.indexOf("<button");
		var newidea = idea.substr(0,index);
		$.post(ajaxQueryUrl + '?action=delidea', {idea: newidea}, function(result){
			if(result){
				var idea;
				idea=decodeURIComponent((this.data + '').replace(/\+/g, '%20')).substring(5);
			}
		},'jsonp')
		.error(function(data1, data2, data3){
			test=data1;
		})
		$(this.parentElement).remove();
	});
	$("#addidea").button({
		icons: {
	    	primary: "ui-icon-check"
		},
			text: false
		})
		.click(function(){
			$.post(ajaxQueryUrl + '?action=addidea', { idea: $('#newgiftidea').val()},function(result){
				if(result) {
					$("#ideaform").before('<li>'+$('#newgiftidea').val()+'<button class="delidea">supprimer cette idée</button></li>');
					$(".delidea").button({
						icons: {
					    	primary: "ui-icon-trash"
						},
						text: false
					})
					.click(function(){
						var idea = $(this).parent()[0].innerHTML;
						var index = idea.indexOf("<button");
						var newidea = idea.substr(0,index);
						$.post(ajaxQueryUrl + '?action=delidea', {idea: newidea}, function(result){
							if(result){
								var idea;
								idea=decodeURIComponent((this.data + '').replace(/\+/g, '%20')).substring(5);
							}
						},'jsonp')
						.error(function(data1, data2, data3){
							test=data1;
						})
						$(this.parentElement).remove();
					});
				}
				$('#newgiftidea').val('Nouvelle idée ?');
			},'jsonp')
			.error(function(data1, data2, data3){
				test=data1;
			})
		});
	
	$("#giftLeft").button({
		icons: {
	    	primary: "ui-icon-arrowthick-1-w"
		},
		text: false
	});
	$("#giftRight").button({
		icons: {
	    	primary: "ui-icon-arrowthick-1-e"
		},
		text: false
	});
});