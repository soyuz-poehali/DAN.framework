<?php
defined('AUTH') or die('Restricted access');

function hex_to_rgba($hex, $alpha = false){
	$hex = str_replace('#', '', $hex);
	$length = strlen($hex);
	$rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
	$rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
	$rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
	if ( $alpha ) {
	  $rgb['a'] = $alpha;
	}
	return $rgb;
}

function rgb_to_hex($rgb){
	$rgb_arr = explode(',', $rgb, 3);
	return sprintf("#%02x%02x%02x", $rgb_arr[0], $rgb_arr[1], $rgb_arr[2]);
}

function hex_bg($hex, $alpha = false)
{
	if(!$alpha)
	{
		$bg_style = $hex ? 'background-color:'.$hex.';' : '';
	}
	else // RGB
	{
		list($R, $G, $B) = sscanf($hex, "#%02x%02x%02x");
		$bg_style = 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$alpha.');';
	}
	
	return $bg_style;
}

?>