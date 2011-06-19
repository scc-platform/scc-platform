<?php


class SendMessageController {

	
	private $carer;
	private $msg;
	private $helpTypes = array();

	function setMsg($msg) {
		$this->msg = $msg;
	}

	function setCarerID($carerID) {
		$this->carer = $carerID;
	}

	function setHelperGroupID($groupID) {
		$this->helperGroupId = $groupID;
	}

	/** @todo Need to check this help type ID actually belongs to this user! **/
	function addHelpType($id) {
		$this->helpTypes[] = $id;
	}

	function send() {
		$db = getDB();

		$s = $db->prepare("INSERT INTO help_msg (created_at, carer_id, body, helper_group_id) ".
			"VALUES (NOW(), :carer_id, :body, :helper_group_id)");
		$s->bindValue('carer_id',$this->carer);
		$s->bindValue('body',$this->msg);
		$s->bindValue('helper_group_id',$this->helperGroupId);
		$s->execute();
		$id = $db->lastInsertId();

		$s = $db->prepare("INSERT INTO help_msg_type (help_msg_id,help_type_id) VALUES (:help_msg_id,:help_type_id)");
		$s->bindValue('help_msg_id', $id);
		foreach($this->helpTypes as $htID) {
			$s->bindValue('help_type_id', $htID);
			$s->execute();
		}

		return $id;
	}

	
}

