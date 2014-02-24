<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<? template('header_common'); ?>
<body>
<div id="main">
<? template('header'); ?>
<div id="content">
<div id="allcode">
<?=$base['lang']['all_bbcode_htmlcode']?> | 
<a href="javascript:;" onClick="sw(1);"><?=$base['lang']['image_full']?></a> <a href="javascript:;" onClick="sw(2);"><?=$base['lang']['image_thumb']?></a>
<div>
<textarea name="allbb" id="allbb" onmouseover="this.select();"></textarea>
<textarea name="allhtml" id="allhtml" onmouseover="this.select();"></textarea>
</div>
</div>
<div id="rezone"></div>
</div>
<div id="leftmenu">
<input id="img_upload" name="img_upload" type="file" />
<img src="image/click.jpg" alt="upload" id="preupload" />
</div>
</div>
<? template('footer'); ?>
</body>
</html>