<?php
require '../../inc/config.php';

$error = '';
$roomName = isset($_POST['room']) ? strip_tags(trim($_POST['room'])) : '';

if (!empty($roomName)) {
	$sql = '
		INSERT INTO room (roo_name) VALUES (:roomName)
	';
	$stmt = $pdo->prepare($sql);

	$stmt->bindValue(':roomName', $roomName);

	if ($stmt->execute() === false) {
		$error .= print_r($stmt->errorInfo(), 1);
	}
	else {
		if ($stmt->rowCount() > 0) {
			returnJSON(addReturnedArray(1));
		}
		else {
			$error .= 'Aucune ligne insérée' . "\n";
		}
	}
}
else {
	$error .= 'Room non fournie'."\n";
}

returnJSON(addReturnedArray(0, $error));