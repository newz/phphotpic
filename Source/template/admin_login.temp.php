<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<html>
<head>
<title><?=$base['lang']['admin_login']?></title>
<? if($base['loginsuccess']||$base['logoutsuccess']){ ?>
<meta http-equiv="refresh" content="1">
<? } ?>
</head>
<body>
<div style="padding-top:100px;text-align:center;">
<? if($base['blacklist']){ 
	echo $base['lang']['blacklist'];
}elseif($base['loginsuccess']){ 
	echo $base['lang']['login_success'];
}elseif($base['logoutsuccess']){ 
	echo $base['lang']['logout_success'];
}else{ ?>
<?=$base['lang']['admin_login']?><br />
<form action="index.php?mod=admin" method="post">
<input name="pass" type="password"><input name="" type="submit" value="<?=$base['lang']['admin_login']?>">
</form>
<? } ?>
</div>
</body>
</html>