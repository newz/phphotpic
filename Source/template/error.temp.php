<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpHotPic - Error: <?=$base['title']?></title>
<style type="text/css">
div{
	width:600px;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
}
#error{
	margin:20px auto 0 auto;
	padding:10px 20px;
	background:#F00;
	color:#FFF;
	text-align:center;
}
#content{
	margin:5px auto 0 auto;
	padding:20px;
	background:#CF6;
}
#copyright{
	margin:5px auto 0 auto;
	text-align:center;
}
h1{
	margin:0;
	padding:0;
}
</style>
</head>
<body>
<div id="error">
<h1>Error</h1>
</div>
<div id="content">
<?=$base['text']?>
</div>
<div id="copyright">
Powered by: phpHotPic <?=PHPHOTPIC?><br />
Copyright &copy; <a href="http://necz.net/" target="_blank">New Network</a> 2011
</div>
</body>
</html>