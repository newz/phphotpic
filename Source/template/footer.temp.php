<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<div id="credit">
<?=$base['lang']['stats_processed_in']?> <?=(microtime()-$base['time_start'])?> <?=$base['lang']['stats_seconds']?> ,<?=$base['lang']['stats_powered_by']?> <a href="http://necz.net/2011/03/phphotpic/" target="_blank">phpHotPic</a> <?=PHPHOTPIC?> &copy; <a href="http://necz.net" target="_blank">New Network</a>
</div>