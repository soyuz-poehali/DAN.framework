<?php
defined('AUTH') or die('Restricted access');

function e_bg_image($dir, $image_old)
{
	global $SITE;

	if (isset($_FILES['bg_image'])) {
		$file_tmp = $_FILES['bg_image']['tmp_name'];
		$file_name = mb_strtolower($_FILES['bg_image']['name']); // Оригинальное имя файла на компьютере клиента.
		$file_type = $_FILES['bg_image']['type']; // Mime-тип файла, в случае, если браузер предоставил такую информацию. Пример: "image/gif".
		$file_size = $_FILES['bg_image']['size']; // Размер в байтах принятого файла.

		if ($file_size > 700000) {
			$err_image = 'Изображение слишком большое - '.$file_size;
			$SITE->errLog($err_image);
		}

		// --- Проверяем расширение изображения ---
		$file_name_arr = explode('.', $file_name);
		$ext = array_pop($file_name_arr); // Извлекает последний элемент массива, уменьшая его на 1
		// $img_name = implode('', $file_name_arr);
		// $img_name = translit($img_name);
		// $img_name = preg_replace('/[^a-z0-9_\-]/i','',$img_name);
		// if(strlen($img_name) > 50) $img_name = substr($img_name, 0, 50);

		if (!($ext == 'webp' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png')) {
			$err_image = 'Тип файла - не изображение формата - '.$file_name;
			$SITE->errLog($err_image);
		}

		// --- Проверяем тип файла ---
		$size = getimagesize($file_tmp); // Получим размер изображения и его тип
		$src_width = $size[0];
		$src_height = $size[1];
		$type = $size[2];

		if (!($type == 1 || $type == 2 || $type == 3)) {
			$err_image = 'Тип файла - не изображение формата. Мим тип:'.$type;
			$SITE->errLog($err_image);
		}

		if (!is_dir($dir.'/background')) {
			if (!mkdir($dir.'/background', 0755, true)) {
				$err_image = 'Не возможно создать директорию '.$dir;
				$SITE->errLog($err_image);
			}
		}

		$file_name_new = uniqid().'.'.$ext;

		if (move_uploaded_file($file_tmp, $dir.'/background/'.$file_name_new)) {
			@chmod($dir.'/background/'.$file_name_new, 0644);

			// Удаляем старый файл
			$file_old = $dir.'/background/'.$image_old;
			if (is_file($file_old))
				unlink($file_old);
			return $file_name_new;
		}
	}

	return False;
}

?>