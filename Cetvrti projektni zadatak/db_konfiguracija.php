<?php

DEFINE('DB_USER', 'rsmajic');
DEFINE('DB_PASSWORD', 'ragib');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'etftrans');

$db_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db_conn->set_charset("utf8");

if ($db_conn->connect_error) {
	die("Konekcija na bazu nije uspjela: " . $db_conn->connect_error);
} 

?>