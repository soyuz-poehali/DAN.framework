<?php
defined("AUTH") or die("Restricted access");

// Рекурсивное удаление директории
function remove_directory($dir) 
{
	if ($objs = glob($dir."/*")) {
		foreach($objs as $obj) {
     		is_dir($obj) ? remove_directory($obj) : unlink($obj);
   		}
	}
	if (is_dir($dir))
		rmdir($dir);
}

?>