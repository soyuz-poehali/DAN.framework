<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/remove_directory/remove_directory.php';

$admin_id = $_SESSION['admin'];

$ADM = new Administrators;
$admin = $ADM->getAdmin($admin_id);

if ($admin['status'] >= 5) {
	// Очищаем настройки сайта
	if (isset($_POST['settings'])) {
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Settings.php';
		$SETTINGS = new Settings;

		$settings['title'] = '';
		$settings['description'] = '';
		$settings['email'] = '';
		$settings['code_head'] = '';
		$settings['code_footer'] = '';
		$status = 0;

		$SETTINGS->updateSettings($settings, $status);
	}

	// Удаляем всех пользователей
	if (isset($_POST['users'])) {
		$stmt = $db->query("DELETE FROM administrators WHERE id > 2");
		$stmt = $db->query("ALTER TABLE `administrators` auto_increment = 3");
	}

	// Удаляем все страницы, меню, блоки
	if (isset($_POST['pages'])) {
		$stmt_p = $db->query("DELETE FROM pages WHERE id > 1");
		$stmt_p = $db->query("ALTER TABLE `pages` auto_increment = 2");

		$stmt_m = $db->query("DELETE FROM menu WHERE id > 1");
		$stmt_m = $db->query("ALTER TABLE `menu` auto_increment = 2");

		$stmt_b = $db->query("DELETE FROM blocks WHERE id > 0");
		$stmt_b = $db->query("ALTER TABLE `blocks` auto_increment = 1");

		$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages';
		remove_directory($dir);	
	}

	// Удаляем все таблицы каталога
	if (isset($_POST['catalogs'])) {
		include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/catalogs/classes/AdminCatalogsCatalogs.php';
		$CATALOGS = new AdminCatalogsCatalogs();

		$stmt_select = $db->query("SELECT id FROM components WHERE component = 'catalog' AND type = 'shop'");
		if ($stmt_select->rowCount() > 0) {
			$com_arr = $stmt_select->fetchAll();
			foreach ($com_arr as $com) {
				$CATALOGS->delete($com['id']);
				$stmt_delete = $db->prepare("DELETE FROM components WHERE id = :id");
				$stmt_delete->execute(array('id' => $com['id']));
			}
		}

		$stmt_s = $db->query("SELECT id FROM components WHERE id > 0");
		$count = $stmt_s->rowCount();
		$ai = $count + 1;

		$stmt_a = $db->query("ALTER TABLE `components` auto_increment = ".$ai);

		$dir = $_SERVER['DOCUMENT_ROOT'].'/files/catalogs';
		remove_directory($dir);	
	}

	// Удаляем все лиды
	if (isset($_POST['leads'])) {
		
	}

	// Удаляем файлы
	if (isset($_POST['files'])) {
		$dir = $_SERVER['DOCUMENT_ROOT'].'/files';
		remove_directory($dir);	
	}

	$SITE->content = '<h1>Данные очищены</h1>';
} else {
	$SITE->content = '<h1>У Вас недостаточно прав</h1>';
}

?>