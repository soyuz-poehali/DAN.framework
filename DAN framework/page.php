<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/template/css/style.css');
$SITE->setHeadFile('/blocks/template/css/block.css');
$SITE->setHeadFile('/blocks/template/js/BLOCK.js');
$SITE->setHeadFile('/lib/DAN/hexToRGB/hexToRGB.js');

$page = $SITE->getPage();

if (!$page) {
	header("HTTP/1.0 404 Not Found");
	include "404.php";
	exit;
}

if ($page['type'] != 'catalog') {
	$SITE->setHeadCode('<title>'.$page['data']['tag_title'].'</title>');
	$SITE->setHeadCode('<meta name="description" content="'.$page['data']['tag_description'].'" />');
}

$blocks = $SITE->getPageBlocks($page['id']);

$folders = isset($_SESSION['edit']) ? 'edit/template' : 'frontend';  // fronend / edit

foreach ($blocks as $block) {
	$no_serialise_block = ['code'];

	if (!in_array($block['type'], $no_serialise_block))
		$block['content'] = unserialize($block['content']);

	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/'.$block['type'].'/'.$folders.'/template.php';
	$func_name = 'block_'.$block['type'];
	$SITE->content .= $func_name($block);
}
?>