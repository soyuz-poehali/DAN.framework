<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case '':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/clear/select.php';
		break;

	case 'clear_data':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/clear/clear_data.php';
		break;

	default:
		header('HTTP/1.0 404 Not Found');
		include $_SERVER['DOCUMENT_ROOT'].'/404.php';
		exit;
		break;
}

?>