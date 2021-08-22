<?php
defined('AUTH') or die('Restricted access');

$path = $_SERVER['DOCUMENT_ROOT'].'/templates/template.css';
// $page_id = intval($_POST['p']);

if (is_file($path)) {
	$css = file_get_contents($path);

	$content = 
	'<h2>Редактировать файл template.css</h2>'.
	'<textarea id="e_css_code" name="code">'.$css.'</textarea>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="button" name="cancel" value="Отменить"></div>'.
	'</div>';
} else {
	$content = 
	'<h2>Файл template.css не найден</h2>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="button" name="cancel" value="Выход"></div>'.
	'</div>';	
}


echo json_encode(array('answer' => 'success', 'content' => $content));
exit;
?>