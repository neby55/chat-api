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
					SELECT usr_id
					FROM user
					WHERE username = :username
					LIMIT 1
				';
				$stmt = $pdo->prepare($sql);

				$stmt->bindValue(':username', $username);

				if ($stmt->execute() === false) {
					$error .= print_r($stmt->errorInfo(), 1);
				}
				else {
					if ($stmt->rowCount() > 0) {
						$userInfos = $stmt->fetch(PDO::FETCH_ASSOC);

						if (password_verify($password, $userInfos['usr_password'])) {
							returnJSON(array(
								'id' => $userInfos['usr_id'],
								'username' => $userInfos['usr_username']
							));
						}
						else {
							$error .= 'Password erroné'."\n";
						}
					}
					else {
						$error .= 'User inexistant' . "\n";
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