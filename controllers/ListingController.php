<?php
include_once dirname(__FILE__).'/../models/Listing.php';
include_once dirname(__FILE__).'/../models/Filter.php';
use \WebApp\Model\Listing;
use \WebApp\Model\Filter;

function getAppliedFilter() {
	$minPrice = NULL;
	$maxPrice = NULL;
	$maxDistance = NULL;
	$userName = NULL;
	if (isset($_GET['minPrice'])) {
		$minPrice = $_GET['minPrice'];
	}
	if (isset($_GET['maxPrice'])) {
		$maxPrice = $_GET['maxPrice'];
	}
	if (isset($_GET['maxDistance'])) {
		$maxDistance = $_GET['maxDistance'];
	}
	if (isset($_GET['user'])) {
		$userName = $_GET['user'];
	}
   return new Filter($minPrice, $maxPrice, $maxDistance, $userName);
}

function getListings() {
	$filter = getAppliedFilter();
	$search = NULL;
	if (isset($_GET['query'])) {
		$search = $_GET['query'];
	}
	return Listing::getWithFilterSearch($filter, $search);
}

function getListing() {
	if (isset($_GET['id'])) {
		return Listing::get($_GET['id']);
	}
	else {
		return NULL;
	}
}

function newListing($user) {
	global $errors;

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price']) && isset($user)) {
		try {
			$newListing = new Listing($_POST['title'], $_POST['description'], $_POST['price'], time(), $user->name);
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

function isMyListing($me, $listing) {
	return $me->name === $listing->userName;
}

function deleteListing($me, $listing) {
	if (!isMyListing($me, $listing)) {
		return FALSE;
	}
	return $listing->delete();
}

//var_dump($listings);

?>
