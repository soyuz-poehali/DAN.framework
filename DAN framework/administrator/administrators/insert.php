<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';

$data['login'] = clear_post('login');
$data['psw'] = clear_post('psw');
$data['description'] = clear_post('description');
$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;

$ADMINS = new Administrators;

if ($ADMINS->insertAdmin($data)) {
	header('location: /admin/administrators');
	exit;
}

$SITE->content = 
'<h1>Ошибка</h1>'.
'<div>Логин <b>'.$data['login'].'</b> уже занят или пароль длинной меньше 8 символов</div>';


function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>