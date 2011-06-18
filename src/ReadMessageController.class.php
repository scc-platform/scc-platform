<?php


class ReadMessageController {


	private $carer;

	private $messsageData;

	function setMessageID($id) {
		$db = getDB();
		$s = $db->prepare("SELECT * FROM help_msg WHERE id=:id");
		$s->execute(array('id'=>$id));
		if ($s->rowCount() == 1) {
			$this->messsageData = $s->fetch(PDO::FETCH_ASSOC);
		}
	}

	function setCarerID($carerID) {
		$this->carer = $carerID;
	}

	function isReadAllowed() {
		global $CURRENT_USER;
		return $this->messsageData && $this->messsageData['carer_id'] == $CURRENT_USER['id'];
	}

	function getMsgBody() { return $this->messsageData['body']; }

}

