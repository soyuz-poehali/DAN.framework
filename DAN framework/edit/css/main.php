<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'edit':
		include $_SERVER['DOCUMENT_ROOT'].'/edit/css/edit.php';
		break;

	case 'save':
		include $_SERVER['DOCUMENT_ROOT'].'/edit/css/save.php';
		break;
		
	default:
		header ('HTTP/1.0 404 Not Found');
		include '404.php';
		exit;
}

exit;