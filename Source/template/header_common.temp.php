<?
if(!defined('PHPHOTPIC'))
	exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ฝากรุปฟรี,อัพโหลดรูป" /> 
<meta name="generator" content="phpHotPic <?=PHPHOTPIC?>" /> 
<meta name="author" content="New Network" /> 
<meta name="copyright" content="2011 New Network" /> 
<link rel="stylesheet" type="text/css" href="<?=$base['config']['url']?>/css/core.css" />
<link rel="stylesheet" type="text/css" href="<?=$base['config']['url']?>/css/uploadify.css" />
<script type="text/javascript" src="<?=$base['config']['url']?>/uploadify/jquery.min.js"></script>
<script type="text/javascript" src="<?=$base['config']['url']?>/uploadify/swfobject.js"></script> 
<script type="text/javascript" src="<?=$base['config']['url']?>/uploadify/jquery.uploadify.min.js"></script>
<title><?=$base['title']?></title>
<script type="text/javascript">
<? if($base['get']['mod']=='index'){ ?>
var cur = 'full';
var htmlfull = '';
var htmlthumb = '';
var bbfull = '';
var bbthumb = '';
$(document).ready(function() {
  $('#img_upload').uploadify({
    'uploader'  : 'uploadify/uploadify.swf',
    'script'    : '<?=$base['name']?>',
    'cancelImg' : 'image/cancel.png',
	'fileExt'	: '*.jpg;*jpeg;*.gif;*.png',
	'fileDesc'	: 'Image Files',
	'sizeLimit'	: <?=$base['config']['maxfilesize']?>,
	'folder':'xIIctt',
	'buttonText':'Select Images',
	'multi'		: true,
    'auto'      : true,
	'onComplete': function(event,ID,fileObj,response,data){
		eval(response);
		if(cur=='full'){
			$('#allbb').val(bbfull);
			$('#allhtml').val(htmlfull);
		}else{
			$('#allbb').val(bbthumb);
			$('#allhtml').val(htmlthumb);
		}
		
	},
	'onSelect'  : function(event,ID,fileObj){$('#preupload').remove();}
  });
});

function sw(type){
	if(type==1){
		cur = 'full';
		$('#allbb').val(bbfull);
		$('#allhtml').val(htmlfull);
	}else{
		cur = 'thumb';
		$('#allbb').val(bbthumb);
		$('#allhtml').val(htmlthumb);
	}
}
<? } ?>
<? if($base['get']['mod']=='admin'){ ?>
function di(id){
	$.get('index.php',{id:id,mod:'admin',action:'delete'},function(data){$('#dc'+id).html(data);});
}
<? } ?>
function sl(lang){
	sc('lang',lang,365);
	location.reload(true);
}

function sc(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
</script>

</head>