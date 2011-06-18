<?php


class SendMessageController {

	
	private $carer;
	private $msg;

	function setMsg($msg) {
		$this->msg = $msg;
	}

	function setCarerID($carerID) {
		$this->carer = $carerID;
	}

	function send() {
		$db = getDB();
		$s = $db->prepare("INSERT INTO help_msg (created_at, carer_id, body) VALUES (NOW(), :carer_id, :body)");
		$s->bindValue('carer_id',$this->carer);
		$s->bindValue('body',$this->msg);
		$s->execute();
		return $db->lastInsertId();
	}

	
}

