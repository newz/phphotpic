<?

if(!defined('PHPHOTPIC'))
	exit('Access Denied');

function error_report($text,$title=''){
	global $base;
	if($title)
		$base['title'] = $title;
	elseif(strlen($text)>50)
		$base['title'] = substr($text,0,50);
	else
		$base['title'] = $text;
	$base['text'] = $text;
	template('error');
	exit();
}

function paddslashes($data) {
	if(is_array($data)) {
		foreach($data as $key => $val) {
			$data[paddslashes($key)] = paddslashes($val);
		}
	} else {
		$data = str_replace('\"','"',addslashes($data));
	}
	return $data;
}

function getlink($type, $parameter){
	global $base;
	switch ($type){
		case 'show':
			return !$base['config']['rewrite']['show'] ? $base['config']['url'] . '/index.php?mod=show'.$parameter[1].'id=' . $parameter[0] : $base['config']['url'] . '/show/' . $parameter[0];
    	    break;
	}
}

function template($name){
	global $base;
	require_once $base['dir'] . 'template/' . $name . '.temp.php';
}

function lang_set(){
	global $all_lang;
	echo '<ul id="language">';
	foreach($all_lang as $lang=>$value){
		echo '<li><a href="javascript:;" onClick="sl(\'' . $lang . '\')">' . $value . '</a></li>';
	}
	echo '</ul>';
}

function img($dirurl,$dirname,$ex,$thumb,$isadmin='',$ip='',$time='',$views=''){
	global $base;
	$sitename = $_SERVER['HTTP_HOST'];

	$img = '<div class="showimage">';
	$img .= '<div class="display">';
	$img .= '<a href="' . getlink('show', array($dirurl,'&amp;')) . '" target="_blank"><img src="' . $dirname . ($thumb?'.th':'') . $ex . '" alt="Host by ' . $sitename . '" /></a>';
	if($isadmin){
		$img .= '<br />IP: ' . $ip . '<br />' . convertdate($time) . ', ' . $base['lang']['image_views'] . ' ' . $views . ' <a href="javascript:;" id="dc' . $dirurl . '" onClick="di(' . $dirurl . ')">' . $base['lang']['delete'] . '</a>';
	}
	$img .= '</div>';
	$img .= '<div class="imgcode"><span>' . $base['lang']['code_direct_url'] . '</span><br />';
	$img .= '<input onmouseover="this.select();" name="" type="text" value="' . getlink('show', array($dirurl,'&amp;')) . '" readonly="true" /><br />';
	$img .= '<input onmouseover="this.select();" name="" type="text" value="' . $dirname . $ex . '" readonly="true" /><br />';
	$img .= '<span>' . $base['lang']['code_bb_full'] . '</span><br />';
	$img .= '<input onmouseover="this.select();" name="" type="text" value="[url=' . getlink('show', array($dirurl,'&amp;')) . '][img]' . $dirname .  $ex . '[/img][/url]" readonly="true" /><br />';
	if($thumb){
		$img .= '<span>' . $base['lang']['code_bb_thumb'] . '</span><br />';
		$img .= '<input onmouseover="this.select();" name="" type="text" value="[url=' . getlink('show', array($dirurl,'&amp;')) . '][img]' . $dirname . '.th' . $ex . '[/img][/url]" readonly="true" /><br />';
	}
	$img .= '<span>' . $base['lang']['code_html_full'] . '</span><br />';
	$img .= '<input onmouseover="this.select();" name="" type="text" value="&lt;a href=&quot;' . getlink('show', array($dirurl,'&amp;amp;')) . '&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;' . $dirname . $ex . '&quot; alt=&quot;Host by ' . $sitename . '&quot; /&gt;&lt;/a&gt;" readonly="true" /><br />';
	if($thumb){
		$img .= '<span>' . $base['lang']['code_html_thumb'] . '</span><br />';
		$img .= '<input onmouseover="this.select();" name="" type="text" value="&lt;a href=&quot;' . getlink('show', array($dirurl,'&amp;amp;')) . '&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;' . $dirname . '.th' . $ex . '&quot; alt=&quot;Host by ' . $sitename . '&quot; /&gt;&lt;/a&gt;" readonly="true" />';
	}
	$img .= '</div>';
	$img .= '</div>';

	return $img;
}

