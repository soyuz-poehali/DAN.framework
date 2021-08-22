<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/Pages.php';
$PAGES = new Pages;

$data['id'] = $SITE->url_arr[3];
$data['ordering'] = $SITE->url_arr[2] == 'menu_up' ? 'up' : 'down';

$PAGES->setMenuOrdering($data);

header('location: /admin/pages');
exit;

?>