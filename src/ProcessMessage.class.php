<?php


class ProcessMessage {

	/** should be private, public for ease of debugging for now **/
	public $messsageData;
	/** should be private, public for ease of debugging for now **/
	public $users;

	function loadNext() {
		$db = getDB();
		$s = $db->prepare("SELECT * FROM help_msg WHERE sent_at IS NULL ORDER BY created_at ASC");
		$s->execute();
		if ($s->rowCount() == 1) {
			$this->messsageData = $s->fetch(PDO::FETCH_ASSOC);
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
		$this->users = array();
		while($d = $s->fetch(PDO::FETCH_ASSOC)) {
			$this->users[] = $d;
		}
	}

	function filterUsersCanReceiveMessages() {

	}

	function sendToUsers() {

	}


	

}
