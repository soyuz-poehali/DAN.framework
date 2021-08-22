<?php
defined('AUTH') or die('Restricted access');

class Menu
{
	public $menu_arr = false;
	public $breadcrumbs_arr = false;

	public function getMenu($type='top')
	{
		global $db;

		if ($this->menu_arr)
			return $this->menu_arr;

		$stmt = $db->prepare("
			SELECT id, name, parent_id, link_type, parameter
			FROM menu 
			WHERE type = :type AND status = 1
			ORDER BY ordering
		");
		
		$stmt->execute(array('type' => $type));
		$this->menu_arr = $stmt->fetchAll();
		return $this->menu_arr;
	}

	
	public function getPageUrl($id) 
	{
		global $db, $SITE;
		
		$stmt = $db->prepare("SELECT url FROM pages WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$url = $stmt->fetchColumn();

		if ($stmt->rowCount() == 0)
			return '';
			
		return $url;
	}


	public function getBreadcrumbs($current_menu) 
	{
		global $SITE;

		$this->getMenu();  // На тот случай, когда массив меню ещё не сформирован
		$this->recursionBreadcrumbs ($current_menu);
		$this->breadcrumbs_arr = array_reverse($this->breadcrumbs_arr);

		return $this->breadcrumbs_arr;
	}


	private function recursionBreadcrumbs($current_menu) 
	{
		$url = $this->getPageUrl($current_menu['parameter']);
		$current_menu = array_merge($current_menu, array('url' => $url));
		$this->breadcrumbs_arr[] = $current_menu;
		
		if ($current_menu['parent_id'] == 0)
			return;

		// Находим элемент массива меню где 'id' == 'parent_id'
		foreach ($this->menu_arr as $menu_item) {
			if ($menu_item['id'] == $current_menu['parent_id']) {
				$this->recursionBreadcrumbs ($menu_item);
				break;
			}
		}
	}
}