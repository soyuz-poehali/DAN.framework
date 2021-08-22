<?php
defined('AUTH') or die('Restricted access');

$page = $SITE->getPage();

$SITE->setHeadFile('/blocks/template/css/style.css');
$SITE->setHeadFile('/administrator/help/template/style.css');
$SITE->setHeadFile('/lib/DAN/hexToRGB/hexToRGB.js');
$SITE->setHeadFile('/lib/DAN/accordion/accordion.css');
# $SITE->setHeadFile('/lib/DAN/tooltip/tooltip.css');
# $SITE->setHeadFile('/lib/DAN/tooltip/tooltip.js');
$SITE->setHeadFile('/lib/DRAG_DROP/DRAG_DROP.css');
$SITE->setHeadFile('/lib/DRAG_DROP/DRAG_DROP.js');
$SITE->setHeadFile('/administrator/plugins/ckeditor_inline/ckeditor.js');

$SITE->setHeadFile('/lib/codemirror/codemirror.js');
$SITE->setHeadFile('/lib/codemirror/clike.js');
$SITE->setHeadFile('/lib/codemirror/css.js');
$SITE->setHeadFile('/lib/codemirror/htmlmixed.js');
$SITE->setHeadFile('/lib/codemirror/javascript.js');
$SITE->setHeadFile('/lib/codemirror/php.js');
$SITE->setHeadFile('/lib/codemirror/xml.js');
$SITE->setHeadFile('/lib/codemirror/codemirror.css');
$SITE->setHeadFile('/lib/codemirror/dan.css');

$SITE->setHeadFile('/edit/blocks/template/e_blocks.css');
$SITE->setHeadFile('/edit/template/EDIT.js');
$SITE->setHeadFile('/edit/template/EDIT.css');
$SITE->setHeadFile('/edit/blocks/template/EDIT.block.js');
$SITE->setHeadFile('/edit/blocks/template/EDIT.block.settings.js');
$SITE->setHeadFile('/blocks/text/edit/template/EDIT.block.text.js');
$SITE->setHeadFile('/blocks/image/edit/template/EDIT.block.image.js');
$SITE->setHeadFile('/blocks/photogallery/edit/template/EDIT.block.photogallery.js');
$SITE->setHeadFile('/blocks/slider/edit/template/EDIT.block.slider.js');
$SITE->setHeadFile('/blocks/video/edit/template/EDIT.block.video.js');
$SITE->setHeadFile('/blocks/form/edit/template/EDIT.block.form.js');
$SITE->setHeadFile('/blocks/packages/edit/template/EDIT.block.packages.js');
$SITE->setHeadFile('/blocks/case/edit/template/EDIT.block.case.js');
$SITE->setHeadFile('/blocks/case_2/edit/template/EDIT.block.case_2.js');
$SITE->setHeadFile('/blocks/site_portfolio/edit/template/EDIT.block.site_portfolio.js');
$SITE->setHeadFile('/blocks/scrolling_vertical/edit/template/EDIT.block.scrolling_vertical.js');
$SITE->setHeadFile('/blocks/buttonup/edit/template/EDIT.block.buttonup.js');
$SITE->setHeadFile('/blocks/callback/edit/template/EDIT.block.callback.js');
$SITE->setHeadFile('/blocks/icon/edit/template/EDIT.block.icon.js');
$SITE->setHeadFile('/blocks/mapsyandex/edit/template/EDIT.block.mapsyandex.js');
$SITE->setHeadFile('/blocks/contacts/edit/template/EDIT.block.contacts.js');
$SITE->setHeadFile('/blocks/virtual_tour/edit/template/EDIT.block.virtual_tour.js');
$SITE->setHeadFile('/blocks/image_360/edit/template/EDIT.block.image_360.js');
$SITE->setHeadFile('/blocks/catalog/edit/template/EDIT.block.catalog.js');
$SITE->setHeadFile('/blocks/code/edit/template/EDIT.block.code.js');
$SITE->setHeadFile('/blocks/php_code/edit/template/EDIT.block.php_code.js');
$SITE->setHeadFile('/blocks/menu/edit/template/EDIT.block.menu.js');
$SITE->setHeadCode('<script>EDIT.p = '.$SITE->page['id'] .'</script>');