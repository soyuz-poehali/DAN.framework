<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';
$ADMINS = new Administrators;

$id = intval($_POST['id']);

if ($ADMINS->deleteAdmin($id)) {
	echo json_encode(array('answer' => 'success'));
	exit;
}

echo json_encode(array('answer' => 'error'));
exit;

function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>