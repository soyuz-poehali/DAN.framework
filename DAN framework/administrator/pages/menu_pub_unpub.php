<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$menu_data['id'] = $SITE->url_arr[3];
$menu_data['status'] = $SITE->url_arr[2] == 'menu_pub' ? 1 : 0;

$PAGES->setMenuStatus($menu_data);
$menu = $PAGES->getMenu($menu_data['id']);

if ($menu['link_type'] == 'page') {
	$page_data['id'] = $menu['parameter'];
	$page_data['status'] = $menu_data['status'];
	$PAGES->setPageStatus($page_data);
}

header('location: /admin/pages');
exit;

?>