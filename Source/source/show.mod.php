<?php

if(!defined('PHPHOTPIC'))
	exit('Access Denied');

$base['get']['id'] = intval($base['get']['id']);
$image = $db->first("SELECT * FROM {$base['config']['db']['pre']}images WHERE id={$base['get']['id']} LIMIT 1");

if(!$image)
	error_report($base['lang']['image_not_exist']);

$db->query("UPDATE {$base['config']['db']['pre']}images SET views=views+1 WHERE id={$base['get']['id']} LIMIT 1");

$base['title'] = 'Show image ' . $image['originalname'];

$size = getimagesize($base['dir'] . '/i/' . $image['filename'] . $image['extension']);
$sizew = $size[0];
$other = "";
if($sizew > 800){
$sizeh = ceil($size[1]*800/$sizew);
$other = " width='800' height='{$sizeh}'";
}

$base['imagename'] = $image['originalname'];
$base['imageviews'] = $image['views'] + 1;
$base['imagedate'] = convertdate($image['time']);

$base['show'] = '<img src="' . $base['config']['url'] . '/i/'. $image['filename'] . $image['extension'] .'" alt="'.htmlspecialchars($image['originalname']).'"' . $other . ' />';

$base['isthumb'] = $image['isthumb'];

$base['direct_url1'] = getlink('show', array($image['id'],'&amp;'));
$base['direct_url2'] = $base['config']['url'] . '/i/' . $image['filename'] . $image['extension'];

$base['bb_full'] = '[url=' . getlink('show', array($image['id'],'&amp;')) . '][img]' .  $base['config']['url'] . '/i/' . $image['filename'] . $image['extension'] . '[/img][/url]';
$base['bb_thumb'] = '[url=' . getlink('show', array($image['id'],'&amp;')) . '][img]' .  $base['config']['url'] . '/i/' . $image['filename'] . '.th' . $image['extension'] . '[/img][/url]';

$base['html_full'] = '&lt;a href=&quot;' . getlink('show', array($image['id'],'&amp;')) . '&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;' . $base['config']['url'] . '/i/' . $image['filename'] . $image['extension'] . '&quot; alt=&quot;Host by ' . $_SERVER['HTTP_HOST'] . '&quot; /&gt;&lt;/a&gt;';
$base['html_thumb'] = '&lt;a href=&quot;' . getlink('show', array($image['id'],'&amp;')) . '&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;' . $base['config']['url'] . '/i/' . $image['filename'] . '.th' . $image['extension'] . '&quot; alt=&quot;Host by ' . $_SERVER['HTTP_HOST'] . '&quot; /&gt;&lt;/a&gt;';

unset($image);

template('show');

?>