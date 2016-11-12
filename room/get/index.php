<?php
require '../../inc/config.php';

$error = '';

$sql = '
	SELECT roo_id AS id, roo_name AS roomName
	FROM room
';
$stmt = $pdo->query($sql);

if ($stmt === false) {
	$error .= print_r($stmt->errorInfo(), 1);
}
else {
	if ($stmt->rowCount() > 0) {
		returnJSON($stmt->fetchAll(PDO::FETCH_ASSOC));
	}
	else {
		$error .= 'Aucun message' . "\n";
	}
}

returnJSON(addReturnedArray(0, $error));