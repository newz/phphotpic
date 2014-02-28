<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<? template('header_common'); ?>
<body>
<div id="main">
<? template('header'); ?>

<div class="center">
<h2><?=$base['imagename']?></h2>
<?=$base['show']?><br />
</div>
<div id="imagedetail">
<?=$base['lang']['image_views']?>: <?=$base['imageviews']?><br />
<?=$base['lang']['image_upload']?>: <?=$base['imagedate']?><br />
<?=$base['lang']['code_direct_url']?><br />
<input onMouseOver="this.select();" name="" type="text" value="<?=$base['direct_url1']?>" readonly="true" /><br />
<input onMouseOver="this.select();" name="" type="text" value="<?=$base['direct_url2']?>" readonly="true" /><br />
<?=$base['lang']['code_bb_full']?><br />
<input onMouseOver="this.select();" name="" type="text" value="<?=$base['bb_full']?>" readonly="true" /><br />
<? if($base['isthumb']){ ?>
<?=$base['lang']['code_bb_thumb']?><br />
<input onMouseOver="this.select();" name="" type="text" value="<?=$base['bb_thumb']?>" readonly="true" /><br />
<? } ?>
<?=$base['lang']['code_html_full']?><br />
<input onMouseOver="this.select();" name="" type="text" value="<?=$base['html_full']?>" readonly="true" /><br />
<? if($base['isthumb']){ ?>
<?=$base['lang']['code_html_thumb']?><br />
<input onMouseOver="this.select();" name="" type="text" value="<?=$base['html_thumb']?>" readonly="true" /><br />
<? } ?>
</div>
</div>
<? template('footer'); ?>
</body>
</html>