<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id_arr = explode(',', $_POST['ids']);
$BLOCK_E->updateOrdering($id_arr);

echo json_encode(array('answer' => 'success'));
exit;
?>