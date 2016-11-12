<?php
require './settings.php';

// définition DSN
$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';charset=UTF8';

// Instanciation de PDO
try {
	$pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
}
catch (Exception $e) {
	echo $e->getMessage();
}

function returnJSON($data) {
	echo json_encode($data);
	exit;
}
function addReturnedArray($code, $error='') {
	return array(
		'code' => $code,
		'error' => $error
	);
}