<?php
header('Access-Control-Allow-Origin: *');

require dirname(__FILE__).'/settings.php';

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
	if(array_key_exists('callback', $_GET)){
		header('Content-Type: text/javascript; charset=utf8');
		header('Access-Control-Max-Age: 3628800');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		$callback = $_GET['callback'];
		echo $callback.'('.json_encode($data).');';
	}
	else {
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($data);
	}
	exit;
}
function addReturnedArray($code, $error='') {
	return array(
		'code' => $code,
		'error' => trim($error)
	);
}