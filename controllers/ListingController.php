<?php
include_once dirname(__FILE__).'/../models/Listing.php';
include_once dirname(__FILE__).'/../models/Filter.php';
use \WebApp\Model\Listing;
use \WebApp\Model\Filter;

define("ITEMS_PER_PAGE", 10);
define("NUM_PAGES", 7);

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

function getSearchValue() {
	$search = NULL;
	if (isset($_GET['query'])) {
		$search = $_GET['query'];
	}
	return $search;
}

function getCurrentPage() {
	$page = 0;
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	return $page;
}

function getPagingLayout() {
	$current = getCurrentPage();
	$maxPages = getPageCount();
	$lowerBound = max(0, $current - (int)(NUM_PAGES / 2));
	$upperBound = min($maxPages, $current + (int)(NUM_PAGES / 2));
	return array("lowerBound" 			=> $lowerBound,
				 "upperBound" 			=> $upperBound,
				 "showFirstPageLink" 	=> $lowerBound > 1,
				 "showLastPageLink"		=> $upperBound != $maxPages,
				 "maxPages"				=> $maxPages);
}

function getUrlForPage($page) {
	$currentParams = $_GET;
	$currentParams['page'] = $page;

	$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$query = "?".http_build_query($currentParams);
	return $uri.$query;
}

function getListings() {
	$filter = getAppliedFilter();
	$search = getSearchValue();
	$page = getCurrentPage();
	return Listing::getWithFilterSearch($filter, $search, $page, ITEMS_PER_PAGE);
}

function getListing() {
	if (isset($_GET['id'])) {
		return Listing::get($_GET['id']);
	}
	else {
		return NULL;
	}
}

function getPageCount() {
	$filter = getAppliedFilter();
	$search = getSearchValue();
	$count = Listing::getCountWithFilterSearch($filter, $search);
	return (int)($count / ITEMS_PER_PAGE);
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
