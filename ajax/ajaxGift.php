<?php
session_start ();
spl_autoload_register ( function ($class) {
	include 'classes/' . $class . '.php';
} );
$realm = new FamilyRealm ();
$currentUser = new MiradouAuth ( $realm );
$my = new Family ( $currentUser );
$myideas = new GiftIdeas ( $currentUser );
$members = $realm->getMembers ();
if (isset ( $_SESSION ['miUser'] )) {
	$giftUser = unserialize ( $_SESSION ['miUser'] );
	$giftUserFirstname = $giftUser->firstname;
} else {
	$giftUser = "";
	$giftUserFirstname = "";
}
?>
<style type="text/css" scoped>
ul.giftlist {
	display: inline-block;
	padding-left: 15px;
}

ul.nameList {
	display: inline-block;
	padding: 0;
}

.giftlist li {
	text-align: left;
	font-size: 9pt;
	margin: 3px;
	padding: 3px;
	color: gray;
	min-height: 2em;
	min-width: 16em;
}

li.nameList {
	display: inline-block;
	max-width: 17em;
	text-align: center;
	vertical-align: top;
	margin: 1em 1px 0 1px;
	background-color: whitesmoke;
}

#newgiftidea {
	text-align: left;
	font-size: 9pt;
	color: gray;
	height: 3em;
	width: 86%;
	margin: 0px;
	padding: 0px;
}

#ideaform {
	padding-top: 1px;
	padding-bottom: 1px;
}

li button {
	float: right;
	height: 20px;
}

button.ui-button-icon-only {
	width: 18px;
}

.giftActive {
	display: inline-block;
}

.giftUnactive {
	display: none !important;
}

/*
This is the visible area of you carousel.
Set a width here to define how much items are visible.
The width can be either fixed in px or flexible in %.
Position must be relative!
*/
.jcarousel {
	display: inline-block;
	position: relative;
	overflow: hidden;
	max-width: 1096px;
}

/*
This is the container of the carousel items.
You must ensure that the position is relative or absolute and
that the width is big enough to contain all items.
*/
.jcarousel>ul {
	width: 20000em;
	position: relative;
	/* Optional, required in this case since it's a <ul> element */
	list-style: none;
	margin: 0;
	padding: 0;
}

/*
These are the item elements. jCarousel works best, if the items
have a fixed width and height (but it's not required).
*/
.jcarousel>ul>li {
	/* Required only for block elements like <li>'s */
	float: left;
	width: 212px;
	margin: 4px;
}

li ul {
	display: inline-block;
	list-style-type: square;
}

li ul li {
	min-width: 20%;
	display: list-item;
}

button.jcarousel-control-prev, button.jcarousel-control-next {
	vertical-align: top;
}
</style>
<?php
if (! isset ( $_SERVER ['HTTP_REFERER'] )) {
	?>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<?php
}
?>
<script type="text/javascript">
<!--
$('.mainFrameFooter').html('');
//-->
</script>
<script type="text/javascript" src="/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="/js/gift.js"></script>
<button id="giftLeft" class="jcarousel-control-prev">&lsaquo;</button>
<div class="jcarousel">
	<ul class="nameList">

<?php
$idx = 0;
foreach ( $members as $member ) {
	$idx ++;
	$myideas = new GiftIdeas ( $member );
	?>
<li class="nameList" id="giftList<?=$idx?>"><?=$member->firstname?>
  <ul class="giftlist">
<?php   foreach( $myideas->getIdeas() as $idea ){ ?>
  <li class="giftlist"><?=$idea?>
  <?php
		if ($giftUserFirstname == $member->firstname) {
			?>
<button class="delidea">supprimer cette idée</button>
<?php } ?>
</li>
<?php
	
}
	?>
<?php

	
if ($giftUserFirstname == $member->firstname) {
		?>
    <li id="ideaform"><textarea id=newgiftidea class="ui-widget"
						placeholder="Nouvelle idée ?"></textarea>
					<button id="addidea">Ajouter cette idée</button></li>
<?php }?>
 </ul></li>
<?php
}
?>
</ul>

</div>
<span class="giftlist"><button id="giftRight"
		class="jcarousel-control-next">&rsaquo;</button></span>