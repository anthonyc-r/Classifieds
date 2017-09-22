<?php

namespace WebApp\Model;

include_once "Model.php";

class User extends Model{
	private static $properties = Array('name', 'email', 'password', 'tel', 'postcode');
	private static $primaryProperty = 'name';
	private static $searchProperty = 'name';
	private static $tableName = 'User';
	private $values;
	private $assoc;

	public function __construct() {
		$this->values = func_get_args();
		$this->assoc = array_combine(self::$properties, $this->values);
		parent::__construct();
	}

	public function isExistingUser() {
		$tableName = self::$tableName;
		$values = $this->getValues();
		$name = $values['name'];
		$password = $values['passoword'];
		$query = "SELECT * FROM main.{$tableName} WHERE name = '$name' AND passowrd = '$password'";
	}

	public function makeSafe(&$data) {
		foreach ($data as $item) {
			$item = htmlentities($item);
		}
	}

	public function validate($data, &$errors) {
		$errors = "";
		$name = $data['name'];
		$password = $data['password'];

		$namelen = strlen($name);
		$pwdlen = strlen($password);

		if ($namelen > 16 || $namelen < 3)
			$errors .= "Name length is not between 3 and 16.";
		if ($pwdlen != 64)
			$errors .= "Password not hashed correctly.";

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
	public function getValues() {
		return $this->values;
	}
	//retrieve socks
	public function getAssoc() {
		return $this->assoc;
	}
	public function getName() {
		return $this->assoc['name'];
	}

	public static function fromLogin($username, $password) {
		if ($potentialUser = static::get($username)) {
			$userinfo = $potentialUser->getAssoc();
			if ($userinfo['password'] == $password) {
				return $potentialUser;
			}
		}	
		else {
			return false;
		}

	}


}

User::query("DELETE FROM main.user WHERE 1");
$testhash = hash('sha256', 'kek');
$usr = new User('ayylmaoo', 'ayy@yolo.swag', $testhash, '07000000000', 'mm111rm');
$usr->put();

?>