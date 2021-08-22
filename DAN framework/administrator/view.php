<?php
defined('AUTH') or die('Restricted access');

unset($_SESSION['edit']); 

Header ('Location: /');
exit;
