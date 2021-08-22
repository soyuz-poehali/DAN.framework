<?php
defined('AUTH') or die('Restricted access');

if (isset($_FILES['favicon_file'])) {
	$file = $_FILES['favicon_file'];
	$file_name = mb_strtolower($_FILES['favicon_file']['name']);
} else {
	echo json_encode(array('answer' => 'success', 'message' => 'error'));
	exit;
}

if ($file_name != 'favicon.ico') {
print_r($file_name);
	echo json_encode(array('answer' => 'success', 'message' => 'error'));
	exit;
}


$path = $_SERVER['DOCUMENT_ROOT'].'/favicon.ico';

if (move_uploaded_file($file['tmp_name'], $path)) 
	@chmod($path_new, 0644);
else {
	echo json_encode(array('answer' => 'success', 'message' => 'error'));
	exit;
}

echo json_encode(array('answer' => 'success', 'message' => 'success'));
exit;
?>