<?php
require '../../inc/config.php';

$error = '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (!empty($username)) {
	if (!empty($password)) {
		if (strlen($username) < 4) {
			if (strlen($password) < 8) {
				$sql = '
					INSERT INTO user (usr_username, usr_password) VALUES (:username, :password)
				';
				$stmt = $pdo->prepare($sql);

				$stmt->bindValue(':username', $username);
				$stmt->bindValue(':password', $password);

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
				$error .= 'Password doit contenir au moins 8 caractères'."\n";
			}
		}
		else {
			$error .= 'Username doit contenir au moins 4 lettres'."\n";
		}
	}
	else {
		$error .= 'Password vide'."\n";
	}
}
else {
	$error .= 'Username vide'."\n";
}

returnJSON(addReturnedArray(0, $error));