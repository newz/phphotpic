<?

define('PHPHOTPIC', '0.6.2');

$base = array(
	'time_start' => microtime(),
	'name' => $_SERVER['PHP_SELF'],
	'dir' => dirname(__FILE__) . '/',
);

if(!file_exists($base['dir'] . 'data/config.php'))
{
	header('Location: install/install.php');
	exit();
}

require_once $base['dir'] . 'data/config.php';
require_once $base['dir'] . 'source/core.func.php';
require_once $base['dir'] . 'source/mysqldb.class.php';

$base['post'] = paddslashes($_POST);
$base['get'] = paddslashes($_GET);
$base['cookie'] = paddslashes($_COOKIE);
unset($_POST);
unset($_GET);
unset($_COOKIE);

$langset = $base['cookie']['lang'] ? $base['cookie']['lang'] : $config['lang'];

require_once $base['dir'] . 'lang/langset.php';
$langset = in_array($langset,array_keys($all_lang)) ? $langset : $base['cookie']['lang'];
require_once $base['dir'] . 'lang/' . $langset . '/all.lang.php';

$base['lang'] = $lang;
unset($lang);

$base['config'] = $config;
unset($config);

$db = new mysql_database;

if(!$db->connect($base['config']['db']))
	error_report($base['lang']['db_connect_error']);

if($base['get']['mod'] == '')
	$base['get']['mod'] = 'index';
	
if (!empty($_FILES))
	$base['get']['mod'] = 'upload';

if(!in_array($base['get']['mod'], array('index', 'upload', 'show', 'admin')))
	error_report(str_replace('\\1', '<code>' . htmlspecialchars($base['get']['mod']) . '</code>', $base['lang']['mod_not_found']));

require_once $base['dir'] . 'source/' . $base['get']['mod'] . '.mod.php';

?>