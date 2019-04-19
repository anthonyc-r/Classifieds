<?php
namespace WebApp\DB;

use \PDO;

$dropListingSQL = <<<EOL
DROP TABLE main.listing
EOL;
$dropUserSQL = <<<EOL
DROP TABLE main.user
EOL;

$userSQL = <<<EOL
CREATE TABLE main.user (
	name VARCHAR(64) NOT NULL PRIMARY KEY,
	email VARCHAR(64) NOT NULL,
	password CHAR(64) NOT NULL,
	salt CHAR(64) NOT NULL,
	tel VARCHAR(16),
	postcode VARCHAR(8))
EOL;

$listingSQL = <<<EOL
CREATE TABLE main.listing (
	title VARCHAR(32) NOT NULL,
	description VARCHAR(256) NOT NULL,
	price REAL NOT NULL,
	createdAt BIGINT NOT NULL,
	userName VARCHAR(64) NOT NULL,
	FOREIGN KEY(userName) REFERENCES user(name) )
EOL;

$db = new PDO('sqlite:./WebApp.db');
$stmt = $db->prepare($dropUserSQL) or var_dump($db->errorInfo());
$stmt->execute() or var_dump($db->errorInfo());

$stmt = $db->prepare($dropListingSQL) or var_dump($db->errorInfo());
$stmt->execute() or var_dump($db->errorInfo());

$stmt = $db->prepare($userSQL) or var_dump($db->errorInfo());
$stmt->execute() or var_dump($db->errorInfo());

$stmt = $db->prepare($listingSQL) or var_dump($db->errorInfo());
$stmt->execute() or var_dump($db->errorInfo());
?>
