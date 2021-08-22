<?php
defined('AUTH') or die('Restricted access');

// Старт frontend edit сессии
$_SESSION['edit'] = $_SESSION['admin'];

Header ('Location: /');
exit;

?>