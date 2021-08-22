<?php
// Проверяет расширение файла изображения 
defined('AUTH') or die('Restricted access');

class CheckImageFile {
	public function __construct($file)
	{
		if (!isset($file))
			return false;

		// Размер изображения больше 3 Mb
		if ($file['size'] > 3000000)
			return false;

		$file_name_arr = explode('.', $file['name']);
		$count = count($file_name_arr);

		if(($count) < 2)   // Без расширения
			return false;

		$ext = $file_name_arr[$count - 1];
		$ban = array('exe', 'php', 'phtml', 'html', 'sh', 'pl', 'cgi', 'htaccess');
		$allowed = array('jpg', 'jpeg', 'gif', 'png', 'webp');

		if(in_array($ext, $ban))   // С запрещённым расширением
			return false;

		// Двойное расширение
		if (($count) > 2) {
			foreach ($file_name_arr as $ex) {
				if(in_array($ex, $ban))
					return false;
			}	
		}

		if(!in_array($ext, $allowed))   // Проверка на разрешённые расширения
			return false;

		$size = getimagesize($file['tmp_name']);   // Получим размер изображения и его тип
		$type = $size[2];

		if(!($type == 1 || $type == 2 || $type == 3))   // Если не соответствует мим тип
			return false;
	}
}