<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Settings.php';
include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';

$SITE->setHeadFile('/administrator/settings/template/settings.css');
$SITE->setHeadFile('/administrator/settings/template/settings.js');


$admin_id = $_SESSION['admin'];

$SETTINGS = new Settings;
$ADMIN = new Administrators;

$settings = $SETTINGS->getSettings();
$admin = $ADMIN->getadmin($admin_id);

$status_check = $settings['status'] == 1 ? 'checked' : '';

if ($admin['status'] >= 5) {
	$clear_button = 
	'<div><a href="/admin/clear" class="dan_button_gray" style="width:225px;">Очистить данные</a></div>';
}


$SITE->content = 
'<h1>Настройки сайта</h1>'.
'<form method="post" action="/admin/settings/update" enctype="multipart/form-data">'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Сайт вкл/выкл:</div>'.
		'<div class="tc_r">'.
			'<input id="admin_status" class="dan_input" name="status" type="checkbox" value="1" '.$status_check.'>'.
			'<label for="admin_status"></label>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Наименование:</div>'.
		'<div class="tc_r">'.
			'<input class="dan_input w_400" name="title" type="text" required value="'.$settings['title'].'">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Описание:</div>'.
		'<div class="tc_r">'.
			'<textarea rows="2" name="description" required class="dan_input w_400">'.$settings['description'].'</textarea>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Email:</div>'.
		'<div class="tc_r">'.
			'<input class="dan_input" name="email" type="email" required value="'.$settings['email'].'">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Код в &#60;header&#62; (метрика, метатеги):</div>'.
		'<div class="tc_r">'.
			'<textarea rows="5" name="code_head" class="dan_input w_400">'.$settings['code_head'].'</textarea>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Код в подвале сайта:</div>'.
		'<div class="tc_r">'.
			'<textarea rows="3" name="code_footer" class="dan_input w_400">'.$settings['code_footer'].'</textarea>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row m_40_0">'.
		'<div class="tc_l"><input class="dan_button_green" type="submit" name="submit" value="Сохранить"></div>'.
		'<div class="tc_r"><a href="/admin" class="dan_button_white">Отменить</a></div>'.
	'</div>'.
'</form>'.
'<div class="m_40_0">'.
	'<div id="favicon_button" class="dan_button_gray" style="margin-bottom:5px;width:225px;">Загрузить favicon.ico</div>'.
	$clear_button.
'</div>';


?>