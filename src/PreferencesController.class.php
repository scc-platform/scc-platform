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

		$x = $s->fetch(PDO::FETCH_ASSOC);
		if ($x) {
			$this->prefs = $x;
			$this->prefsID = $this->prefs['id'];
		}

		$s = $db->prepare("SELECT * FROM users WHERE id=:id");
		$s->execute(array('id'=>$userID));

		$this->prefs = array_merge($this->prefs, $s->fetch(PDO::FETCH_ASSOC));


	}

	public function isActive() {  return isset($this->prefs['is_active']) ? $this->prefs['is_active'] : true; }
	public function useEmail() {  return isset($this->prefs['use_email']) ? $this->prefs['use_email'] : true; }
	public function useTxt() {  return isset($this->prefs['use_txt']) ? $this->prefs['use_txt'] : true; }
	public function useTwitter() {  return isset($this->prefs['use_twitter']) ? $this->prefs['use_twitter'] : true; }
	public function getPhone() {  return isset($this->prefs['phone']) ? $this->prefs['phone'] : ''; }

	public function setIsActive($v) { $this->prefs['is_active'] = (Boolean)$v; }
	public function setUseEmail($v) { $this->prefs['use_email'] = (Boolean)$v; }
	public function setUseTxt($v) { $this->prefs['use_txt'] = (Boolean)$v; }
	public function setUseTwitter($v) { $this->prefs['use_twitter'] = (Boolean)$v; }
	public function setPhone($p) { $this->prefs['phone'] = $p; }

	public function save() {
		$db = getDB();
		if ($this->prefsID) {
			$s = $db->prepare("UPDATE preferences SET is_active=:is_active, use_email=:use_email, use_txt=:use_txt, ".
					"use_twitter=:use_twitter WHERE id=:id");
			$s->bindValue('id', $this->prefsID);
		} else {
			$s = $db->prepare("INSERT INTO preferences (user_id,is_active,use_email,use_txt,use_twitter) VALUES ".
					"(:user_id,:is_active,:use_email,:use_txt,:use_twitter)");
			$s->bindValue('user_id', $this->userID);
		}
		$s->bindValue('is_active', $this->isActive());
		$s->bindValue('use_email', $this->useEmail());
		$s->bindValue('use_txt', $this->useTxt());
		$s->bindValue('use_twitter', $this->useTwitter());
		$s->execute();
		if (!$this->prefsID) $this->prefsID = $db->lastInsertId();

		$s = $db->prepare("UPDATE users SET phone=:phone WHERE id=:id");
		$s->execute(array('id'=>$this->userID, 'phone'=>$this->prefs['phone']));

	}


}

