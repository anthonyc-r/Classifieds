<?php
include_once dirname(__FILE__).'/../models/User.php';

use \WebApp\Model\User;

function login() {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$password = hash('sha256', $_POST['password']);
		if ($user = User::fromLogin($_POST['username'], $password)) {
			setcookie('user', serialize($user));
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

function logout() {
	setcookie('user', '', 1);
	return true;
}

function validateUser($hacker) {
	$hackerPassword = $hacker->getAssoc()['password'];

	$user = User::get($hacker->getName());
	//Make sure the user exists
	if (!$user)
		return false;

	//Make sure the passwords match
	$userPassword = $user->getAssoc()['password'];
	if ($userAssoc['password'] == $hackerAssoc['password'])
		return $user;
	else
		return false;

}
?>
