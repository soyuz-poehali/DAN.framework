<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$id = intval($_POST['id']);
$url = trim(htmlspecialchars(strip_tags($_POST['url'])));

$check = $PAGES->checkUrl($id, $url);
$message = $check ? '' : '<span style="color:#ff0000;">URL <b>'.$url.'</b> занят</span>';

echo json_encode(array('answer' => 'success', 'message' => $message));
exit;

?>