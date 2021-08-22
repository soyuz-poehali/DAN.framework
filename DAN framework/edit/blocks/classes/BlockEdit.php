<?php
defined('AUTH') or die('Restricted access');
// Поле 'status': 0 - скрыть, 1 - показать, 2 - только десктоп, 3 - только на мобильных устройствах 

class BlockEdit
{
	private $no_serialise_block = ['code']; // Блоки, для которых не требуется сериализация

	// Возвращает количество блоков, расположенных на странице
	public function getPageBlocks($page_id)
	{
		global $db;
		$stmt = $db->prepare("SELECT * FROM blocks WHERE page_id = :page_id ORDER BY ordering");
		$stmt->execute(array('page_id' => $page_id));
		return $stmt->fetchAll();
	}

	// Возвращает количество блоков, расположенных на странице
	public function getCountPageBlock($page_id, $block_type)
	{
		global $db;
		$stmt = $db->prepare("SELECT id FROM blocks WHERE page_id = :page_id AND type = :type");
		$stmt->execute(array('page_id' => $page_id, 'type' => $block_type));
		return $stmt->rowCount();
	}

	public function getBlock($id)
	{
		global $db;
		$stmt = $db->prepare("SELECT * FROM blocks WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$b = $stmt->fetch();

		if (!in_array($b['type'], $this->no_serialise_block))
			$b['content'] = unserialize($b['content']);

		return $b;
	}
	
	public function getBlockCount($data)
	{
		global $db;
		$stmt = $db->prepare("SELECT * FROM blocks WHERE page_id = :page_id AND type = :type");
		$stmt->execute(array('page_id' => $data['page_id'], 'type' => $data['type']));
		return $stmt->rowCount();		
	}
	
	public function getMenuCount($data)
	{
		global $db;
		$stmt = $db->query("SELECT id FROM blocks WHERE type = 'menu'");
		return $stmt->rowCount();		
	}

	public function deleteBlock($data)
	{
		global $db;

		$data = $this->getBlock($data['id']);

		if (isset($content['bg_type']) && $content['bg_type'] == 'i') {
			$file_old = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/'.$data['type'].'/background/'.$data['content']['bg_image'];
			if (is_file($file_old)) 
				unlink($file_old);			
		}

		$stmt = $db->prepare("DELETE FROM blocks WHERE id = :id");
		$stmt->execute(array('id' => $data['id']));
	}

	public function getMaxOrdering($page_id)
	{
		global $db;
		$stmt = $db->prepare("SELECT MAX(ordering) max_ordering FROM blocks WHERE page_id = :page_id");
		$stmt->execute(array('page_id' => $page_id));
		return $stmt->fetchColumn();
	}

	public function insertBlock($data)
	{
		global $db;

		if (!in_array($data['type'], $this->no_serialise_block))
			$data['content'] = serialize($data['content']);

		$stmt = $db->prepare("INSERT INTO blocks SET page_id = :page_id, type = :type, content = :content, ordering = :ordering, status = :status");
		$stmt->execute(array('page_id' => $data['page_id'], 'type' => $data['type'], 'content' => $data['content'], 'ordering' => $data['ordering'], 'status' => $data['status']));

		$last_id = $db->lastInsertId();
		return $last_id;
	}

	/*
	public function updateBlock($data)
	{
		global $db;
		$data['content'] = serialize($data['content']);
		$stmt = $db->prepare("UPDATE blocks SET content = :content WHERE id = :id");
		$stmt->execute(array('content' => $data['content'], 'id' => $data['id']));
	}
	*/

	public function updateBlockContent($id, $content)
	{
		global $db;

		$data = $this->getBlock($id);

		if (!in_array($data['type'], $this->no_serialise_block))
			$content = serialize($content);

		$stmt = $db->prepare("UPDATE blocks SET content = :content WHERE id = :id");
		$stmt->execute(array('content' => $content, 'id' => $id));
	}

	// Массив - ключ ordering, значение - id
	public function updateOrdering($data)
	{
		global $db;

		foreach ($data as $ordering => $id) {
			$stmt = $db->prepare("UPDATE blocks SET ordering = :ordering WHERE id = :id");
			$stmt->execute(array('ordering' => ($ordering + 1), 'id' => $id));					
		}
	}

	public function upDown($data) {
		global $db;

		$blocks = $this->getPageBlocks($data['page_id']);

		$i = 0;
		$ordering = 0;
		foreach ($blocks as $block) {
			if ($block['page_id'] == 0 )
				continue;
			if ($data['id'] == $block['id']) {
				$ordering = $i;
			}
			$i++;
		}

		$arr = [];
		if ($data['act'] == 'up') {
			if ($ordering == 1)
				return;
			$prev_id = $blocks[$ordering-1]['id'];
			$current_id = $blocks[$ordering]['id'];
			$arr[$ordering - 1] = $current_id;
			$arr[$ordering] = $prev_id;
		} else {
			if ($ordering >= count($blocks) - 1)
				return;
			$next_id = $blocks[$ordering+1]['id'];
			$current_id = $blocks[$ordering]['id'];
			$arr[$ordering + 1] = $current_id;
			$arr[$ordering] = $next_id;
		}

		foreach ($arr as $ordering => $id) {
			$stmt = $db->prepare("UPDATE blocks SET ordering = :ordering WHERE id = :id");
			$stmt->execute(array('ordering' => ($ordering + 1), 'id' => $id));			
		}
	}
}