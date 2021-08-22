<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
<link rel="stylesheet" href="/administrator/templates/css/templates.css" type="text/css" />
<link rel="stylesheet" href="/lib/DAN/DAN.css" type="text/css" />
<script src="/lib/DAN/DAN.js"></script>
<? $SITE->getHead(); ?>
</head>
<body id="blocks">
<div class="container">
	<div class="left_panel">
		<div class="left_panel_header">
			<div class="left_panel_logo">ПОЕХАЛИ!</div>
			<div class="left_panel_phone">Система взаимодействия с тревел-блогерами.</div>
		</div>
		<a href="/admin/pages" target="blank" class="ico_left_square">
			<svg><use xlink:href="/administrator/templates/images/sprite.svg#pages"></use></svg>
			<div class="ico_left_square_text">Страницы</div>
		</a>
		<a href="/admin/com/catalogs" target="blank" class="ico_left_square">
			<svg><use xlink:href="/administrator/templates/images/sprite.svg#section"></use></svg>
			<div class="ico_left_square_text">Каталог</div>
		</a>
		<a href="/administrator/plugins/filemanager/index.php" target="blank" class="ico_left_square">
			<svg><use xlink:href="/administrator/templates/images/sprite.svg#files"></use></svg>
			<div class="ico_left_square_text">Файлы</div>
		</a>
		<a href="/admin/settings" target="blank" class="ico_left_square">
			<svg><use xlink:href="/administrator/templates/images/sprite.svg#gear"></use></svg>
			<div class="ico_left_square_text">Настройки</div>
		</a>
		<a href="/admin/personal_information" target="blank" class="ico_left_square">
			<svg><use xlink:href="/administrator/templates/images/sprite.svg#form"></use></svg>
			<div class="ico_left_square_text">Конфиденц.</div>
		</a>
		<a href="/admin/administrators" target="blank" class="ico_left_square">
			<svg><use xlink:href="/administrator/templates/images/sprite.svg#users"></use></svg>
			<div class="ico_left_square_text">Админ.</div>
		</a>		
		<div class="ico_left_square_border">&nbsp;</div>
	</div>
	<div class="main">
		<div class="header">
			<div>
				<a href="/admin" target="blank" class="header_ico_square">
					<svg><use xlink:href="/administrator/templates/images/sprite.svg#home"></use></svg>
					<div class="header_ico_square_text">Главная</div>
				</a>				
			</div>
			<div>&nbsp;</div>
			<div class="dan_flex_row">
				<a href="/admin/view" target="_blank" class="header_ico_square">
					<svg><use xlink:href="/administrator/templates/images/sprite.svg#eye"></use></svg>
					<div class="header_ico_square_text">Просмотр</div>
				</a>
				<a href="/admin/edit" target="_blank" class="header_ico_square">
					<svg><use xlink:href="/administrator/templates/images/sprite.svg#edit"></use></svg>
					<div class="header_ico_square_text">Ред.</div>
				</a>
				<a href="/admin/logout" target="_blank" class="header_ico_square">
					<svg><use xlink:href="/administrator/templates/images/sprite.svg#exit"></use></svg>
					<div class="header_ico_square_text">Выход</div>
				</a>
				<? module_upgrade(); ?>		
			</div>
		</div>
		<div class="content">
			<div class="wrap">
				<? $SITE->getContent(); ?>
			</div>	
		</div>
		<div class="footer"></div>
	</div>
</div>

</body>
</html>
