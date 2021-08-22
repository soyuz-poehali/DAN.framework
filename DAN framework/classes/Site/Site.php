<?php
defined('AUTH') or die('Restricted access');

class Site
{
	public $domain = '';
	public $email = '';
	public $url = '';
	public $url_arr = [];
	public $page = false;
	public $content = '';
	public $settings = '';
	public $headStyle = '';
	public $headJs = '';
	private $headFileArray = [];
	private $headCodeArray = [];
	private $cpanel = '';

	public function __construct()
	{
		$qs = mb_strtolower($_SERVER['REQUEST_URI']);
		$qs_arr = explode('?', $qs); // Отделяем адрес от GET переменных
		$qs_arr[0] = preg_replace("/^(\/)|(\/$)/", "", $qs_arr[0]); // Убираем в начале и в конце наклонную черту
		$this->url = $qs_arr[0];
		$z = explode('/', $qs_arr[0]);
		$this->url_arr = array_pad($z, 9, '');
		$this->settings = $this->getSettings();
		$this->email = $this->settings['email'];
	}

	public function getHead(){
		$out = '';
		foreach($this->headFileArray as $file){
			$strArr = explode('.', $file);
			$last = count($strArr)-1;
			$type = $strArr[$last];

			if($type == 'css')
				$out .= '<link href="'.$file.'" type="text/css" media="all" rel="stylesheet"/>';
			else if($type == 'js')
				$out .= '<script src="'.$file.'"></script>';
		}
		$out .= implode('', $this->headCodeArray);
		$out .= $this->settings['code_head'];
		echo $out;
	}


	public function getFooter(){
		echo $this->settings['code_footer'];
	}


	public function getCpanel() {
		if (isset($_SESSION['edit']))
			echo $this->cpanel;
	}

	public function setCpanel($html) {
		if (isset($_SESSION['edit']))
			$this->cpanel = $html;
	}

	public function getContent() {
		echo $this->content;
	}

	public function setHeadCode($code){
		foreach($this->headCodeArray as $c){
			if($c == $code) 
				return false;
		}
		array_push($this->headCodeArray, $code);
	}

	public function setHeadFile($path){
		foreach($this->headFileArray as $file){
			if($file == $path) 
				return false;
		}
		array_push($this->headFileArray, $path);
	}

	public function getPage() {
		global $db;
		// Ищем обычные страницы
		$stmt = $db->prepare("SELECT id, type, data FROM pages WHERE url = :url AND status = 1 LIMIT 1");
		$stmt->execute(array('url' => $this->url));

		if ($stmt->rowCount() > 0) {
			$page = $stmt->fetch();
			$page['data'] = unserialize($page['data']);
			$this->page = $page;
			return $page;
		}

		// Обычную страницу не нашли, ищем типа "catalog"
		$stmt_cat = $db->prepare("SELECT id, type, data FROM pages WHERE url = :url AND type = 'catalog' AND status = 1 LIMIT 1");
		$stmt_cat->execute(array('url' => $this->url_arr[0]));

		if ($stmt_cat->rowCount() > 0) {
			$page = $stmt_cat->fetch();
			$page['data'] = unserialize($page['data']);
			$this->page = $page;
			return $page;
		}
		return false;
	}


	public function getPageBlocks($page_id, $status='all') {
		global $db;
		$sql_status = $status=='all' ? '' : 'AND status = '.intval($status);
		$stmt = $db->prepare("SELECT * FROM blocks WHERE page_id = :page_id OR page_id = '0' $sql_status ORDER BY ordering");
		$stmt->execute(array('page_id' => $page_id));
		return $stmt->fetchAll();
	}


	public function getProtocol(){
		if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
			(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') || 
			(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) 
			return 'https';
		return 'http';
	}

	public function getIp(){
		if(!$this->ip){
			if(isset($_SERVER['HTTP_CLIENT_IP']))
				$this->ip = $_SERVER['HTTP_CLIENT_IP'];
			elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else
				$this->ip = $_SERVER['REMOTE_ADDR'];
		}
		return $this->ip;
	}

	public function getSettings()
	{
		global $db;

		$stmt = $db->query("SELECT id, settings, status FROM settings WHERE id = 1");
		$data = $stmt->fetch();
		$settings = unserialize($data['settings']);
		$settings['status'] = $data['status'];

		return $settings;
	}

	public function getPersonalInformation() 
	{
		global $db;

		$stmt = $db->query("SELECT settings FROM settings WHERE id = 2");
		return $stmt->fetchColumn();
	}

	public function getEmail()
	{
		global $db;

		// В разработке
		return 'info@list.ru';
	}
	
	
	public function errLog($err)
	{
		echo $err;
	}
}