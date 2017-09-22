<?php

namespace WebApp\Model;

include_once "Model.php";

class Listing extends Model {
	private static $properties = Array('title', 'description', 'price');
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

	public function validate($data, &$errors) {
		$errors = "";
		$title = $data['title'];
		$description = $data['description'];
		$price = $data['price'];

		if (strlen($title) > 32 || strlen($title) < 3)
			$errors .= 'Title is not between 3 and 32 characters long. ';
		if (strlen($description) > 256 || strlen($description) < 3)
			$errors .= 'Description is not between 3 and 256 characters long. ';
		if ($price > 1000000.00 || $price < 0.00)
			$errors .= 'Price is not between £0.00 and £1M';

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
	//retrieve socks
	public function getAssoc() {
		return $this->assoc;
	}
	public function getValues() {
		return $this->values;
	}
	public function getTitle() {
		return $this->assoc['title'];
	}
}

//Listing::delete("DELETE FROM main.Listing WHERE 1");
$ayy = new Listing('topkeks', 'top tier topkeks for sale', '1000000.00');
$ayy->put();
$ayy = new Listing('topkek', 'top tier topkeks for sale', '1000000.00');
$ayy->put();
$ayy = new Listing('ayylmaos', 'ayylmaos fresh from mars', '10000.00');
$ayy->put();
//Listing::search('kek');
//print('<br>');
//Listing::search('ayy');
//Listing::getLatest(2);
?>