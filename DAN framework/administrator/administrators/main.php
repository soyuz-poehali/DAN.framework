<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'insert':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/administrators/insert.php';
		break;

	case 'add':
	case 'edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/administrators/edit.php';
		break;

	case 'update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/administrators/update.php';
		break;

	case 'delete':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/administrators/delete.php';
		break;

	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/administrators/mainpage.php';
		break;
}

?>