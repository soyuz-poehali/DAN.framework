<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['id'] = intval($_POST['id']);
$data['act'] = $SITE->url_arr[2];

$BLOCK_E->upDown($data);

echo json_encode(array('answer' => 'success'));
exit;
?>