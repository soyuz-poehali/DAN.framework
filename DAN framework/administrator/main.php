<?php
defined('AUTH') or die('Restricted access');

// Проверка логина
include $_SERVER['DOCUMENT_ROOT'].'/administrator/login.php';

switch ($SITE->url_arr[1]) {
	case 'pages':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/pages/main.php';
		break;

	case 'com':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/main.php';
		break;

	case 'settings':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/settings/main.php';
		break;

	case 'administrators':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/administrators/main.php';
		break;

	case 'clear':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/clear/main.php';
		break;

	case 'logout':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/logout.php';
		break;

	case 'edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/edit.php';
		break;

	case 'view':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/view.php';
		break;

	case 'personal_information':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/personal_information/main.php';
		break;

	case 'upgrade':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/main.php';
		break;

	case 'help':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/main.php';
		break;

	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/mainpage.php';
		break;
}


include $_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/module.php';
include $_SERVER['DOCUMENT_ROOT'].'/administrator/templates/template.php';

?>