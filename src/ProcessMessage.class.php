<?php


class ProcessMessage {

	/** should be private, public for ease of debugging for now **/
	public $messsageData;
	/** should be private, public for ease of debugging for now **/
	public $desiredToUsers;
	/** should be private, public for ease of debugging for now **/
	public $actualToUsers;

	private $fromUser;

	function loadNext() {
		$db = getDB();
		$s = $db->prepare("SELECT * FROM help_msg WHERE sent_at IS NULL ORDER BY created_at ASC");
		$s->execute();
		if ($s->rowCount() > 0) {
			$this->messsageData = $s->fetch(PDO::FETCH_ASSOC);

			$s = $db->query("SELECT * FROM users WHERE id=".$this->messsageData['carer_id']);
			$this->fromUser = $s->fetch(PDO::FETCH_ASSOC);

			return true;
		}
		return false;
	}

	function loadUsersSenderRequested() {
		$db = getDB();
		if ($this->messsageData['helper_group_id']) {
			$s = $db->prepare("SELECT users.* FROM users JOIN helper_in_group ON helper_in_group.helper_id = users.id ".
					"WHERE helper_in_group=:gid");
			$s->bindValue('gid', $this->messsageData['helper_group_id']);
		} else {
			$s = $db->prepare("SELECT users.* FROM users JOIN helpers ON helpers.helper_id = users.id ".
					"WHERE helpers.carer_id=:uid AND helpers.status > 0");
			$s->bindValue('uid', $this->messsageData['carer_id']);
		}
		$s->execute();
		$this->desiredToUsers = array();
		while($d = $s->fetch(PDO::FETCH_ASSOC)) {
			$this->desiredToUsers[] = $d;
		}
	}

	function filterUsersCanReceiveMessages() {
		$this->actualToUsers = array();
		foreach($this->desiredToUsers as $user) {

			// get Prefs for this user.
			$c = new PreferencesController($user['id']);

			if ($c->isActive()) {
				$this->actualToUsers[] = $user;
			}

		}
	}

	function sendToUsers() {
		foreach($this->actualToUsers as $user) {


			$this->email($user);


		}
	}

	private function email($userData) {

		$s = getEmailSmarty();
		$s->assign('toUser',$userData);
		$s->assign('fromUser',$this->fromUser);
		$s->assign('message',$this->messsageData);
		$body = $s->fetch('sendMessageByEmail.txt');

		print $body;

	}

	public function markSent() {
		
	}

	

}
