<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$data['tag_title'] = clear_post('tag_title');
$data['tag_description'] = clear_post('tag_description');
$data['url'] = clear_post('url');
$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

if ($PAGES->insertPage($data)) {
	header('location: /admin/pages');
	exit;
}

$SITE->content = 
'<h1>Ошибка</h1>'.
'<div>Url <b>'.$data['url'].'</b> уже занят</div>';


function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>