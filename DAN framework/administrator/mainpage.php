<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Administrators.php';
$ADMIN = new Administrators;
$admin_id = $_SESSION['admin'];
$administrator = $ADMIN->getAdmin($admin_id);

if ($administrator['status'] > 1) {
	$administrator_html = 
	'<a href="/admin/administrators" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#users"></use></svg>
		<div class="ico_square_text">Админы</div>
	</a>';

} else {
	$administrator_html = '';
}

$SITE->content = 
'<div class="dan_flex_row_start">'.
	'<a href="/admin/com/poehali" target="blank" class="ico_square poehali">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#poehali"></use></svg>
		<div class="ico_square_text">Поехали!</div>
	</a>
	<a href="/admin/pages" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#pages"></use></svg>
		<div class="ico_square_text">Страницы</div>
	</a>
	<a href="/admin/com/catalogs" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#section"></use></svg>
		<div class="ico_square_text">Каталог</div>
	</a>
	<a href="/admin/settings" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#gear"></use></svg>
		<div class="ico_square_text">Настройки</div>
	</a>'.
	/*
	'<a href="/admin/help" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#help"></use></svg>
		<div class="ico_square_text">Помощь</div>
	</a>'.
	*/
	$administrator_html.
	/*
	'<a href="/admin/crm" target="blank" class="ico_square">
		<svg><use xlink:href="/administrator/templates/images/sprite.svg#calendar"></use></svg>
		<div class="ico_square_text">CRM</div>
	</a>'.
	*/
'</div>';

?>