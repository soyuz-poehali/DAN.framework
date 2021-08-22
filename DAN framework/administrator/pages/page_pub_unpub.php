<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$data['id'] = $SITE->url_arr[3];
$data['status'] = $SITE->url_arr[2] == 'page_pub' ? 1 : 0;

if ($id == 1) {
	// Нельзя скрыть / опубликовать главную страницу
	header('location: /admin/pages');
	exit;
}

$PAGES->setPageStatus($data);

header('location: /admin/pages');
exit;

?>