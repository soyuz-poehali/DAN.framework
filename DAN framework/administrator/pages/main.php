<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'page_add':
	case 'page_edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_edit.php';
		break;

	case 'page_insert':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_insert.php';
		break;

	case 'page_update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_update.php';
		break;

	case 'page_delete':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_delete.php';
		break;

	case 'page_pub':
	case 'page_unpub':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_pub_unpub.php';
		break;

	case 'page_up':
	case 'page_down':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_ordering.php';
		break;

	case 'page_check_url':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/page_check_url_ajax.php';
		break;

	case 'menu_add':
	case 'menu_edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/menu_edit.php';
		break;

	case 'menu_insert':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/menu_insert.php';
		break;

	case 'menu_update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/menu_update.php';
		break;

	case 'menu_pub':
	case 'menu_unpub':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/menu_pub_unpub.php';
		break;

	case 'menu_up':
	case 'menu_down':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/menu_ordering.php';
		break;

	case 'menu_delete':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/menu_delete.php';
		break;

	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/mainpage.php';
		break;
}

?>