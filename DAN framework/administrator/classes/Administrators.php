<?php
defined('AUTH') or die('Restricted access');

class Administrators
{
	// Все пользователи со статусом ниже $admin_id
	public function getAdmins($admin_id)
	{
		global $db;

		$stmt = $db->prepare("
			SELECT * FROM administrators 
			WHERE status < (SELECT status FROM administrators WHERE id = :admin_id)
		");
		$stmt->execute(array('admin_id' => $admin_id));

		return $stmt->fetchAll();
	}

	public function getAdmin($id)
	{
		global $db;

		$stmt = $db->prepare("SELECT * FROM administrators WHERE id = :id LIMIT 1");
		$stmt->execute(array('id' => $id));
		return $stmt->fetch();
	}

	public function insertAdmin($data)
	{
		global $db;

		// Проверяем - не занят ли логин
		$stmt = $db->prepare("SELECT id FROM administrators WHERE login = :login LIMIT 1");
		$stmt->execute(array('login' => $data['login']));
		if ($stmt->rowCount() > 0)
			return false;

		if (mb_strlen($data['psw']) < 8)
			return false;

		$stmt_insert = $db->prepare("INSERT INTO administrators SET login = :login, description = :description, status = :status");
		$stmt_insert->execute(array('login' => $data['login'], 'description' => $data['description'], 'status' => $data['status']));

		return true;
	}

	public function updateAdmin($data)
	{
		global $db;

		// Проверяем - не занят ли логин
		$stmt = $db->prepare("SELECT id FROM administrators WHERE login = :login AND id != :id LIMIT 1");
		$stmt->execute(array('login' => $data['login'], 'id' => $data['id']));
		if ($stmt->rowCount() > 0)
			return false;

		if (mb_strlen($data['psw']) > 7) {
			$pass_hash =  md5('dan'.$data['psw']);
			$stmt_update = $db->prepare("UPDATE administrators SET login = :login, psw = :psw, description = :description, status = :status WHERE id = :id");
			$stmt_update->execute(array('login' => $data['login'], 'psw' => $pass_hash, 'description' => $data['description'], 'status' => $data['status'], 'id' => $data['id']));
		} else {
			$stmt_update = $db->prepare("UPDATE administrators SET login = :login, description = :description, status = :status WHERE id = :id");
			$stmt_update->execute(array('login' => $data['login'], 'description' => $data['description'], 'status' => $data['status'], 'id' => $data['id']));
		}

		return true;
	}

	public function deleteAdmin($admin_id)
	{
		global $db;

		$current_admin_id = $_SESSION['admin'];

		// Находим статус нашего пользователя
		$stmt = $db->prepare("
			SELECT id 
			FROM administrators
			WHERE id = :admin_id
			AND status < (SELECT status FROM administrators WHERE id = :current_admin_id)
			LIMIT 1
		");

		$stmt->execute(array('admin_id' => $admin_id, 'current_admin_id' => $current_admin_id));
		if ($stmt->rowCount() == 0)
			return false;


		$stmt_delete = $db->prepare("DELETE FROM administrators WHERE id = :id");
		$stmt_delete->execute(array('id' => $admin_id));

		return true;
	}
}