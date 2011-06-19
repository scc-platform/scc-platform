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

	function setHelperGroupID($groupID) {
		$this->helperGroupId = $groupID;
	}

	function send() {
		$db = getDB();
		$s = $db->prepare("
		INSERT INTO help_msg (created_at, carer_id, body, helper_group_id) 
		VALUES (NOW(), :carer_id, :body, :helper_group_id)");
		$s->bindValue('carer_id',$this->carer);
		$s->bindValue('body',$this->msg);
		$s->bindValue('helper_group_id',$this->helperGroupId);
		$s->execute();
		return $db->lastInsertId();
	}

	
}

