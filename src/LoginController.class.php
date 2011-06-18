<?php

class LoginController {

	function login($username, $password) {
		$db = getDB();
		$s = $db->prepare("SELECT logins.* FROM users JOIN logins ON logins.user_id = users.id ".
				"WHERE logins.username=:username");
		$s->execute(array('username'=>$username));

		if ($s->rowCount() == 1) {
			$user = $s->fetch(PDO::FETCH_ASSOC);
			$crypt =sha1($password.$user['salt']);
			if ($crypt == $user['password']) {
				session_start();
				$_SESSION['userID'] = $user['user_id'];
				return true;
			}
		}

		return false;
	}

	
}