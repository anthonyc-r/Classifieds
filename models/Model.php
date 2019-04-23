<?php

namespace WebApp\Model;

use \ReflectionClass;
use \PDO;
use \Exception;

abstract class Model {
	public static $database; 	//Declared following this class
	private $rowid = false; //!!!!SQLITE SPECIFIC!!!!

	public function __construct() {
		$columns = static::getProperties();
		$values = $this->getValues();
		$this->synthisizeProperties($columns, $values);
		$data = array_combine($columns, $values); //For validation

		if (count($columns) != count($values))
			die("The number of properties and values is not equal.");

		$this->makeSafe($data);
		if (!$this->validate($data, $error))
		 	throw new Exception("Invalid Data: ".$error);
	}
	
	public function getPrimaryValue() {
		return $this->{static::getPrimaryProperty()};
	}
	
	public function replace() {
		$columns =static::getProperties();
		$values = $this->getValues();
		$data = array_combine($columns, $values); //For validation
		
		//Should be valid now
		return $this->validate($data, $error) && 
			   $this->delete() && 
			   $this->put();
	}
	
	public function delete() {
		$table = static::getTableName();
		$primaryProp = static::getPrimaryProperty();
		$primaryValue = $this->getPrimaryValue();
		return static::deleteQuery("DELETE FROM main.{$table} WHERE {$primaryProp} = '{$primaryValue}'");
	}

	//Insert into database
	public function put() {
		$columns =static::getProperties();
		$values = $this->getValues();
		$data = array_combine($columns, $values); //For validation

		//$this->surroundInQuotes($values);
		$columns = implode(', ', $columns); //For query...
		//$values = implode(', ', $values);
		$table = static::getTableName();

		//Should be valid now
		$this->validate($data, $error) or die('Validation Error: '.$error);
		//DBO HANDLES VULNERABILITIES IF CHANGED VULN TO SQL INJECTION!!
		$insertSQL = "INSERT INTO main.{$table} ({$columns}) VALUES (" . implode(', ', array_fill(0, count($values), '?')) . ")";
		if ($statement = self::$database->prepare($insertSQL)) {
			if (!$statement->execute($values)) {
				return FALSE;
			}
			$this->setRowid((int)self::$database->lastInsertId());
			return TRUE;
		}
		else {
			var_dump(self::$database->errorInfo());
			return FALSE;
		}
	}

	public function setRowid($rowid) {
		$this->rowid = $rowid;
	}
	public function getRowid() {
		return $this->rowid;
	}

	//Get from database
	public static function query($query, $bindings) {
		$models = Array();
		if ($statement = Model::$database->prepare($query)) {
			$statement->execute($bindings);
			$rows = $statement->fetchAll(PDO::FETCH_NUM);
			foreach($rows as $row) {
				array_push($models, self::rowToObject($row));
			}
		}
		return $models;
	}
	//Delete form database
	public static function deleteQuery($query, $bindings) {
		if ($statement = Model::$database->prepare($query)) {
			return $statement->execute($bindings);
		}
		else {
			var_dump(Model::$database->errorInfo());
			return FALSE;
		}
	}
	//Generic search
	public static function getLatest($n) {
		$tableName = static::getTableName();
		$query = "SELECT rowid, * FROM main.{$tableName} ORDER BY rowid ASC LIMIT {$n}";
		return self::query($query, NULL);
	}
	
	public static function get($primaryValue) {
		$tableName = static::getTableName();
		$primaryProp = static::getPrimaryProperty();
		$query = "SELECT rowid, * FROM main.{$tableName} WHERE {$primaryProp}='$primaryValue' LIMIT 1";
		//print($query);
		$models = self::query($query, NULL);
		if (count($models) > 0) {
			return $models[0];
		}
		else {
			return NULL;
		}
	}
	
	public static function search($searchString) {
		$tableName = static::getTableName();
		$searchProp = static::getSearchProperty();
		$query = "SELECT rowid, * FROM main.{$tableName} WHERE {$searchProp} LIKE :searchString";
		//print($query);
		return self::query($query, array(':searchString' => "%".$searchString."%"));
	}

	private static function rowsToObjectArray($rows) {
		$objs = Array();

		foreach ($rows as $row) {
			array_push($objs, self::rowToObject($row));
		}
		var_dump($objs);
		return $objs;
	}
	private static function rowToObject($row) {
		$noRowid = array_slice($row, 1);
		$obj = new static(...$noRowid); //pass an array as args
		$obj->setRowid($row[0]);

		return $obj;
	}

	//validate data, should be overridden by child
	abstract static function getTableName();
	abstract static function getProperties();
	abstract static function getSearchProperty();
	abstract static function getPrimaryProperty();
	abstract function validate($data, &$error);
	abstract function makeSafe(&$data);
	abstract function getValues();

	//For each string in an array surround it in quotes
	private function surroundInQuotes(&$array) {
		for ($i = 0; $i < count($array); $i++) {
			$array[$i] = '\'' . $array[$i] . '\'';
		}
	}
	
	private function synthisizeProperties($columns, $values) {
		for ($i = 0; $i < count($columns); $i++) {
			$this->{$columns[$i]} = $values[$i];
		}
	}

}
Model::$database = new PDO('sqlite:'.dirname(__FILE__).'/../DB/WebApp.db');

?>
