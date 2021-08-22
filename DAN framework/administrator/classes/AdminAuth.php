<?php
defined('AUTH') or die('Restricted access');

class AdminAuth
{
	public function login($login, $pass)
	{
		global $db;

		$pass_hash =  md5('dan'.$pass);

		$stmt = $db->prepare("SELECT id FROM administrators WHERE login = :login AND psw = :psw LIMIT 1");
		$stmt->execute(array('login' => $login, 'psw' => $pass_hash));
		if ($stmt->rowCount() > 0)
			return true;
		return false;
	}
}