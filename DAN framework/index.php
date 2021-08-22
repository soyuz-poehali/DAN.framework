<?php
define("AUTH", TRUE);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include 'config.php';

$db_dsn = 'mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8';

$db_opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);

$db = new PDO($db_dsn, $db_user, $db_password, $db_opt);

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Site/Site.php';
$SITE = new Site;
$SITE->domain = $domain;

switch ($SITE->url_arr[0]) {
	case 'admin':
		include 'administrator/main.php';
		break;

	case 'personal_information':
		include "pi/personal_information.php";
		break;

	case 'sitemap.xml':
	case 'sitemap':
		include "sitemap/sitemap.php";
		break;

	case 'block':
		$blocks_arr = array('buttonup', 'callback', 'case', 'case_2', 'catalog', 'code', 'contacts', 
		'form', 'icon', 'image', 'image_360', 'mapsyandex', 'menu', 'packages', 'photogallery', 'php_code', 
		'scrolling_vertical', 'site_portfolio', 'slider', 'text', 'video', 'virtual_tour');
		if (in_array($SITE->url_arr[1], $blocks_arr)) {
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/'.$SITE->url_arr[1].'/frontend/main.php';
		} else {
			header ('HTTP/1.0 404 Not Found');
			include '404.php';
			exit;			
		}
		exit;

	default:
		// Frontend edit
		if (isset($_SESSION['edit'])) {
			if ($SITE->url_arr[0] == 'edit') {
				include $_SERVER['DOCUMENT_ROOT'].'/edit/main.php';
				exit;
			} else {
				include $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/blocks.php';
				include $_SERVER['DOCUMENT_ROOT'].'/edit/cpanel/cpanel.php';
			}
		}

		include $_SERVER['DOCUMENT_ROOT'].'/page.php';

		if ($SITE->headStyle != '')
			$SITE->getHeadCode('<style>'.$SITE->headStyle.'</style>');
		if ($SITE->headJs != '')
			$SITE->getHeadCode('<script>'.$SITE->headJs.'</script>');

		include "templates/template.php";		
}

?>