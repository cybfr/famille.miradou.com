<?php 
session_start();
spl_autoload_register(function ($class) {
	include 'classes/' . $class . '.php';
});
$giftUser =	unserialize($_SESSION['miUser']);
?>
<style type="text/css" scoped>
dl.giftlist{
	text-align: center;
	border: 1px solid silver;
	width: 20%;
	vertical-align: top;
	border-radius: 4px;
	margin:	1em 1px 0 1px;
}
.giftlist dt{
	font-weight: bold;
	border-bottom: 1px solid silver;
/* 	background-image: url(/images/fmly_ids.png); */
/* 	background-repeat: no-repeat; */
/* 	background-position: 128px -128px; */
}
.giftlist dd{
	text-align: left;
 	background-color: #eee;
 	border: 1px solid silver;
	background: -webkit-linear-gradient(top, #eeeeee,#FAFAFA); 	
 	border-radius: 3px;
 	font-size: 9pt;
 	margin: 5px;
 	padding: 5px;
 	color: gray;
 	min-height: 2em;
}
dl.giftlist span.id_frame{
	vertical-align: middle;
	margin-left: 1em;
}

#newgiftidea {
	text-align: left;
	border-radius: 3px;
	font-size: 9pt;
	color: gray;
	border: 0px solid silver;
	height: 3em;
	width: 86%;
	margin: 0px;
	padding: 0px;
}
#ideaform{
	padding-top: 1px;
	padding-bottom: 1px;
}
dd button{
	float: right;
	height: 20px;
}
span.giftlist {
	margin-top: 1em;
	display: inline-block;
	}
button.ui-button-icon-only { width: 20px; }
.giftActive { display: inline-block;}
.giftUnactive { display: none;}
 
</style>

<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>

<script type="text/javascript">
$(".mainFrameTitle").html('Idées de <img alt="cadeau" src="/images/cadeau.png"  style="vertical-align: middle;">');


$(document).ready( function(){
	console.log("ajaxGift");
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
		$.post(ajaxQueryUrl + '?action=delidea', {idea: $(this).parent()[0].childNodes[1].data}, function(result){
			if(result){
				var idea;
				alert(this.data);
				idea=decodeURIComponent((this.data + '').replace(/\+/g, '%20')).substring(5);
				$("dd:contains("+idea+")").last().remove();
				alert('ok');
			}
		})
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
					$("#ideaform").before('<dd>'+$('#newgiftidea').val()+'</dd>');
				}
				$('#newgiftidea').val('Nouvelle idées ?');
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
	})
	.click(function(){
		giftDispIdx-=1;
		$("#giftRight").switchClass("giftUnactive","giftActive",0);
		if(giftDispIdx == 1){
			giftHideItem("#giftLeft");
		}
		giftShowItem("#giftList" + giftDispIdx);
		giftHideItem("#giftList" + (giftDispIdx+giftNbDispItem));
		return false;
	});
	$("#giftRight").button({
		icons: {
	    	primary: "ui-icon-arrowthick-1-e"
		},
		text: false
	})
	.click(function(){
		if(giftDispIdx == 15-giftNbDispItem){ giftHideItem("#giftRight"); }
		$("#giftLeft").switchClass("giftUnactive","giftActive",0);
		giftHideItem("#giftList" + giftDispIdx);
		giftShowItem("#giftList" + (giftDispIdx+giftNbDispItem));
		giftDispIdx+=1;
		return false;			
	});
});
</script>

<dl class="giftlist giftActive" id="giftlist0"><dt>
	<span><?=$giftUser->firstname?></span>
</dt>
<dd id="ideaform"><textarea id=newgiftidea class="ui-widget">Nouvelle idée</textarea>
	<button id="addidea">Ajouter cette idée</button>
	</dd>
<?php
$myideas = new GiftIdeas($giftUser);
foreach ($myideas->getIdeas() as $key=>$value){
?>	<dd><button class="delidea">supprimer cette idée</button>'<?=$value?>'</dd>	<?php 
};	
?>
</dl>
<span class="giftlist"><button id="giftLeft" class="giftUnactive">&lt;</button></span>
<?php 
$idx=0;
foreach (array(
		"Maman" => "dd",
		"Marie-Anne" => "dd",
		"Didier" => ",klklm",
		"Marie-Do" => "sdqs",
		"Marc" => "klmmlk",
		"Clotilde" => "kjkljl",
		"Christophe" => "jklkjl",
		"Marie-Hélène" => "kljlkl",
		"François-Régis" => "kjkljl",
		"Marie-Pascale" => "kjkljl",
		"Rémi" => "kjkljl",
		"Marie-Agnès" => "kjkljl",
		"Emmanuel" => "kjkljl",
		"Savine" => "kjkljl",
		"Laurent" => "kjkljl"
) as $key => $value) {
	$modeDisplay = (++$idx > 3) ? "giftUnactive" : "giftActive";
?>
<dl class="giftlist <?=$modeDisplay?>" id="giftList<?=$idx?>">
<dt><span><?=$key?></span></dt>
  <dd>Etiam ultricies mauris ut lectus consectetur elementum.</dd>
  <dd>Sed convallis volutpat turpis, at mattis diam elementum non.</dd>
  <dd>Sed viverra laoreet neque, eget tincidunt nisl adipiscing nec.</dd>
  <dd>Donec sit amet sapien enim, sit amet vulputate velit.</dd>
  <dd>Curabitur nec sem vitae est porta suscipit.</dd>
  <dd>Curabitur volutpat nisi quis risus lobortis luctus.</dd>
</dl>
<?php 
}?>
<span class="giftlist"><button id="giftRight" class="giftActive">&gt;</button></span>
