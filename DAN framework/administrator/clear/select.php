<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';

$admin_id = $_SESSION['admin'];

$ADM = new Administrators;
$admin = $ADM->getAdmin($admin_id);

if ($admin['status'] >= 5) {
$SITE->content = 
	'<h1>Очистить данные</h1>'.
	'<div style="color:#ff0000;">ВНИМАНИЕ! ДАННЫЕ БУДУТ УДАЛЕНЫ БЕЗВОЗВРАТНО!</div>'.
	'<form method="post" action="/admin/clear/clear_data" enctype="multipart/form-data">'.
		'<div class="dan_flex_row m_5_0">'.
			'<div class="tc_l">Настройки сайта:</div>'.
			'<div class="tc_r">'.
				'<input id="clear_settings" class="dan_input" name="settings" type="checkbox" value="1">'.
				'<label for="clear_settings"></label>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row m_5_0">'.
			'<div class="tc_l">Пользователи:</div>'.
			'<div class="tc_r">'.
				'<input id="clear_users" class="dan_input" name="users" type="checkbox" value="1">'.
				'<label for="clear_users"></label>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row m_5_0">'.
			'<div class="tc_l">Страницы:</div>'.
			'<div class="tc_r">'.
				'<input id="clear_pages" class="dan_input" name="pages" type="checkbox" value="1">'.
				'<label for="clear_pages"></label>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row m_5_0">'.
			'<div class="tc_l">Каталоги:</div>'.
			'<div class="tc_r">'.
				'<input id="clear_catalogs" class="dan_input" name="catalogs" type="checkbox" value="1">'.
				'<label for="clear_catalogs"></label>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row m_5_0">'.
			'<div class="tc_l">Лиды и заказы:</div>'.
			'<div class="tc_r">'.
				'<input id="clear_leads" class="dan_input" name="leads" type="checkbox" value="1">'.
				'<label for="clear_leads"></label>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row m_5_0">'.
			'<div class="tc_l">Все файлы из<br>папки «/files»:</div>'.
			'<div class="tc_r">'.
				'<input id="clear_files" class="dan_input" name="files" type="checkbox" value="1">'.
				'<label for="clear_files"></label>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row m_40_0">'.
			'<div class="tc_l"><input class="dan_button_green" type="submit" name="submit" value="Сохранить"></div>'.
			'<div class="tc_r"><a href="/admin" class="dan_button_white">Отменить</a></div>'.
		'</div>'.
	'</form>';
} else {
	$SITE->content = '<h1>У Вас недостаточно прав</h1>';
}

?>