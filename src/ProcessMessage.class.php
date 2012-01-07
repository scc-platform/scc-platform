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
					"WHERE helper_in_group.helper_group_id=:gid");
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
		$db = getDB();
		$s = $db->prepare("INSERT INTO help_msg_to_user (help_msg_id,user_id,sent_email,sent_txt,sent_twitter) ".
				"VALUES (:help_msg_id,:user_id,:sent_email,:sent_txt,:sent_twitter)");
		$s->bindValue('help_msg_id', $this->messsageData['id']);
		foreach($this->actualToUsers as $user) {
			$s->bindValue('user_id', $user['id']);

			$c = new PreferencesController($user['id']);

			if ($c->useEmail()) {
				$this->email($user);
				$s->bindValue('sent_email', true);
			} else {
				$s->bindValue('sent_email', false);
			}

			if ($c->useTxt()) {
				$this->txt($user);
				$s->bindValue('sent_txt', true);
			} else {
				$s->bindValue('sent_txt', false);
			}

			$s->bindValue('sent_twitter', false);


			$s->execute();
		}

		$s = $db->prepare("UPDATE help_msg SET sent_at=NOW() WHERE id=:id ");
		$s->execute(array('id'=>$this->messsageData['id']));
	}

	private function email($userData) {

		$s = getEmailSmarty();
		$s->assign('toUser',$userData);
		$s->assign('fromUser',$this->fromUser);
		$s->assign('message',$this->messsageData);
		$body = $s->fetch('sendMessageByEmail.txt');

		mail($userData['email'], 'Could you help '.$this->fromUser['email'], $body, 'From: '.EMAILS_FROM);
		print $body;

	}

	private function txt($userData) {
		if(!isset($userData['phone']) || strlen(trim($userData['phone'])) < 1) return; 
		
		$data = array(
			"user" => CLICKATELL_USER,
			"password" => CLICKATELL_PASS,
			"api_id" => CLICKATELL_API,
			"to" => $userData['phone'], 
			"text" => substr($this->fromUser['email'] . ': ' . $this->messsageData['body'],0,160),
		);
		//https://api.clickatell.com/http/sendmsg?user=USER&password=PASS&api_id=APPID&to=PHONE&text=Meet+me+at+home
		$url = "https://api.clickatell.com/http/sendmsg?".http_build_query($data);

		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		@curl_setopt($ch , CURLOPT_SSL_VERIFYPEER, 0 );
		@curl_setopt($ch , CURLOPT_SSL_VERIFYHOST, 0 );

		// grab URL and pass it to the browser
		curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);

	}

	

}
