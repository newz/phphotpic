<?php

	$error = '';
	if(!@fopen("../data/test.txt", "w")){
		$error .= 'ไม่สามารถเขียนโฟลเดอร์ /data ได้ โปรดตรวจสอบ<br />';
		$file_write = 1;
	}
	if(!@fopen("../i/test.txt", "w")){
		$error .= 'ไม่สามารถเขียนโฟลเดอร์ /i ได้ โปรดตรวจสอบ<br />';
		$file_write = 1;
	}

if(isset($_POST['data_submit'])){	
	if(!$error){
		if(!@mysql_connect($_POST['data_dbhost'],$_POST['data_dbuser'],$_POST['data_dbpass'])){
			$error .= 'ไม่สามารถเชื่อต่อกับฐานข้อมูล<br />';
		}
		if(!@mysql_select_db($_POST['data_dbname'])){
			$error .= 'ไม่สามารถเลือกฐานข้อมูล<br />';
		}
		if($_POST['data_password']!=$_POST['data_repassword']){
			$error .= 'รหัสผ่านไม่ตรงกัน<br />';
		}
	}
	if(!$error){
		
		$sql1 = file_get_contents('sql1.txt');
		$sql1 = str_replace(array('[pre]','[char]'),array($_POST['data_dbpre'],$_POST['data_dbcharset']),$sql1);

		$sql2 = file_get_contents('sql2.txt');
		$sql2 = str_replace(array('[pre]','[char]'),array($_POST['data_dbpre'],$_POST['data_dbcharset']),$sql2);
		
		if(@mysql_query($sql1)&&@mysql_query($sql2)){
			$_POST['data_rewriteurl'] = intval($_POST['data_rewriteurl']);
			$_POST['data_password'] = sha1(sha1($_POST['data_password']));
	
			$config = file_get_contents('config.txt');
			$config = str_replace(array_keys($_POST),$_POST,$config);
	
			$handle = fopen("../data/config.php", "w");
			fwrite($handle,$config);
			fclose($handle);
			
			@unlink("../data/test.txt");
			@unlink("../i/test.txt");

			$success = 1;
		}else{
			$error .= 'ไม่สามารถสร้างตารางข้อมูลได้<br />' . mysql_error();
		}
		
	}
	
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Install</title>
<style type="text/css">
body{
	font-size:16px;
	font-family:Tahoma, Geneva, sans-serif;
}
.detail{
	font-size:12px;
	color:#666;
}
#main{
	width:500px;
	margin:0 auto;
}
input{
	width:100%;
	height:24px;
	font-size:20px;
	color:#666;
}
input:focus{
	color:#000;
}
a{
	text-decoration:none;
	color:#03F;
}
a:hover{
	color:#F60;
}
h1{
	padding:0;
	margin:0;
}
#submit{
	height:30px;
}
#error{
	border:2px solid #F00;
	background:#F93;
	padding:20px;
}
#success{
	border:2px solid green;
	background:#6F6;
	padding:20px;
}
</style>
<? if(!$success){ ?>
<script type="text/javascript">
function ini(){
	var l = window.location + '';
	document.getElementById('websiteurl').value = l.replace('/install/install.php','');
	l = document.domain + '';
	document.getElementById('websitename').value = l;
}
</script>
<? } ?>
</head>
<body onload="ini()">
<div id="main">
<? if($error){ ?>
<div id="error">
<?=$error?>
</div>
<? } ?>
<? if($success){ ?>
<div id="success">
ติดตั้งสำเร็จเรียบร้อยแล้ว<br />
สามารถเข้าหน้าจัดการรูปภาพได้ <a href="<?=$_POST['data_url']?>/index.php?mod=admin">ที่นี่</a><br />
อย่าลืมลบโฟล์เดอร์ install ออกจาก server ด้วยละ<br />
<a href="<?=$_POST['data_url']?>">ไปหน้าแรก</a>
</div>
<? }elseif(!$file_write){ ?>
<h1>กำหนดค่า</h1>
<form action="install.php" method="post">
Database Host:<br />
<span class="detail">โดยทั่วไปคือ localhost</span><br />
<input name="data_dbhost" type="text" value="localhost" />
Database User:<br />
<input name="data_dbuser" type="text" />
Database Password:<br />
<input name="data_dbpass" type="password" />
Database Name:<br />
<input name="data_dbname" type="text" /><br />
Database Prefix:<br />
<span class="detail">ป้องกันชื่อตารางซ้ำกันกรณีใช้ร่วมกัน</span><br />
<input name="data_dbpre" type="text" value="pic_" /><br />
Database Charset:<br />
<input name="data_dbcharset" type="text" value="utf8" /><br />
<br />
Admin Password:<br />
<span class="detail">สำหรับเข้าจัดการรูปภาพ</span><br />
<input name="data_password" type="password" /><br />
Retype Admin Password:<br />
<input name="data_repassword" type="password" /><br />
<br />
Website Name:<br />
<span class="detail">ชื่อเว็บไซต์ จะปรากฏในรูป thumbail</span><br />
<input name="data_sitename" type="text" value="" id="websitename" /><br />
Website URL:<br />
<span class="detail">ใส่ที่อยู่ url เช่น http://www.example.com/uppic ไม่ต้องปิดท้ายด้วย /</span><br />
<input name="data_url" type="text" value="" id="websiteurl" /><br />
Rewrite URL:<br />
<span class="detail">จากเดิม /index.php?mod=show&amp;id=[imgid] เป็น /show/[imgid] ใส่เลข 1 เพื่อเปิดใช้งาน</span><br />
<span class="detail">กรณีเปิดใช้งานกรุณาเปลี่ยนชื่อไฟล์ .htaccess.txt เป็น .htaccess ด้วย</span><br />
<input name="data_rewriteurl" type="text" value="0" /><br />
<br />
Max Image Size:<br />
<span class="detail">ใสเป็นหน่วยไบต์</span><br />
<input name="data_maxfilesize" type="text"  value="2097152"/><br />
<br />
<input name="data_submit" type="submit" id="submit" value="Install Now!" />
</form>
<br />
<br />
<br />
<br />
<br />
<br />
<? } ?>
</div>
</body>
</html>