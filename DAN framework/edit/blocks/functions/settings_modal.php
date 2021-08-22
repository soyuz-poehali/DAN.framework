<?php
defined('AUTH') or die('Restricted access');

// Фон блока
function e_block_settings_bg($data)
{
	$bg_n_selected = $bg_1_selected = $bg_2_selected = $bg_3_selected = $bg_c_selected = $bg_i_selected = $bg_color_out = '';

	$d = $data['content'];

	switch ($d['bg_type']) {
		case '1': $bg_1_selected = 'selected'; break;
		case '2': $bg_2_selected = 'selected'; break;
		case '3': $bg_3_selected = 'selected'; break;
		case 'c': $bg_c_selected = 'selected'; break;
		case 'i': $bg_i_selected = 'selected'; break;
		default: $bg_n_selected = 'selected'; break;
	}

	$bg_image_repeat = $bg_image_cover = '';

	switch ($d['bg_image_size']) {
		case 'repeat': $bg_image_repeat = 'checked'; 
			break;
		default: $bg_image_cover = 'checked'; 
			break;
	}

	if ($d['color'] == 'var(--font-color)') $d['color'] = '#444444';
	if ($d['font_size'] == 'var(--font-size)') $d['color'] = 16;

	$out =
	'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Фон</summary>'.
		'<div>'.
		'<table class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Фон блока</td>'.
				'<td>'.
					'<select id="e_block_modal_bg_type" class="dan_input" name="bg_type">'.
						'<option '.$bg_n_selected.' value="">Нет</option>'.
						'<option '.$bg_1_selected.' value="1">Цвет 1 из настроек сайта</option>'.
						'<option '.$bg_2_selected.' value="2">Цвет 2 из настроек сайта</option>'.
						'<option '.$bg_3_selected.' value="3">Цвет 3 из настроек сайта</option>'.
						'<option '.$bg_c_selected.' value="c">Свой цвет</option>'.
						'<option '.$bg_i_selected.' value="i">Изображение</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
		'</table>'.
		'<div id="e_block_modal_container_bg_color">'.$bg_color_out.'</div>'.
		'<table id="e_block_modal_container_bg_color_mannuale" class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Цвет, установленный вручную</td>'.
				'<td><input id="e_block_modal_container_bg_color_input" class="dan_input" type="color" name="bg_color" value="'.$d['bg_color'].'"></td>'.
			'</tr>'.
		'</table>'.
		'<table id="e_block_modal_container_bg_image" class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Изображение</td>'.
				'<td><input id="e_block_modal_bg_image_file" type="file" name="bg_image" value=""></td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right"><div class="e_flex_center_r">Растянуть<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#fullscreen"></use></svg></div></td>'.
				'<td><input id="e_block_modal_bg_image_size_1" class="dan_input" type="radio" name="bg_image_size" value="cover" '.$bg_image_cover.'><label for="e_block_modal_bg_image_size_1"></label></td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right"><div class="e_flex_center_r">Плиткой<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#repeat"></use></svg></div></td>'.
				'<td><input id="e_block_modal_bg_image_size_2" class="dan_input" type="radio" name="bg_image_size" value="repeat" '.$bg_image_repeat.'><label for="e_block_modal_bg_image_size_2"></label></td>'.
			'</tr>'.
		'</table>'.
		'</div>'.
	'</details>';

	return $out;
}


// Подложка
function e_block_settings_wrap($data)
{
	$d = $data['content'];

	if (empty($d['wrap_bg_color'])) {
		$wrap_bg_color = '#ffffff';
		$wrap_bg_color_check = '';
		$wrap_bg_display = 'none';
	} else {
		$wrap_bg_color = $d['wrap_bg_color'];
		$wrap_bg_color_check = 'checked';
		$wrap_bg_display = 'inline-block';
	}

	$out =
	'<details id="e_block_modal_wrap" class="dan_accordion">'.
		'<summary>Подложка</summary>'.
		'<div>'.
			'<table class="e_table_admin">'.
				'<tr>'.
					'<td class="e_td_right">Подложка</td>'.
					'<td><input id="e_block_modal_wrap_bg_color_check" class="dan_input" name="wrap_bg_color_check" type="checkbox" value="" '.$wrap_bg_color_check.'><label for="e_block_modal_wrap_bg_color_check"></label> &nbsp; <input id="e_block_modal_wrap_bg_color" style="display:'.$wrap_bg_display.'" class="dan_input" name="wrap_bg_color" type="color" value="'.$wrap_bg_color.'"></td>'.
				'</tr>'.
				'<tr id="e_block_modal_wrap_opacity_tr">'.
					'<td class="e_td_right">Непрозрачность подложки</td>'.
					'<td><div class="e_flex_center_h"><input id="e_block_modal_wrap_opacity" name="wrap_bg_opacity" type="range" min="10" max="100" step="5" value="'.($d['wrap_bg_opacity'] * 100).'"><div class="e_modal_range_out"><span id="e_block_modal_wrap_opacity_out"></span>%</div></div></td>'.
				'</tr>'.
			'</table>'.
		'</div>'.
	'</details>';

	return $out;
} 


