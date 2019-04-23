<?php

namespace WebApp\Model;

include_once "Model.php";
include_once "Constants.php";

class Listing extends Model {
	private static $properties = Array('title', 'description', 'price', 'createdAt', 'userName');
	private static $searchProperty = 'title';
	private static $primaryProperty = 'rowid';
	private static $tableName = 'Listing';
	private $values;
	private $assoc;


	public function __construct($title) {
		$this->values = func_get_args();
		$this->assoc = array_combine(self::$properties, $this->values);
		parent::__construct();
	}

	public function makeSafe(&$data) {
		$data['title'] = htmlentities($data['title'], ENT_QUOTES, 'UTF-8');
		$data['description'] = htmlentities($data['description'], ENT_QUOTES, 'UTF-8');
		$data['price'] = (float) $data['price'];
	}
	
	public function getUser() {
		return User::get($this->userName);
	}
	
	public function validate($data, &$errors) {
		$errors = "";
		$title = $data['title'];
		$description = $data['description'];
		$price = $data['price'];
		$userName = $data['userName'];
		$createdAt = $data['createdAt'];

		if (strlen($title) > 32 || strlen($title) < 3)
			$errors .= 'Title is not between 3 and 32 characters long. ';
		if (strlen($description) > 256 || strlen($description) < 3)
			$errors .= 'Description is not between 3 and 256 characters long. ';
		if ($price > 1000000.00 || $price < 0.00)
			$errors .= 'Price is not between £0.00 and £1M';
		if (strlen($userName) < 3)
			$errors .= 'User not set';
		if ($createdAt < 1)
			$errors .= 'Timestamp not set';
		if ($errors != "")
			return false;
		else
			return true;
	}

	public static function getTableName() {
		return self::$tableName;
	}
	public static function getProperties() {
		return self::$properties;
	}
	public static function getSearchProperty() {
		return self::$searchProperty;
	}
	public static function getPrimaryProperty() {
		return self::$primaryProperty;
	}
	
	public static function getWithFilterSearch($filter, $search) {
		if (!$filter || $filter->isEmpty()) {
			if ($search) {
				return self::search($search);
			} else {
				return self::getLatest(10);
			}
		}
		$queryString = "SELECT rowid,* FROM listing WHERE 1 ";
		$bindings = array();
		if ($filter->getUserName()) {
			$queryString .= "AND userName = :userName ";
			$bindings[":userName"] = $filter->getUserName();
		}
		if ($filter->getMinPrice()) {
			$queryString .= "AND price >= :minPrice ";
			$bindings[":minPrice"] = $filter->getMinPrice();
		}
		if ($filter->getMaxPrice()) {
			$queryString .= "AND price <= :maxPrice ";
			$bindings[":maxPrice"] = $filter->getMaxPrice();
		}
		if ($search) {
			$queryString .= "AND title LIKE :search";
			$bindings[":search"] = "%".$search."%";
		}
		return self::query($queryString, $bindings);
	}
		
	//retrieve socks
	public function getAssoc() {
		return $this->assoc;
	}
	public function getValues() {
		return $this->values;
	}

	// Formatting
	public function getDaysSinceCreated() {
		$diff = time() - $this->createdAt;
		$days = $diff / Constants::SECONDS_IN_DAY;
		return round($days, 0);
	}
	
}
?>
