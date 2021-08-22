<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/templates/template.css" type="text/css" />
	<link rel="stylesheet" href="/templates/style.css" type="text/css" />
	<link rel="stylesheet" href="/lib/DAN/DAN.css" type="text/css" />
	<script src="/lib/DAN/DAN.js"></script>
	<? $SITE->getHead(); ?>
</head>
<body>
<? $SITE->getCpanel(); ?>
<div id="blocks">
	<? $SITE->getContent(); ?>
</div>
<div class="footer">
	<? $SITE->getFooter(); ?>
</div>
</body>
</html>
