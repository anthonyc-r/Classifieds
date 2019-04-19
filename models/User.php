<?php

namespace WebApp\Model;

include_once "Model.php";

class User extends Model{
	private static $properties = Array('name', 'email', 'password', 'salt', 'tel', 'postcode');
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
		$values = $this->getAssoc();
		$name = $values['name'];
		return static::get($name) !=  NULL;
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
		$telephone = $data['tel'];
		$postcode = $data['postcode'];

		$namelen = strlen($name);
		$pwdlen = strlen($password);
		$postcodelen = strlen($postcode);
		$telephonelen = strlen($telephone);

		if ($namelen > 16 || $namelen < 3)
			$errors .= "Name length is not between 3 and 16.";
		if ($pwdlen != 64)
			$errors .= "Password not hashed correctly.";
		if ($postcodelen != 7)
			$errors .= "Invalid postcode.";
		if ($telephonelen < 1 || !is_numeric($telephone))
			$errors .= "Invalid telephone number";

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
	
	public static function fromLogin($username, $password) {
		if ($potentialUser = static::get($username)) {
			$userinfo = $potentialUser->getAssoc();
			$hashword = hash('sha256', $password.$userinfo['salt']);
			if ($userinfo['password'] === $hashword) {
				return $potentialUser;
			}
		}	
		return NULL;
	}


}

$testsalt = 'testsalt';
$testhash = hash('sha256', 'kek'.$testsalt);
$usr = new User('ayylmaoo', 'ayy@yolo.swag', $testhash, $testsalt, '07000000000', 'mm111rm');
$usr->put();

?>
