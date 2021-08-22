<?php
defined('AUTH') or die('Restricted access');

$page_id = intval($_POST['p']);
$code = $_POST['code'];

$path = $_SERVER['DOCUMENT_ROOT'].'/templates/template.css';

$fd = fopen($path, 'w') 
	or die("не удалось открыть файл");
fwrite($fd, $code);
fclose($fd);

echo json_encode(array('answer' => 'reload'));
exit;

?>