<?php
defined('AUTH') or die('Restricted access');

function breadcrumbs($arr)
{
	global $SITE;

	$html = '';
	$svg = ' <svg><use xlink:href="/administrator/templates/images/sprite.svg#arrow_right_1"></use></svg>';
	$svg_home = '<a href="/admin"><svg class="home"><use xlink:href="/administrator/templates/images/sprite.svg#home"></use></svg></a>';
	foreach ($arr as $key => $value) {
		if($key == '')
			$html .= $svg.'<span>'.$value.'</span>';
		else
			$html .= $svg.'<a href="'.$key.'">'.$value.'</a>';
	}

	return '<div class="breadcrumbs">'.$svg_home.$html.'</div>';
}

?>