// Размер блока
function e_block_settings_size($data)
{
	$wrap_width_select_100 = $wrap_width_select_1600 = $wrap_width_select_1440 = $wrap_width_select_1280 = $wrap_width_select_600 = '';

	$d = $data['content'];

	switch ($d['max_width']) {
		case '100': $wrap_width_select_100 = 'selected'; break;
		case '1600': $wrap_width_select_1600 = 'selected'; break;
		case '1440': $wrap_width_select_1440 = 'selected'; break;
		case '1280': $wrap_width_select_1280 = 'selected'; break;
		case '600': $wrap_width_select_600 = 'selected'; break;
		default: $wrap_width_select_custom = 'selected'; break;
	}
	
	$arr = array(100, 1600, 1440, 1280, 600);
	$wrap_width_select_custom_option = !in_array($d['max_width'], $arr) ? '<option value="'.$d['max_width'].'" '.$wrap_width_select_custom.'>'.$d['max_width'].'</option>' : '';

	$out =
	'<details id="e_block_modal_size" class="dan_accordion">'.
		'<summary>Размер блока</summary>'.
		'<div>'.
			'<table class="e_table_admin">'.
				'<tr>'.
					'<td class="e_td_right">Максимальная ширина</td>'.
					'<td>'.
						'<select id="e_block_modal_max_width" class="dan_input">'.
							'<option value="100" '.$wrap_width_select_100.'>100%</option>'.
							'<option value="1600" '.$wrap_width_select_1600.'>1600px</option>'.
							'<option value="1440" '.$wrap_width_select_1440.'>1440px</option>'.
							'<option value="1280" '.$wrap_width_select_1280.'>1280px</option>'.
							'<option value="600" '.$wrap_width_select_600.'>600px</option>'.
							$wrap_width_select_custom_option.
						'</select>'.
					'</td>'.
				'</tr>'.
				'<tr>'.
					'<td class="e_td_right">Внешний отступ</td>'.
					'<td><input id="e_block_modal_margin" class="dan_input" type="number" min="0" max="100" value="'.$d['margin'].'"></td>'.
				'</tr>'.
				'<tr>'.
					'<td class="e_td_right">Внутренний отступ</td>'.
					'<td><input id="e_block_modal_padding" class="dan_input" type="number" min="0" max="100" value="'.$d['padding'].'"></td>'.
				'</tr>'.
			'</table>'.
		'</div>'.
	'</details>';

	return $out;
}


// Шрифты
function e_block_settings_font($data)
{
	$content = $data['content'];

	$font_s_selected = $font_m_selected = '';
	if ($content['font_size'] == 'var(--font-size)') {
		$font_s_selected = 'selected';
	} else {
		$font_m_selected = 'selected';
	}

	$out =
	'<details id="e_block_modal_font" class="dan_accordion">'.
		'<summary>Шрифт</summary>'.
		'<div>'.
			'<table class="e_table_admin">'.
				'<tr>'.
					'<td class="e_td_right">Шрифт</td>'.
					'<td>'.
						'<select id="e_block_modal_font_select" class="dan_input">'.
							'<option value="s" '.$font_s_selected.'>Из настроек сайта</option>'.
							'<option value="m" '.$font_m_selected.'>Свой размер и цвет</option>'.
						'</select>'.
					'</td>'.
				'</tr>'.
				'<tr id="e_block_modal_font_tr">'.
					'<td class="e_td_right">Размер, цвет основного шрифта</td>'.
					'<td><div class="e_flex_center_h"><input id="e_block_modal_font_size" class="dan_input" type="number" min="10" max="48" value="'.$content['font_size'].'">&nbsp;<input  id="e_block_modal_font_color" class="dan_input" type="color" value="'.$content['color'].'"></div></td>'.
				'</tr>'.
				'<tr>'.
					'<td class="e_td_right">Межстрочный интервал</td>'.
					'<td><div class="e_flex_center_h"><input id="e_block_modal_line_height" type="range" min="0.8" max="2" step="0.1" value="'.($content['line_height']).'"><div class="e_modal_range_out"><span id="e_block_modal_line_height_out"></span></div></div></td>'.
				'</tr>'.
			'</table>'.
		'</div>'.
	'</details>';

	return $out;
}

?>