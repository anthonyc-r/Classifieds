<?php
include_once dirname(__FILE__).'/../models/User.php';

use \WebApp\Model\User;

function register() {
	$requiredFields = array('username', 'email', 'password', 'telephone', 'postcode');
	$hasRequiredInfo = TRUE;
	foreach($requiredFields as $requiredField) {
		$hasRequiredInfo &= isset($_POST[$requiredField]);
	}
	if($hasRequiredInfo) {
		$salt = uniqid();
		$hashword = hash('sha256', $_POST['password'].$salt);
		$user = new User($_POST['username'], $_POST['email'], $hashword, $salt, $_POST['telephone'], $_POST['postcode']);
		if(!$user->isExistingUser()) {
			$user->put();
			setcookie('user', serialize($user), 2592000, '/');
		} else {
			return "Username is taken.";
		}
	}
	return NULL;
}

?>
