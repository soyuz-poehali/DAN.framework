<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.css');
$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.js');
$SITE->setHeadFile('/administrator/pages/menu_edit.js');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$admin_id = $_SESSION['admin'];
$pages = $PAGES->getPages();

if ($SITE->url_arr[2] == 'menu_add') {
	$menu_id = 0;  // Игнорируем пункт меню с id=0 - его нет
	$title = 'Добавить меню';
	$act = 'menu_insert';
	$menu['parent_id'] = 0;
	$menu['name'] = '';
	$menu['link_type'] = '';
	$menu['parameter'] = '';
	$link = '';
	$menu['status'] = 1;
	$menu['ordering'] = $PAGES->getMenuMaxOrdering('top') + 1;
} else {
	$menu_id = $SITE->url_arr[3];
	$menu = $PAGES->getMenu($menu_id);
	$title = 'Редактировать меню';
	$act = 'menu_update/'.$menu_id;
}

$admin_id = $_SESSION['admin'];

// --- Родительский пункт меню ---
$menu_tree = $PAGES->getMenuTree('top', 0, 0, $menu_id);
$menu_tree_html = '';
if ($menu_tree != '') {
	foreach ($menu_tree as $m) {
		$indent = str_repeat("&nbsp;-&nbsp;", $m['level']);  // Отступ
		$selected = $menu['parent_id'] == $m['id'] ? 'selected' : '';
		$menu_tree_html .= '<option value="'.$m['id'].'" '.$selected.'>'.$indent.$m['name'].'</option>';
	}	
}
$menu_tree_html = 
'<select id="menu_parent" class="dan_input" name="parent_id">'.
	'<option value="0">Нет родительского пункта</option>'.
	$menu_tree_html.
'</select>';


// --- Тип ссылки - страница / ссылка ---
$link_type_selected = array('page' => '', 'catalog' => '', 'link' => '');

if ($menu['link_type'] == 'page')
	$link_type_selected['page'] = 'selected';

if ($menu['link_type'] == 'catalog')
	$link_type_selected['catalog'] = 'selected';

$menu_link_container_style = '';
if ($menu['link_type'] == 'link') {
	$link_type_selected['link'] = 'selected';
	$menu_link_container_style = 'style="display:none;"';
}


// --- Страницы меню ---
$pages_options_html = $pages_options_html = '';
foreach ($pages as $page) {
	if ($menu['link_type'] == 'page' || $menu['link_type'] == 'catalog') {
		if ($menu['parameter'] == $page['id']){
			$page_arr_selected[$page['id']] = 'selected';
		}
		else
			$page_arr_selected[$page['id']] = '';;
	}
	else {
		$page_arr_selected[$page['id']] = '';
	}
	$pages_options_html .= '<option value="'.$page['id'].'" '.$page_arr_selected[$page['id']].'>'.$page['tag_title'].'</option>';
}
$pages_select_html = 
'<select class="dan_input" name="page_id">'.
	$pages_options_html.
'</select>';


$status_check = $menu['status'] > 0 ? 'checked' : '';

$SITE->content = 
'<h1>'.$title.'</h1>'.
'<form method="post" action="/admin/pages/'.$act.'" enctype="multipart/form-data">'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>Наименование пункта меню:</div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<input id="menu_name" class="dan_input" name="name" required value="'.$menu['name'].'">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>Родительский пункт меню:</div>'.
		'</div>'.
		'<div class="tc_r">'.
			$menu_tree_html.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>Тип ссылки:</div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<select id="menu_link_type" class="dan_input" name="link_type">'.
				'<option value="page" '.$link_type_selected['page'].'>Страница</option>'.
				'<option value="catalog" '.$link_type_selected['catalog'].'>Каталог</option>'.
				'<option value="link" '.$link_type_selected['link'].'>Ссылка</option>'.
			'</select>'.
		'</div>'.
	'</div>'.
	'<div id="menu_pages_container" class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>Страницы:</div>'.
		'</div>'.
		'<div class="tc_r">'.
			$pages_select_html.
		'</div>'.
	'</div>'.
	'<div id="menu_link_container" class="dan_flex_row" '.$menu_link_container_style.'>'.
		'<div class="tc_l">'.
			'<div>Ссылка</div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<input class="dan_input w_400" name="link" type="text" value="'.$menu['parameter'].'">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>Порядок следования</div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<input class="dan_input" name="ordering" type="number" value="'.$menu['ordering'].'">'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Показать / скрыть:</div>'.
		'<div class="tc_r">'.
			'<input id="menu_status" class="dan_input" name="status" type="checkbox" value="1" '.$status_check.'>'.
			'<label for="menu_status"></label>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row m_40_0">'.
		'<div class="tc_l"><input class="dan_button_green" type="submit" name="submit" value="Сохранить"></div>'.
		'<div class="tc_r"><a href="/admin/pages" class="dan_button_white">Отменить</a></div>'.
	'</div>'.
'</form>';

?>