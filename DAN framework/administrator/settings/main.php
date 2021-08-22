<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/settings/update.php';
		break;

	case 'favicon_update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/settings/favicon_update.php';
		break;	

	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/settings/edit.php';
		break;
}

?>