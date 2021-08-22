<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$data['id'] = $SITE->url_arr[3];
$data['type'] = 'top';
$data['name'] = clear_post('name');
$data['parent_id'] = intval($_POST['parent_id']);
$data['link_type'] = clear_post('link_type');
$data['parameter'] = $data['link_type'] == 'page' || $data['link_type'] == 'catalog' ? intval($_POST['page_id']) : trim(strip_tags($_POST['link']));
$data['ordering'] = intval($_POST['ordering']);
$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

$PAGES->updateMenu($data);
if ($data['link_type'] == 'page' || $data['link_type'] == 'catalog') {
	$page_data['id'] = intval($_POST['page_id']);
	$page_data['type'] = $data['link_type'];
	$page_data['status'] = $data['status'];
	$PAGES->setPage($page_data);
}

header('location: /admin/pages');
exit;


function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>