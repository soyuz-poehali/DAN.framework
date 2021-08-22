<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/edit/cpanel/cpanel.css');
$SITE->setHeadFile('/edit/cpanel/cpanel.js');


// $SITE->headAddFile('/lib/codemirror/codemirror.css');
// $SITE->headAddFile('/lib/codemirror/codemirror.js');
// $SITE->headAddFile('/lib/codemirror/dan.css');
// $SITE->headAddFile('/lib/codemirror/xml.js');
// $SITE->headAddFile('/lib/codemirror/css.js');
// $SITE->headAddFile('/lib/codemirror/javascript.js');
// $SITE->headAddFile('/lib/codemirror/htmlmixed.js');
// $SITE->headAddFile('/lib/codemirror/php.js');
// $SITE->headAddFile('/lib/codemirror/clike.js');
// $SITE->headAddFile('/blocks/edit/template/style.css');
// $SITE->headAddFile('/administrator/frontend_edit/tmp/style.css');
// $SITE->headAddFile('/administrator/plugins/ckeditor_inline/ckeditor.js');
// $SITE->headAddFile('/administrator/frontend_edit/js/edit.js');
// $SITE->headAddFile('/administrator/frontend_edit/cpanel/cpanel.js');


$html =
'<div id="e_cpanel">'.
	'<div id="e_cpanel_open">'.
		'<svg><use xlink:href="/edit/template/sprite.svg#gear"></use></svg>'.
	'</div>'.
	'<div class="e_cpanel_first_level">'.
		'<div class="e_cpanel_top">'.
			'<div class="e_cpanel_titile">Блоки:</div>'.
		'</div>'.
		'<div class="e_cpanel_centr">'.
    		'<div class="e_cpanel_block_container">'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="text"><svg><use xlink:href="/edit/template/sprite.svg#text"></use></svg>Текст</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="image"><svg><use xlink:href="/edit/template/sprite.svg#image"></use></svg>Изображение</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="photogallery"><svg><use xlink:href="/edit/template/sprite.svg#images_2"></use></svg>Фотогалерея</div>'.	
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="slider"><svg><use xlink:href="/edit/template/sprite.svg#images"></use></svg>Слайдер</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="video"><svg><use xlink:href="/edit/template/sprite.svg#video"></use></svg>Видео YouTube</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="form"><svg><use xlink:href="/edit/template/sprite.svg#form"></use></svg>Форма</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="packages"><svg><use xlink:href="/edit/template/sprite.svg#window_8"></use></svg>Пакеты предложений</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="case"><svg><use xlink:href="/edit/template/sprite.svg#case"></use></svg>Кейсы 1</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="case_2"><svg><use xlink:href="/edit/template/sprite.svg#case_2"></use></svg>Кейсы 2</div>'.
				'<div class="e_cpanel_block e_cpanel_additional_add" data-type="site_portfolio"><svg><use xlink:href="/edit/template/sprite.svg#site_portfolio"></use></svg>Портфолио для сайтов</div>'.
				'<div class="e_cpanel_block e_cpanel_additional_add" data-type="scrolling_vertical"><svg><use xlink:href="/edit/template/sprite.svg#site_vertical-scroll"></use></svg>Вертикальный скроллер</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="icon"><svg><use xlink:href="/edit/template/sprite.svg#icon"></use></svg>Иконки</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="mapsyandex"><svg><use xlink:href="/edit/template/sprite.svg#map"></use></svg>Карта</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="contacts"><svg><use xlink:href="/edit/template/sprite.svg#home"></use></svg>Контакты</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="menu"><svg><use xlink:href="/edit/template/sprite.svg#menu"></use></svg>Меню</div>'.
     			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="breadcrumbs"><svg><use xlink:href="/edit/template/sprite.svg#breadcrumbs"></use></svg>Путь по сайту</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="callback"><svg><use xlink:href="/edit/template/sprite.svg#phone"></use></svg>Обратный звонок</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="buttonup"><svg><use xlink:href="/edit/template/sprite.svg#up"></use></svg>Наверх</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="virtual_tour"><svg><use xlink:href="/edit/template/sprite.svg#panorama"></use></svg>Панорама 360°</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="image_360"><svg><use xlink:href="/edit/template/sprite.svg#360"></use></svg>Изображение 360°</div>'.
    			'<div class="e_cpanel_block e_cpanel_additional_add" data-type="catalog"><svg><use xlink:href="/edit/template/sprite.svg#catalog"></use></svg>Каталог</div>'.
    			'<div id="e_cpanel_blocks_code" class="e_cpanel_block"><svg><use xlink:href="/edit/template/sprite.svg#code"></use></svg>Html, js код</div>'.
    			'<div id="e_cpanel_blocks_php_code" class="e_cpanel_block"><svg><use xlink:href="/edit/template/sprite.svg#code_2"></use></svg>Php код</div>'.
    		'</div>'.
		'</div>'.
        '<div class="e_cpanel_bottom">'.
            '<div id="e_cpanel_css" class="e_cpanel_block_2">CSS</div>'.
            '<div id="e_cpanel_help" class="e_cpanel_block_2">Помощь</div>'.
        '</div>'.
    '</div>'.
    '<div id="e_cpanel_additional"></div>'.
    '<div id="e_cpanel_close"><svg><use xlink:href="/edit/template/sprite.svg#delete"></use></svg></div>'.
'</div>';

$SITE->setCpanel($html);