<?php
defined('AUTH') or die('Restricted access');

$blocks_arr = array(
	'buttonup', 
	'breadcrumbs',
	'callback', 
	'case', 
	'case_2', 
	'catalog', 
	'code', 
	'contacts', 
	'form', 
	'icon', 
	'image', 
	'image_360', 
	'mapsyandex', 
	'menu', 
	'packages', 
	'photogallery', 
	'php_code', 
	'scrolling_vertical', 
	'site_portfolio', 
	'slider', 
	'text', 
	'video', 
	'virtual_tour'
);

switch ($SITE->url_arr[1]) {
	case 'block':
		if (in_array($SITE->url_arr[2], $blocks_arr)) {
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/'.$SITE->url_arr[2].'/edit/main.php';
		} else {
			switch ($SITE->url_arr[2]) {					
				case 'update_ordering':
					include $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/update_ordering.php';
					break;
				case 'up':
				case 'down':
					include $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/up_down.php';
					break;
				
				default:
				header ('HTTP/1.0 404 Not Found');
				include '404.php';
				exit;
			}
		}
		break;

	case 'css':
		include $_SERVER['DOCUMENT_ROOT'].'/edit/css/main.php';
		break;

	case 'help':
		include $_SERVER['DOCUMENT_ROOT'].'/edit/help/main.php';
		break;
	
	default:
		header ('HTTP/1.0 404 Not Found');
		include '404.php';
		exit;
}

exit;