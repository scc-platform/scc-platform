<?php

class HelpTypeController {

	private $userID;

	private $helpTypes = array();

	public function  __construct($userID) {
		$this->userID = $userID;

		$db = getDB();
		$s = $db->prepare("SELECT * FROM help_type WHERE carer_id=:id");
		$s->execute(array('id'=>$userID));
		while($d = $s->fetch(PDO::FETCH_ASSOC)) {
			$this->helpTypes[] = $d;
		}
	}

	public function getHelpTypes() {
		return $this->helpTypes;
	}

	public function add($title) {
		$db = getDB();
		$s = $db->prepare("INSERT INTO help_type (carer_id,title) VALUES (:id,:title)");
		$s->execute(array('id'=>$this->userID, 'title'=>$title));
		$this->helpTypes[] = array('title'=>$title);
	}
	
}

