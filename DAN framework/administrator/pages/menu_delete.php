<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$id = $SITE->url_arr[3];

$PAGES->deleteMenu($id);
header('location: /admin/pages');

?>