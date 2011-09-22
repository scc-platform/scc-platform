<?php

class User {

	private $data = null;

	public function __construct($uid=null) {
	
		$this->data = (object) null;

		if(intval($uid)) {
			$db = getDB();
			$s = $db->prepare("
				SELECT logins.* , users.*
				FROM users 
				JOIN logins ON logins.user_id = users.id 
				WHERE logins.user_id=:uid");

			$s->execute(array('uid'=>$uid));

			if ($s->rowCount() == 1) {
				$this->data = $s->fetch(PDO::FETCH_ASSOC);
			}
		}
	}

	function __get($key) {
		$val = null;
		if(array_key_exists($key, $this->data)) $val = $this->data[$key]; 
		return $val;
	}
}
