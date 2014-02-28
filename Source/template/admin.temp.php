<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<? template('header_common'); ?>
<body>
<div id="main">
<? template('header'); ?>
<div id="content">
<?=$base['pages']?><br />
<?=$base['showimages']?><br />
<?=$base['pages']?><br />
</div>
<div id="leftmenu">
<?=$base['lang']['admin_cp']?><br />
<a href="index.php?mod=admin&amp;action=logout"><?=$base['lang']['logout']?></a>
</div>
</div>
<? template('footer'); ?>
</body>
</html>