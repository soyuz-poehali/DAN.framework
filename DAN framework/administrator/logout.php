<?php
defined('AUTH') or die('Restricted access');

session_destroy();

Header ('Location: /admin');
exit;
