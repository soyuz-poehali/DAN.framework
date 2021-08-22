<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.css');
$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.js');

if ($SITE->url_arr[2] == 'add') {
	$title = 'Добавить пользователя';
	$act = 'insert';
	$administrator['login'] = $administrator['description'] = '';
	$administrator['status'] = 1;
	$pass_required = 'required=""';
	$pass_tooltip = '';
} else {
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';
	$ADMINS = new Administrators;
	$administrator = $ADMINS->getAdmin($SITE->url_arr[3]);
	$title = 'Редактировать пользователя';
	$act = 'update/'.$SITE->url_arr[3];
	$pass_required = '';
	$pass_tooltip = '<div class="dan_tooltip"><em>Сохранение пароля</em>Пароль будет сменён, если длина пароля будет больше 7 символов</div>';
}

$status_check = $administrator['status'] > 0 ? 'checked' : '';

$SITE->content = 
'<h1>'.$title.'</h1>'.
'<form method="post" action="/admin/administrators/'.$act.'" enctype="multipart/form-data">'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Логин:</div>'.
		'<div class="tc_r">'.
			'<input class="dan_input" name="login" type="text" required="" pattern="[a-z0-9_-]{3,20}" value="'.$administrator['login'].'" title="Английские буквы в нижнем регистреб цифры, символы _ -">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Пароль: '.$pass_tooltip.'</div>'.
		'<div class="tc_r">'.
			'<input class="dan_input" name="psw" type="password" '.$pass_required.' pattern="[a-zA-Z0-9_-]{8,20}" value="" title="Английские буквы и (или) цифры, символы _ - от 8 до 20 символов">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Описание:</div>'.
		'<div class="tc_r">'.
			'<textarea rows="2" name="description" class="dan_input w_400">'.$administrator['description'].'</textarea>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Статус вкл/выкл:</div>'.
		'<div class="tc_r">'.
			'<input id="administrator_status" class="dan_input" name="status" type="checkbox" value="1" '.$status_check.'>'.
			'<label for="administrator_status"></label>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row m_40_0">'.
		'<div class="tc_l"><input class="dan_button_green" type="submit" name="submit" value="Сохранить"></div>'.
		'<div class="tc_r"><a href="/admin/administrators" class="dan_button_white">Отмена</a></div>'.
	'</div>'.
'</form>';


?>