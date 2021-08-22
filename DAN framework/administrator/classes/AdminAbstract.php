<?php
defined('AUTH') or die('Restricted access');

class AdminAbstract
{
	public function removeDirectory($dir) 
	{
		if ($objs = glob($dir."/*")) {
			foreach ($objs as $obj) {
	     		is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
	   		}
		}
		if (is_dir($dir))
			rmdir($dir);
	}
}