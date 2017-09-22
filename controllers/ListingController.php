<?php
include dirname(__FILE__).'/../models/Listing.php';
use \WebApp\Model\Listing;

function getListings() {
	if (isset($_GET['query'])) {
		return Listing::search($_GET['query']);
	}
	else {
		return Listing::getLatest(10);
	}
}

function getListing() {
	if (isset($_GET['id'])) {
		return Listing::get($_GET['id']);
	}
	else {
		return false;
	}
}

function newListing() {
	global $errors;

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price'])) {
		try {
			$newListing = new Listing($_POST['title'], $_POST['description'], $_POST['price']);
			$newListing->put();
			return true;
		}
		catch (Exception $e) {
			$errors .= $e->getMessage();
			return false;
		}
	}
	else {
		return false;
	}
}
//var_dump($listings);

?>