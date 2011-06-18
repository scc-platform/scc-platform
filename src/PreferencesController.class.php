<?php

class PreferencesController {

	private $userID;

	private $prefs = array();
	private $prefsID;

	function  __construct($userID) {
		$this->userID = $userID;

		$db = getDB();
		$s = $db->prepare("SELECT * FROM preferences WHERE user_id=:id");
		$s->execute(array('id'=>$userID));

		$this->prefs = $s->fetch(PDO::FETCH_ASSOC);
		$this->prefsID = $this->prefs['id'];


	}

	public function isActive() {  return isset($this->prefs['is_active']) ? $this->prefs['is_active'] : true; }

	public function setIsActive($v) { $this->prefs['is_active'] = (Boolean)$v; }

	public function save() {
		$db = getDB();
		if ($this->prefsID) {
			$s = $db->prepare("UPDATE preferences SET is_active=:is_active WHERE id=:id");
			$s->bindValue('id', $this->prefsID);
		} else {
			$s = $db->prepare("INSERT INTO preferences (user_id,is_active) VALUES (:user_id,:is_active)");
			$s->bindValue('user_id', $this->userID);
		}
		$s->bindValue('is_active', $this->isActive());
		$s->execute();
		if (!$this->prefsID) $this->prefsID = $db->lastInsertId();

	}


}

