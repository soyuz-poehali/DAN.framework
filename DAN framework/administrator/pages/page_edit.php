<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.css');
$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.js');
$SITE->setHeadFile('/administrator/pages/page_edit.css');
$SITE->setHeadFile('/administrator/pages/page_edit.js');
$SITE->setHeadFile('/administrator/templates/js/ADMIN.metaTags.js');

if ($SITE->url_arr[2] == 'page_add') {
	$title = 'Добавить страницу';
	$act = 'page_insert';
	$page['id'] = 0;
	$page['tag_title'] = $page['tag_description'] = $page['url'] = '';
	$page['status'] = 1;
} else {
	$page_id = $SITE->url_arr[3];
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
	$PAGES = new Pages;
	$page = $PAGES->getPage($page_id);
	$title = 'Редактировать страницу';
	$act = 'page_update/'.$page_id;
}


if ($page['id'] == 1) {
	// Главная страница
	$mainpage =
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div><svg style="width:30px;height:30px;fill:#2196F3;"><use xlink:href="/administrator/templates/images/sprite.svg#star"></use></svg></div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<h3 style="color:#2196F3">Главная страница</h3>'.
		'</div>'.
	'</div>';
	$url_html = '';
	$status_html = '';
} else {
	// Прочие страницы
	$status_check = $page['status'] > 0 ? 'checked' : '';
	$mainpage = '';
	$url_html =
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>URL <span class="dan_tooltip"><em>URL</em><p>Адрес страницы сайта, указывается без слеша впереди и в конце</p></span></div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<input id="page_url" class="dan_input w_400" name="url" required value="'.$page['url'].'" pattern="[a-z0-9_-]{1,50}" '.
			'title="Только английские буквы в нижнем регистре, цифры и символы _- (до 50 символов)" data-id="'.$page['id'].'">'.
			'<span id="page_url_message"></span>'.
		'</div>'.
	'</div>';
	$status_html = 
	'<div class="dan_flex_row">'.
		'<div class="tc_l">Статус вкл/выкл:</div>'.
		'<div class="tc_r">'.
			'<input id="page_status" class="dan_input" name="status" type="checkbox" value="1" '.$status_check.'>'.
			'<label for="page_status"></label>'.
		'</div>'.
	'</div>';
}


$SITE->content = 
'<h1>'.$title.'</h1>'.
$mainpage.
'<form method="post" action="/admin/pages/'.$act.'" enctype="multipart/form-data">'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>'.
				'Заголовок &lt;title&gt;<span class="dan_tooltip"><em>Заголовок страницы</em><p>Этот тег отображается во вкладке браузера и сообщает поисковым роботам - о чем идет речь на странице. Тег должен быть коротким, и релевантным содержимому страницы. <br><br> Если поле оставить пустым – система управления при выводе страницы сгенерирует его автоматически в таком формате: <b>заголовок содержимого страницы – название сайта</b>, например: <b>Строительство коттеджей и загородных домов - Строймонтаж</b></p></span>'.
			'</div>'.
		'</div>'.
		'<div class="tc_r">'.
			'<textarea id="meta_title_input" rows="2" name="tag_title" required class="dan_input w_400">'.$page['tag_title'].'</textarea>'.
			'<span id="meta_title_num"></span>'.
		'</div>'.
	'</div>'.
	'<div class="dan_flex_row">'.
		'<div class="tc_l">'.
			'<div>'.
				'Описание, &lt;description&gt;<span class="dan_tooltip"><em>Описание страницы</em><p>Тег не виден на странице человеку, но виден  поисковому роботу.  Очень часто этот тег используется поисковиком в качестве сниппета.<br><br>Не перечисляёте здесь набор ключевых слов – это признак спама и дурного тона. Помните, большое количество слов в этом теге – признак спама. Поисковики это не любят и занижают позиции. Пишите описание страницы для людей – понятное, логическое, интересное с цифрами и фактами, 12  - 15 слов. <br><br> Если поле не будет заполнено система управления подставит в этот тег при выводе страницы описание сайта, которое вы заполнили в настройках сайта.</p></span>'.
			'</div>'.
		'</div>'.
		'<div class="tc_r dan_flex_grow">'.
			'<textarea id="meta_description_input" rows="5" name="tag_description" required class="dan_input w_400">'.$page['tag_description'].'</textarea>'.
			'<span id="meta_description_num"></span>'.
		'</div>'.
	'</div>'.
	$url_html.
	$status_html.
	'<div class="dan_flex_row m_40_0">'.
		'<div class="tc_l"><input class="dan_button_green" type="submit" name="submit" value="Сохранить"></div>'.
		'<div class="tc_r"><a href="/admin/pages" class="dan_button_white">Отменить</a></div>'.
	'</div>'.
'</form>';


?>