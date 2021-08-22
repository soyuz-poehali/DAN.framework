<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';

$data['id'] = $SITE->url_arr[3];
$data['login'] = clear_post('login');
$data['psw'] = clear_post('psw');
$data['description'] = clear_post('description');
$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

$ADMINS = new Administrators;

if ($ADMINS->updateAdmin($data)) {
	header('location: /admin/administrators');
	exit;
}

$SITE->content = 
'<h1>Ошибка</h1>'.
'<div>Логин <b>'.$data['login'].'</b> уже занят</div>';


function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>