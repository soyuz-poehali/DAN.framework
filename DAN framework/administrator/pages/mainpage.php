<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.js');
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.css');
$SITE->setHeadFile('/administrator/pages/mainpage.js');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$admin_id = $_SESSION['admin'];

$code =
	'<script>window.addEventListener("DOMContentLoaded", function(){'.
		'var contextmenu_menu = ['.
			'["/admin/pages/menu_edit", "dan_contextmenu_edit", "Редактировать меню"],'.
			'["#ADMIN.pages.page_edit", "dan_contextmenu_edit", "Редактировать страницу"],'.
			'["/admin/pages/menu_pub", "dan_contextmenu_pub", "Показывать"],'.
			'["/admin/pages/menu_unpub", "dan_contextmenu_unpub", "Скрыть"],'.
			'["/admin/pages/menu_up", "dan_contextmenu_up", "Вверх"],'.
			'["/admin/pages/menu_down", "dan_contextmenu_down", "Вниз"],'.
			'["#ADMIN.pages.menu_delete_modal", "dan_contextmenu_delete", "Удалить"]'.
		'];'.
		'DAN.contextmenu.add("contextmenu_menu", contextmenu_menu, "left");'.

		'var contextmenu_menu_link = ['.
			'["/admin/pages/menu_edit", "dan_contextmenu_edit", "Редактировать меню"],'.
			'["/admin/pages/menu_pub", "dan_contextmenu_pub", "Показывать"],'.
			'["/admin/pages/menu_unpub", "dan_contextmenu_unpub", "Скрыть"],'.
			'["/admin/pages/menu_up", "dan_contextmenu_up", "Вверх"],'.
			'["/admin/pages/menu_down", "dan_contextmenu_down", "Вниз"],'.
			'["#ADMIN.pages.menu_delete_modal", "dan_contextmenu_delete", "Удалить"]'.
		'];'.
		'DAN.contextmenu.add("contextmenu_menu_link", contextmenu_menu_link, "left");'.

		'var contextmenu_mainpage = ['.
			'["/admin/pages/page_edit", "dan_contextmenu_edit", "Редактировать"],'.
			'["/admin/pages/page_up", "dan_contextmenu_up", "Вверх"],'.
			'["/admin/pages/page_down", "dan_contextmenu_down", "Вниз"]'.
		'];'.
		'DAN.contextmenu.add("contextmenu_mainpage", contextmenu_mainpage, "left");'.

		'var contextmenu_page = ['.
			'["/admin/pages/page_edit", "dan_contextmenu_edit", "Редактировать"],'.
			'["/admin/pages/page_pub", "dan_contextmenu_pub", "Показывать"],'.
			'["/admin/pages/page_unpub", "dan_contextmenu_unpub", "Скрыть"],'.
			'["/admin/pages/page_up", "dan_contextmenu_up", "Вверх"],'.
			'["/admin/pages/page_down", "dan_contextmenu_down", "Вниз"],'.
			'["#ADMIN.pages.page_delete_modal", "dan_contextmenu_delete", "Удалить"]'.
		'];'.
		'DAN.contextmenu.add("contextmenu_page", contextmenu_page, "left");'.
	'})</script>';
$SITE->setHeadCode($code);


