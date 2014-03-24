<?php include("skeleton.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="Author" content="fvuillemin">
<!-- gift.php created on 24 sept. 2011  14:54:41 CEST -->
<?php html_head(''); ?>
<?php
// Set username and password
$username = 'username';
$password = 'password';
// The message you want to send
$message = "is twittering from php using curl";
// The twitter API address
// $url = "http://twitter.com/statuses/update.xml";
// Alternative JSON version
$url = "http://twitter.com/statuses/update.json";
// Set up and execute the curl process
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, "$url");
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);
// check for success or failure
/* if (empty($buffer)) {
echo "message";
} else {
echo "success";
} */
?>
<style type="text/css">
#newgiftidea {
	text-align: left;
/* 	background: -webkit-linear-gradient(top, rgb(238, 238, 238), rgb(250, 250, 250)); */
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
button.ui-button-icon-only { width: 20px; }
</style>
<title>Idées de cadeaux</title>
</head>
<body>
<?php page_header('idées de <img alt="cadeau" src="/images/cadeau.png"  style="vertical-align: middle;">'); ?>
<div id="containt" style="width:100%; text-align: center;">
<dl class="giftlist" id="giftlist1"><dt>
	<span><?php echo $GLOBALS['currentUser']->firstname; ?></span>
	<span class="id_frame" style="width: 48px; height: 48px; background-position: -7px -<?php echo $GLOBALS['currentUser']->pictureIdx+7;?>px"></span></dt>
<dd id="ideaform"><textarea id=newgiftidea class="ui-widget">Nouvelle idéee</textarea>
	<button id="addidea">Ajouter cette idée</button>
	</dd>
</dl>
<script type="text/javascript">
$.get(ajaxQueryUrl + '?action=getideas', function(ideas){
	for(idea in ideas){
		$('#giftlist1').append('<dd><button class="delidea">supprimer cette idée</button>'+ideas[idea]+'</dd>');
	}
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
		},'jsonp')
		.error(function(data1, data2, data3){
			test=data1;
		});
	});
}, 'jsonp')
.error(function(data1, data2, data3){
	test=data1;
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
		});
	});

</script>
<dl class="giftlist" id="giftlist2"><dt><span>Marie-Agnès</span><span class="id_frame" style="background-position: 0 -1600px"></span></dt>
<dd>Etiam ultricies mauris ut lectus consectetur elementum.</dd>
<dd>Sed convallis volutpat turpis, at mattis diam elementum non.</dd>
<dd>Sed viverra laoreet neque, eget tincidunt nisl adipiscing nec.</dd>
<dd>Donec sit amet sapien enim, sit amet vulputate velit.</dd>
<dd>Curabitur nec sem vitae est porta suscipit.</dd>
<dd>Curabitur volutpat nisi quis risus lobortis luctus.</dd>
</dl>

<dl class="giftlist" id="giftlist3"><dt><select>
<option>Maman</option>
<option>Papa</option>
</select></dt>
<dd>Sed ac odio leo, ut suscipit felis.</dd>
<dd>Cras ac orci id purus commodo gravida.</dd>
<dd>Integer imperdiet elit nec leo pellentesque gravida.</dd>
<dd>Curabitur volutpat nisi quis risus lobortis luctus.</dd>
</dl>

<dl class="giftlist" id="giftlist4"><dt><span>Papa</span><span class="id_frame" style="background-position: 0 -0px"></span></dt>
<dd>Donec nec massa turpis, at dapibus est.</dd>
<dd>Fusce placerat suscipit urna, quis molestie nunc egestas a.</dd>
<dd>Fusce id mauris a velit porttitor adipiscing id eget enim.</dd>
<dd>Nullam malesuada ipsum vel libero iaculis a fringilla dolor pellentesque.</dd>
</dl>
</div>
<?php page_footer(''); ?>
</body>
</html>