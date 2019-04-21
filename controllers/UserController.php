<?php
include_once dirname(__FILE__).'/../models/User.php';

use \WebApp\Model\User;

function didEditUser($me) {
	$values = $me->getAssoc();
	if (isset($_POST['tel']) && $_POST['tel']) {
		$values['tel'] = $_POST['tel'];
	}
	if (isset($_POST['email']) && $_POST['email']) {
		$values['email'] = $_POST['email'];
	} 
	if (isset($_POST['postcode']) && $_POST['postcode']) {
		$values['postcode'] = $_POST['postcode'];
	}
	if ($values !== $me->getAssoc()) {  
		$newMe = new User($values['name'], $values['email'], $values['password'], $values['salt'], $values['tel'], $values['postcode']);
		$newMe->replace();
		return TRUE;
	} else {
		return FALSE;
	}
}

function getUserByNameIfSet() {
	if (isset($_GET['name'])) {
		return User::get($_GET['name']);
	} 
	return NULL;
}

function isUserMe($me, $specificUser) {
	return $me->name === $specificUser->name;
}
?>
