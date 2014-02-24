<?php
if(!defined('PHPHOTPIC'))
	exit('Access Denied');

$base['get']['id'] = intval($base['get']['id']);
require_once $base['dir'] . 'lang/' . $langset . '/admin.lang.php';
$base['lang'] = array_merge($base['lang'], $lang);
unset($lang);

$base['title'] = 'Admin CP' . ($base['get']['page'] ? ' '.$base['lang']['page'].' '.$base['get']['page'] : '');

$db->query('DELETE FROM ' . $base['config']['db']['pre'] . 'login WHERE ' . time() . '-time>3600');

if($db->first('SELECT * FROM ' . $base['config']['db']['pre'] . 'login WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\' AND adminlogin=1 LIMIT 1')){
	if($base['get']['action']=='logout'){
		$db->query('DELETE FROM ' . $base['config']['db']['pre'] . 'login WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
		$base['logoutsuccess'] = 1;
		template('admin_login');
	}elseif($base['get']['action']=='delete'&&$base['get']['id']){
		$image = $db->first("SELECT * FROM {$base['config']['db']['pre']}images WHERE id={$base['get']['id']} LIMIT 1");
		if(!$image)
			exit('<span style="color:red;">' . $base['lang']['delete_fail'] . '</span>');
		$check1 = unlink($base['dir'] . '/i/' . $image['filename'] . $image['extension']);
		$check2 = 1;
		if($image['isthumb'])
			$check2 = unlink($base['dir'] . '/i/' . $image['filename'] . '.th' . $image['extension']);
		$db->query("DELETE FROM {$base['config']['db']['pre']}images WHERE id={$base['get']['id']}");
		if($check1&&$check2)
			exit('<span style="color:green;">' . $base['lang']['delete_success'] . '</span>');
		exit('<span style="color:red;">' . $base['lang']['delete_fail'] . '</span>');		
		
	}else{
		$page = $base['get']['page']?intval($base['get']['page']):1;
		$images_count = $db->num_rows('SELECT id FROM ' . $base['config']['db']['pre'] . 'images');
		
		$base['pages'] = page($images_count,$page,15,'index.php?mod=admin','&amp;page=[page]');
		
		$base['showimages'] = '';
		
		$db->query("SELECT * FROM {$base['config']['db']['pre']}images ORDER BY id DESC LIMIT ".(($page-1)*15).",15");
		
		while($image = $db->fetch()){
			
			$base['showimages'] .= img($image['id'], $base['config']['url'].'/i/'.$image['filename'] ,$image['extension'],$image['isthumb'],1,$image['ip'],$image['time'],$image['views']);	
			
		}
		
		template('admin');
	}
}else{
	if($db->first('SELECT * FROM ' . $base['config']['db']['pre'] . 'login WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\' AND fail>4 LIMIT 1')){
		$base['blacklist'] = 1;
	}else{
		if(isset($base['post']['pass'])){
			if(sha1(sha1($base['post']['pass'])) == $base['config']['admin']['pass']){
				$base['loginsuccess'] = 1;
				if($db->first('SELECT * FROM ' . $base['config']['db']['pre'] . 'login WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\' LIMIT 1')){
					$db->query('UPDATE ' . $base['config']['db']['pre'] . 'login SET adminlogin=1 WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\' LIMIT 1');
				}else{
					$db->query('INSERT INTO ' . $base['config']['db']['pre'] . 'login (ip,time,adminlogin) VALUES (\'' . $_SERVER['REMOTE_ADDR'] . '\',' . time() . ',1)');
				}
			}else{
				if($db->first('SELECT * FROM ' . $base['config']['db']['pre'] . 'login WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\' LIMIT 1')){
					$db->query('UPDATE ' . $base['config']['db']['pre'] . 'login SET fail=fail+1 WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\' LIMIT 1');
				}else{
					$db->query('INSERT INTO ' . $base['config']['db']['pre'] . 'login (ip,time,fail) VALUES (\'' . $_SERVER['REMOTE_ADDR'] . '\',' . time() . ',1)');
				}
			}
		}
	}
	template('admin_login');
}
?>