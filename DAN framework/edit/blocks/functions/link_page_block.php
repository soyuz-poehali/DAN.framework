<?php
defined('AUTH') or die('Restricted access');
// Выводит интерфейс выбора ссылки

function link_page_block($link)
{
	global $db;

	// Страницы
	$stmt_page = $db->query("SELECT id, url, data, status FROM pages ORDER BY ordering");
	
	$page_html = '';
	while ($page = $stmt_page->fetch()) {
		$data = unserialize($page['data']);
		$status_class = $page['status'] == 1 ? '' : 'e_unpub';
		$page_html .= '<div class="e_block_modal_pages_item '.$status_class.'" data-url="'.$page['url'].'" data-url="shop/section/1">'.$data['tag_title'].'</div>';	
	}
	
	$arr['pages'] = '<div id="e_block_modal_pages_out"><h2>Страницы</h2>'.$page_html.'</div>';

	$arr['link'] =
	'<div class="dan_modal_wrap">'.
		'<div class="e_str_left e_flex_basis_100">Ссылка:</div>'.
		'<div class="e_str_right e_block_modal_ico_but_wrap">'.
			'<input id="e_block_modal_link" class="dan_input" name="link" type="text" value="'.$link.'">'.
			'<div id="e_block_modal_ico_but_pages" class="e_block_modal_ico_but" title="выбрать страницу"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#pages"></use></svg></div>'.
			'<div id="e_block_modal_ico_but_blocks" class="e_block_modal_ico_but" title="выбрать блок"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#fullscreen_23"></use></svg></div>'.
		'</div>'.
	'</div>';

	return $arr;

}

?>