function convertdate($timestamp){
	global $base;
	$timestamp2 = time() - $timestamp;
	if($timestamp2 == 0){
		return $base['lang']['time_now'];
	}elseif($timestamp2 < 60){
		return $timestamp2 . ' ' . $base['lang']['time_second'] . $base['lang']['time_ago'];
	}elseif($timestamp2 < 3600){
		return floor($timestamp2/60) . ' ' . $base['lang']['time_minutes'] . $base['lang']['time_ago'];
	}elseif($timestamp2 < 86400){
		return floor($timestamp2/3600) . ' ' . $base['lang']['time_hour'] . $base['lang']['time_ago'];
	}elseif($timestamp2 < 604800){
		return floor($timestamp2/86400) . ' ' . $base['lang']['time_day'] . $base['lang']['time_ago'] . ' ' . gmdate("H:i",$timestamp+$base['config']['timezone']);
	}else{
		return gmdate("d/m/y H:i",$timestamp+$base['config']['timezone']);
	}
}

function page($item,$curpage,$perpage,$deurl,$pageurl){
	$page = ceil($item/$perpage);
	$re = '<ul class="page">';
	if($page>$curpage){
		$re .= '<li><a href="' . $deurl.str_replace('[page]',$curpage+1,$pageurl).'">&raquo;</a></li>';
	}
	if($page>1){
		$re .= '<li><a href="' . $deurl.str_replace('[page]',$page,$pageurl).'">' . $page.'</a></li>';
	}
	$i = $curpage+3;
	if($i>=$page){
		$i=$page-1;
	}
	$max = $i-6;
	if($curpage<6&&$page>6){
		$i += 5-$curpage;
	}
	if($i>=$page){
		$i=$page-1;
	}
	if($page-$curpage>4){
		$re .= '<li>...</li>';
	}
	while(($i>=2)&&($i>=$max)){
		$re .= '<li><a href="' . $deurl.str_replace('[page]',$i,$pageurl).'">' . $i.'</a></li>';
		$i--;
	}
	if($curpage>5&&$page>9){
		$re .= '<li>...</li>';
	}
	$re .= '<li><a href="' . $deurl.'">1</a></li>';
	if($curpage>1){
		if($curpage==2){
			$re .= '<li><a href="' . $deurl.'">&laquo;</a></li>';
		}else{
			$re .= '<li><a href="' . $deurl.str_replace('[page]',$curpage-1,$pageurl).'">&laquo;</a></li>';
		}
	}
	$re .= '</ul>';
	return $re;
}

function randomstr($length)
{
	$possible = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ9876543210";
	$str = "";
	while(strlen($str) < $length)
	{
		$str = 	$str. substr($possible,(rand()%strlen($possible)),1);
	}
		return $str;
}

function thumbnails($img,$w,$h,$dir,$size,$ex)
{
	global $base;
	require_once $base['dir'] . 'source/thumb/ThumbLib.inc.php';
	$thumb = PhpThumbFactory::create($img);
	$thumb->resize(180,180);
	$text = $w."x".$h." ".calculateSize($size)." ".substr($ex, 1).' ' . $base['config']['sitename']; 
	if($w>=$h){
		$thumb->writestr($text,$h*$per/100);
	}else{
		$thumb->writestrup($text,$w*$per/100);
	}
		$thumb->save($dir);
	chmod($dir,0777);

}

function calculateSize($size, $sep = '')
{
	$units = array('B', 'K', 'M', 'G', 'T');
 
	for($i = 0, $c = count($units); $i < $c; $i++)
	{
		if ($size > 1024)
		{
			$size = $size / 1024;
		}
		else
		{
			$unit = $units[$i];
			break;
		}
	}
 
	return round($size, 2).$sep.$unit;
}

?>