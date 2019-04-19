<?php
include_once dirname(__FILE__).'/../models/User.php';

use \WebApp\Model\User;

function login() {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if ($user = User::fromLogin($_POST['username'], $_POST['password'])) {
			setcookie('user', serialize($user),  time() + 2592000, '/');
			return $user;
		}
		
		return false;
	}
	else if (isset($_COOKIE['user'])) {
		$hacker = unserialize($_COOKIE['user']);
		$user = validateUser($hacker);
		return $user;
	}
	else {
		return false;
	}
}

function validateUser($hacker) {
	$hackerPassword = $hacker->getAssoc()['password'];
	$user = User::get($hacker->getName());
	//Make sure the user exists
	if (!$user) {
		return NULL;
	}
	
	//Make sure the passwords match
	$userPassword = $user->getAssoc()['password'];
	if ($userPassword === $hackerPassword) {
		return $user;
	}
	else {
		return NULL;
	}
}
?>
