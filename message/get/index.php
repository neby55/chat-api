<?php
require '../../inc/config.php';

$error = '';
$userId = isset($_GET['user']) ? intval(trim($_GET['user'])) : 0;
$roomId = isset($_GET['room']) ? intval(trim($_GET['room'])) : 0;
$since = isset($_GET['since']) ? intval(trim($_GET['since'])) : 0;

if ($userId > 0) {
	if ($roomId > 0) {
		$sql = '
			SELECT mes_text AS message, usr_username AS username, mes_inserted AS createdAt
			FROM message
			INNER JOIN user ON user.usr_id = message.usr_id
			WHERE roo_id = :roomId
		';
		if ($since > 0) {
			$sql .= ' AND UNIX_TIMESTAMP(mes_inserted) > :since';
		}
		$stmt = $pdo->prepare($sql);

		//$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
		$stmt->bindValue(':roomId', $roomId, PDO::PARAM_INT);
		if ($since > 0) {
			$stmt->bindValue(':since', $since, PDO::PARAM_INT);
		}

		if ($stmt->execute() === false) {
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
	}
	else {
		$error .= 'Room non fournie' . "\n";
	}
}
else {
	$error .= 'User non renseigné' . "\n";
}

returnJSON(addReturnedArray(0, $error));