<?php
include_once dirname(__FILE__).'/../models/User.php';

use \WebApp\Model\User;

function logout() {
	setcookie('user', 'content', 1, '/');
	$_COOKIE['user'] = NULL;
	return true;
}

?>
