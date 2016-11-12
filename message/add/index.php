<?php
require '../../inc/config.php';

$error = '';
$userId = isset($_POST['user']) ? intval(trim($_POST['user'])) : 0;
$roomId = isset($_POST['room']) ? intval(trim($_POST['room'])) : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($message != '') {
	if ($userId > 0) {
		if ($roomId > 0) {
			$sql = '
				INSERT INTO message (mes_text, usr_id, roo_id) VALUES (:message, :userId, :roomId)
			';
			$stmt = $pdo->prepare($sql);

			$stmt->bindValue(':message', $message);
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
			$stmt->bindValue(':roomId', $roomId, PDO::PARAM_INT);

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
	}
	else {
		$error .= 'User non renseigné'."\n";
	}
}
else {
	$error .= 'Message vide'."\n";
}

returnJSON(addReturnedArray(0, $error));