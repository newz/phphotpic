<?

if(!defined('PHPHOTPIC'))
	exit('Access Denied');

if (empty($_FILES))
	exit('');

$tempfile = $_FILES['Filedata']['tmp_name'];
$targetpath = $base['dir'] . '/i/';

$fullname = addslashes($_FILES['Filedata']['name']);

$md5 = md5_file($tempfile);
$filesize = filesize($tempfile);

if($filesize >= $base['config']['maxfilesize'])
	exit("alert('" . $base['lang']['error_file_too_big'] . "');");


$extension = strtolower(strrchr($_FILES['Filedata']['name'],'.'));
$exarray = array('.png','.jpeg','.jpg','.gif');
if(!in_array($extension, $exarray))
	exit("alert('" . $base['lang']['error_file_type'] . "');");


$size = getimagesize($tempfile);

$sizew = $size[0];
$sizeh = $size[1];

$image = $db->first("SELECT * FROM {$base['config']['db']['pre']}images WHERE md5='{$md5}' AND size='{$filesize}'");
if($image){
	$img = img($image['id'], $base['config']['url'].'/i/'.$image['filename'] ,$image['extension'],$image['isthumb']);	
	
	$sitename = $_SERVER['HTTP_HOST'];
	
	$con1 = "$('#rezone').before('$img');";
	$con2 = '[url=' . getlink('show', array($image['id'],'&')) . '][img]'.$base['config']['url'].'/i/'.$image['filename'].$image['extension'].'[/img][/url]\r\n';
	$con2 = "bbfull+='{$con2}';";
	$con3 = '<a href="' . getlink('show', array($image['id'],'&amp;')) . '"><img src="'.$base['config']['url'].'/i/'.$image['filename'].$extension.'" alt="Host by ' . $sitename . '" /></a><br />\r\n';
	$con3 = "htmlfull+='{$con3}';";
	$con4 = '[url=' . getlink('show', array($image['id'],'&')) . '][img]'.$base['config']['url'].'/i/'.$image['filename'].($image['isthumb']?'.th':'').$extension.'[/img][/url]\r\n';
	$con4 = "bbthumb+='{$con4}';";
	$con5 = '<a href="' . getlink('show', array($image['id'],'&amp;')) . '"><img src="'.$base['config']['url'].'/i/'.$image['filename'].($image['isthumb']?'.th':'').$extension.'" alt="Host by ' . $sitename . '" /></a><br />\r\n';
	$con5 = "htmlthumb+='{$con5}';";
	
echo $con1.$con2.$con3.$con4.$con5;
exit();
}

$name = randomstr(1);

$targetfile = $targetpath.$name.$extension;

while(file_exists($targetfile)){
	$name .= randomstr(1);
	$targetfile = $targetpath.$name.$extension;
}

move_uploaded_file($tempfile,$targetfile);

$thumb = 0;

if($sizew>180||$sizeh>180){
	thumbnails($targetfile,$sizew,$sizeh,$targetpath.$name.'.th'.$extension,$filesize,$extension);
	$thumb = 1;
}


$now = time();

$db->query("INSERT INTO {$base['config']['db']['pre']}images (ip,time,md5,size,filename,originalname,extension,isthumb) VALUES ('{$_SERVER[REMOTE_ADDR]}','{$now}','{$md5}','{$filesize}','{$name}','{$fullname}','{$extension}','{$thumb}')");

$lastid = $db->last_id();

$img = img($lastid,$base['config']['url'].'/i/'.$name,$extension,$thumb);

$sitename = $_SERVER['HTTP_HOST'];

$con1 = "$('#rezone').before('$img');";
$con2 = '[url=' . getlink('show', array($lastid,'&')) . '][img]'.$base['config']['url'].'/i/'.$name.$extension.'[/img][/url]\r\n';
$con2 = "bbfull+='{$con2}';";
$con3 = '<a href="' . getlink('show', array($lastid,'&amp;')) . '"><img src="'.$base['config']['url'].'/i/'.$name.$extension.'" alt="Host by ' . $sitename . '" /></a><br />\r\n';
$con3 = "htmlfull+='{$con3}';";
$con4 = '[url=' . getlink('show', array($lastid,'&')) . '][img]'.$base['config']['url'].'/i/'.$name.($thumb?'.th':'').$extension.'[/img][/url]\r\n';
$con4 = "bbthumb+='{$con4}';";
$con5 = '<a href="' . getlink('show', array($lastid,'&amp;')) . '"><img src="'.$base['config']['url'].'/i/'.$name.($thumb?'.th':'').$extension.'" alt="Host by ' . $sitename . '" /></a><br />\r\n';
$con5 = "htmlthumb+='{$con5}';";

echo $con1.$con2.$con3.$con4.$con5;

?>