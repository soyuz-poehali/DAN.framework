<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.js');
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.css');
$SITE->setHeadFile('/administrator/administrators/mainpage.js');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';
$ADMIN = new Administrators;
$admin_id = $_SESSION['admin'];
$admin = $ADMIN->getAdmin($admin_id);
if ($admin['status'] < 2) {
	$SITE->content = '<h2>Доступ запрещён</h2>';
	return;
}

$admin_id = $_SESSION['admin'];
$administrators = $ADMIN->getAdmins($admin_id);

$code =
	'<script>window.addEventListener("DOMContentLoaded", function(){'.
		'var contextmenu = ['.
			'["/admin/administrators/edit", "dan_contextmenu_edit", "Редактировать пользователя"],'.	
			'["#ADMIN.administrators.delete_modal", "dan_contextmenu_delete", "Удалить пользователя"]'.
		'];'.
		'DAN.contextmenu.add("dan_contextmenu_ico", contextmenu, "left");'.
	'})</script>';
$SITE->setHeadCode($code);

$administrators_out = '';

foreach ($administrators as $administrator) {
	$class_unpub = $administrator['status'] > 0 ? '' : 'class="unpub"';
	$administrators_out .= 
	'<tr '.$class_unpub.'>'.
		'<td class="w_40">'.
			'<div class="dan_flex_row contextmenu_wrap">'.
				'<svg class="dan_contextmenu_ico" title="Действия" data-id="'.$administrator['id'].'"><use xlink:href="/administrator/templates/images/sprite.svg#menu_4"></use></svg>'.
			'</div>'.
		'</td>'.
		'<td class="w_200">'.
			'<a href="/admin/administrators/edit/'.$administrator['id'].'">'.$administrator['login'].'</a>'.
		'</td>'.
		'<td>'.
			$administrator['description'].
		'</td>'.
	'</tr>';
}

$SITE->content = 
'<div class="buttons_container">
	<a href="/admin/administrators/add" target="blank" class="ico_rectangle_container">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#user_add"></use></svg>
		<div class="ico_rectangle_text">Добавить пользователя</div>
	</a>
	<a href="/admin/administrators/help" target="blank" class="ico_rectangle_container" style="display:none;">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#help"></use></svg>
		<div class="ico_rectangle_text">Помощь</div>
	</a>
</div>'.
'<div>'.
	'<table class="admin_table dan_even_odd">'.$administrators_out.'</table>'.
'</div>';

?>