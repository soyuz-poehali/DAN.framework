<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$id = $SITE->url_arr[3];

if ($id == 1) {
	// Нельзя удалить главную страницу
	header('location: /admin/pages');
	exit;
}

$PAGES->deletePage($id);
header('location: /admin/pages');

?>