<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/AdminUsers.php';
$USERS = new AdminUsers;

$id = intval($_POST['id']);

if ($USERS->deleteUser($id)) {
	echo json_encode(array('answer' => 'success'));
	exit;
}

echo json_encode(array('answer' => 'error'));
exit;

function clear_post($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}

?>