$menu = $PAGES->getMenuTree();
$menu_html = '';
$pages_id_arr = [];
foreach ($menu as $m) {
	$menu_indent = str_repeat("&nbsp;-&nbsp;", $m['level']);  // Отступ
	$menu_unpub = $m['status'] > 0 ? '' : 'unpub';
	$menu_link_type_arr = array('page' => 'страница', 'catalog' => 'каталог', 'link' => 'ссылка', 'ankhor' => 'якорь');
	$menu_link_type = $menu_link_type_arr[$m['link_type']];

	$contextmenu_class = 'contextmenu_menu';
	$menu_page['id'] = 0;

	if ($m['link_type'] == 'page' || $m['link_type'] == 'catalog') {
		$menu_page = $PAGES->getPage(intval($m['parameter']));
		$page_unpub = $menu_page['status'] > 0 ? '' : 'unpub';
		$link_html = $menu_page ? '<a class="'.$page_unpub.'" href="/admin/pages/page_edit/'.$menu_page['id'].'">/'.$menu_page['url'].' <span class="m_l_40">'.$menu_page['tag_title'].'</span></a>' : '';
		$pages_id_arr[] = $menu_page['id'];
	} else {
		$contextmenu_class = 'contextmenu_menu_link';
		$link_html = '<a class="'.$menu_unpub.'" href="/admin/pages/menu_edit/'.$m['id'].'">'.$m['parameter'].'</a>';
	}
	
	if ($menu_page['id'] == 1) {
		$mainpage = '<svg style="width:15px;height:15px;margin-right:10px;fill:#2196F3;"><use xlink:href="/administrator/templates/images/sprite.svg#star"></use></svg>';
	} else {
		$mainpage = '';
	}

	$menu_html .= 
	'<tr>'.
		'<td class="w_40 '.$menu_unpub.'">'.
			'<div class="dan_flex_row contextmenu_wrap">'.
				'<svg class="dan_contextmenu_ico '.$contextmenu_class.'" title="Действия" data-id="'.$m['id'].'" data-page_id="'.$menu_page['id'].'"><use xlink:href="/administrator/templates/images/sprite.svg#menu_1"></use></svg>'.
			'</div>'.
		'</td>'.
		'<td class="w_200 '.$menu_unpub.'">'.
			'<a href="/admin/pages/menu_edit/'.$m['id'].'">'.$mainpage.$menu_indent.$m['name'].'</a>'.
		'</td>'.
		'<td class="w_200" '.$menu_unpub.'>'.
			$menu_link_type.
		'</td>'.
		'<td>'.
			$link_html .
		'</td>'.
	'</tr>';
}

if ($menu_html != '') {
	$menu_html =
	'<h2>Верхнее меню</h2>'.
	'<table class="admin_table dan_even_odd">'.
		'<tr>
			<th></th>
			<th>Меню:</th>
			<th>Тип</th>
			<th>Ссылка</th>
		</tr>'.
		$menu_html.
	'</table><br>';
}


$exception_list = implode(',', $pages_id_arr);
$pages = $PAGES->getPages($exception_list);
$pages_html = '';

foreach ($pages as $page) {
	if ($page['id'] == 1) {
		$mainpage = '<svg style="width:15px;height:15px;margin-right:10px;fill:#2196F3;"><use xlink:href="/administrator/templates/images/sprite.svg#star"></use></svg>';
		$context_menu_class = 'contextmenu_mainpage';
	} else {
		$mainpage = '';
		$context_menu_class = 'contextmenu_page';
	}
	$class_unpub = $page['status'] > 0 ? '' : 'class="unpub"';
	$pages_html .= 
	'<tr '.$class_unpub.'>'.
		'<td class="w_40">'.
			'<div class="dan_flex_row contextmenu_wrap">'.
				'<svg class="dan_contextmenu_ico '.$context_menu_class.'" title="Действия" data-id="'.$page['id'].'"><use xlink:href="/administrator/templates/images/sprite.svg#menu_4"></use></svg>'.
			'</div>'.
		'</td>'.
		'<td class="w_200">'.
			'<a href="/admin/pages/page_edit/'.$page['id'].'">'.$mainpage.$page['tag_title'].'</a>'.
		'</td>'.
		'<td class="w_200">'.
			'<a href="/admin/pages/page_edit/'.$page['id'].'">/'.$page['url'].'</a>'.
		'</td>'.
		'<td>'.
			'<a href="/admin/pages/page_edit/'.$page['id'].'">'.$page['tag_description'].'</a>'.
		'</td>'.
	'</tr>';
}

if ($pages_html != '') {
	$pages_html =
	'<h2>Страницы без пунктов меню</h2>'.
	'<table class="admin_table dan_even_odd">'.
		'<tr>
			<th></th>
			<th>Страница:</th>
			<th>Ссылка:</th>
			<th>Описание:</th>
		</tr>'.
		$pages_html.
	'</table><br>';
}


$SITE->content = 
'<div class="buttons_container">
	<a href="/admin/pages/page_add" target="blank" class="ico_rectangle_container">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#add"></use></svg>
		<div class="ico_rectangle_text">Добавить страницу</div>
	</a>
	<a href="/admin/pages/menu_add" target="blank" class="ico_rectangle_container">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#add"></use></svg>
		<div class="ico_rectangle_text">Добавить пункт меню</div>
	</a>
	<a href="/admin/help" target="blank" class="ico_rectangle_container">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#help"></use></svg>
		<div class="ico_rectangle_text">Помощь</div>
	</a>
</div>'.
'<div>'.
	$menu_html.
	$pages_html.
'</div>';

?>