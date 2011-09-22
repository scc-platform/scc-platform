<?php

class SignUpController extends BaseController {

	function signUp($email, $username, $password) {

		$db = getDB();

		$s1 = $db->prepare("INSERT INTO users (email) VALUES (:email)");
		$s1->execute(array('email'=>$email));

		$id = $db->lastInsertId();

		$salt = 'oe48uet48uth'; // TODO this should be random.
		$crypt =sha1($password.$salt);

		$s2 = $db->prepare("INSERT INTO logins (user_id,username,password,salt) VALUES (:user_id,:username,:password,:salt)");
		$s2->execute(array(
				'user_id'=>$id,
				'username'=>$username,
				'password'=>$crypt,
				'salt'=>$salt
			));

		return $id;

	}

	function userExists($username) {

		$db = getDB();

		$s = $db->prepare("
			SELECT logins.* 
			FROM users 
			JOIN logins ON logins.user_id = users.id 
		   	WHERE logins.username=:username");

		$s->execute(array('username'=>$username));

		return $s->rowCount() > 0;
	}
}
