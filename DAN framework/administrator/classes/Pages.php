<?php
defined('AUTH') or die('Restricted access');

class Pages
{
	private $menu_tree = [];


	public function getPage($id)
	{
		global $db;

		$stmt = $db->prepare("SELECT * FROM pages WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$page = $stmt->fetch();

		if ($stmt->rowCount() == 0)
			return false;

		$unserialize = unserialize($page['data']);
		$page['tag_title'] = $unserialize['tag_title'];
		$page['tag_description'] = $unserialize['tag_description'];
		unset($page['data']);

		return $page;
	}


	public function getPages($exception_list=false)
	{
		global $db;

		$exception_sql = $exception_list ? 'WHERE id NOT IN('.$exception_list.')' : '';

		$query = $db->query("SELECT * FROM pages $exception_sql ORDER BY ordering");
		$pages = $query->fetchAll();

		$i = 0;
		foreach ($pages as $page) {
			$unserialize = unserialize($page['data']);
			$pages[$i]['tag_title'] = $unserialize['tag_title'];
			$pages[$i]['tag_description'] = $unserialize['tag_description'];
			unset($pages[$i]['data']);
			$i++;
		}

		return $pages;
	}


	public function insertPage($data, $type='page')  // $type = 'page' || 'catalog'
	{
		global $db;

		$stmt = $db->prepare("SELECT id FROM pages WHERE url = :url LIMIT 1");
		$stmt->execute(array('url' => $data['url']));

		if($stmt->rowCount() > 0)
			return false;

		$query = $db->query("SELECT MAX(ordering) FROM pages");

		$ordering = intval($query->fetchColumn()) + 1;

		$arr['tag_title'] = $data['tag_title'];
		$arr['tag_description'] = $data['tag_description'];
		$serialize = serialize($arr);

		$stmt_update = $db->prepare("INSERT INTO pages SET url = :url, type = :type, data = :data, status = :status, ordering = :ordering");
		$stmt_update->execute(array('url' => $data['url'], 'type' => 'page', 'data' => $serialize, 'status' => $data['status'], 'ordering' => $ordering));

		return true;
	}


	public function updatePage($data, $type='page')  // $type = 'page' || 'catalog'
	{
		global $db;

		$stmt = $db->prepare("SELECT id FROM pages WHERE url = :url AND id != :id LIMIT 1");
		$stmt->execute(array('url' => $data['url'], 'id' => $data['id']));

		if($stmt->rowCount() > 0)
			return false;

		$arr['tag_title'] = $data['tag_title'];
		$arr['tag_description'] = $data['tag_description'];
		$serialize = serialize($arr);

		$stmt_update = $db->prepare("UPDATE pages SET url = :url, data = :data, status = :status WHERE id = :id");
		$stmt_update->execute(array('url' => $data['url'], 'data' => $serialize, 'status' => $data['status'], 'id' => $data['id']));

		return true;
	}


	public function setPage($data)
	{
		global $db;
		$stmt = $db->prepare("UPDATE pages SET type = :type, status = :status WHERE id = :id");
		$stmt->execute(array('type' => $data['type'], 'status' => $data['status'], 'id' => $data['id']));
	}


	public function setPageOrdering($data)
	{
		global $db;

		$menu_query = $db->query("SELECT link_type, parameter FROM menu");
		$menu = $menu_query->fetchAll();

		$ignore_arr = [];
		foreach ($menu as $m) {
			if ($m['link_type'] == 'page')
				$ignore_arr[] = intval($m['parameter']);
		}

		$ignore_list = implode(',', $ignore_arr);
		$pages_query = $db->query("SELECT id FROM pages WHERE id NOT IN($ignore_list) ORDER BY ordering");

		$array = [];
		$pages = $pages_query->fetchAll();

		$index = 0;  // Индекс актуального элемента
		// Перебираем массив, что бы удалить возможные дырки массива
		$i = 0;
		foreach ($pages as $page) { 
			$array[] = $page['id'];
			if ($page['id'] == $data['id'])
				$index = $i;
			$i++;
		}

		if ($data['ordering'] == 'up') {
			if ($index == 0)  // Самый верхний пункт меню - прерываем выполнение
				return;

			$prev = $array[$index - 1];

			$array[$index - 1] = $array[$index];
			$array[$index] = $prev;
		} else {
			if ($index == $i)  // Самый последний элемент, ниже некуда.
				return;
			$next = $array[$index + 1];
			$array[$index + 1] = $array[$index];
			$array[$index] = $next;
		}

		$stmt_update = $db->prepare("UPDATE pages SET ordering = :ordering WHERE id = :id");
		$i = 1;
		foreach ($array as $id) {
			$stmt_update->execute(array('ordering' => $i, 'id' => $id));
			$i++;
		}
	}


	public function setPageStatus($data)
	{
		global $db;
		$stmt = $db->prepare("UPDATE pages SET status = :status WHERE id = :id");
		$stmt->execute(array('status' => $data['status'], 'id' => $data['id']));				
	}


	public function deletePage($id)
	{
		global $db;

		$stmt = $db->prepare("DELETE FROM pages WHERE id = :id");
		$stmt->execute(array('id' => $id));		
	}


	public function getMenu($id)
	{
		global $db;

		$stmt = $db->prepare("SELECT * FROM menu WHERE id = :id");
		$stmt->execute(array('id' => $id));
		return $stmt->fetch();
	}


	public function getMenuTree($type='top', $parent_id=0, $level=0, $ignore_id=0) 
	{
		// $type - тип меню, $pages - выводить ли связанные страницы, $parent_id - родительский пункт меню, $ignore_id - игнорировать id меню
		global $db;

		$stmt = $db->prepare("
			SELECT m.id, m.name, m.parent_id, m.link_type, m.parameter, m.status 
			FROM menu m 
			WHERE m.type = :type AND m.parent_id = :parent_id ORDER BY ordering
		");

		$stmt->execute(array('type' => $type, 'parent_id' => $parent_id));
		if($stmt->rowCount() > 0) {
			$level++;
			$menu = $stmt->fetchAll();
			foreach ($menu as $m) {
				if ($m['id'] == $ignore_id)
					continue;
				$m['level'] = $level - 1;
				$this->menu_tree[] = $m;
				$this->getMenuTree($type, $m['id'], $level, $ignore_id);	
			}
		}
		return $this->menu_tree;
	}


	public function getMenuMaxOrdering($type='top')
	{
		global $db;

		$stmt = $db->prepare("SELECT MAX(ordering) FROM menu WHERE type = :type");
		$stmt->execute(array('type' => $type));
		return intval($stmt->fetchColumn());
	}


	public function insertMenu($data)
	{
		global $db;

		$stmt = $db->prepare("
		INSERT INTO menu SET 
			type = :type,
			name = :name,
			parent_id = :parent_id,
			link_type = :link_type,
			parameter = :parameter,
			ordering = :ordering,
			status = :status
		");

		$stmt->execute(array(
			'type' => $data['type'],
			'name' => $data['name'],
			'parent_id' => $data['parent_id'],
			'link_type' => $data['link_type'],
			'parameter' => $data['parameter'],
			'ordering' => $data['ordering'],
			'status' => $data['status']
		));

		return $db->lastInsertId();
	}


	public function setMenuOrdering($data)
	{
		global $db;

		$stmt_select = $db->prepare("
			SELECT m.id 
			FROM menu m
			JOIN menu r
			ON m.type = r.type
			WHERE r.id = :id AND m.parent_id = r.parent_id ORDER BY m.ordering
		");
		$stmt_select->execute(array('id' => $data['id']));

		$array = [];
		$menu = $stmt_select->fetchAll();

		$index = 0;  // Индекс актуального элемента
		// Перебираем массив, что бы удалить возможные дырки массива
		$i = 0;
		foreach ($menu as $m) { 
			$array[] = $m['id'];
			if ($m['id'] == $data['id'])
				$index = $i;
			$i++;
		}

		if ($data['ordering'] == 'up') {
			if ($index == 0)  // Самый верхний пункт меню - прерываем выполнение
				return;

			$prev = $array[$index - 1];

			$array[$index - 1] = $array[$index];
			$array[$index] = $prev;
		} else {
			if ($index == $i)  // Самый последний элемент, ниже некуда.
				return;
			$next = $array[$index + 1];
			$array[$index + 1] = $array[$index];
			$array[$index] = $next;
		}

		$stmt_update = $db->prepare("UPDATE menu SET ordering = :ordering WHERE id = :id");
		$i = 1;
		foreach ($array as $id) {
			$stmt_update->execute(array('ordering' => $i, 'id' => $id));
			$i++;
		}
	}


	public function updateMenu($data)
	{
		global $db;

		$stmt = $db->prepare("
		UPDATE menu SET 
			type = :type,
			name = :name,
			parent_id = :parent_id,
			link_type = :link_type,
			parameter = :parameter,
			ordering = :ordering,
			status = :status
		WHERE id = :id
		");

		$stmt->execute(array(
			'type' => $data['type'],
			'name' => $data['name'],
			'parent_id' => $data['parent_id'],
			'link_type' => $data['link_type'],
			'parameter' => $data['parameter'],
			'ordering' => $data['ordering'],
			'status' => $data['status'],
			'id' => $data['id'],
		));
	}


	public function setMenuStatus($data)
	{
		global $db;
		$stmt = $db->prepare("UPDATE menu SET status = :status WHERE id = :id");
		$stmt->execute(array('status' => $data['status'], 'id' => $data['id']));
	}


	public function checkUrl($id, $url)
	{
		global $db;

		$stmt = $db->prepare("SELECT id FROM pages WHERE url = :url AND id != :id LIMIT 1");
		$stmt->execute(array('id' => $id, 'url' => $url));
		if ($stmt->rowCount() > 0)
			return false;
		return true;
	}


	public function deleteMenu($id)
	{
		global $db;

		$stmt = $db->prepare("DELETE FROM menu WHERE id = :id");
		$stmt->execute(array('id' => $id));		
	}
}