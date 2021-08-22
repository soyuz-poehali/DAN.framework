<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Settings.php';
$SETTINGS = new Settings;

$settings['title'] = clear_post('title');
$settings['description'] = clear_post('description');
$settings['email'] = clear_post('email');
$settings['code_head'] = $_POST['code_head'];
$settings['code_footer'] = $_POST['code_footer'];
$status = isset($_POST['status']) ? intval($_POST['status']) : 0;

$SETTINGS->updateSettings($settings, $status);

header('location: /admin');


function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>