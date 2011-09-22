<?php

class UserController extends BaseController {

	function associate($helperID, $carerID, $statusID = 0) {
		// todo check carer/club exists
        $db = getDB();
		$sql = "
			INSERT IGNORE INTO helpers (
				carer_id,
				helper_id,
				requested_by_id,
				status
			) VALUES (
				:carer_id,
				:helper_id,
				:requested_by_id,
				:status
			)" ;
        $s = $db->prepare($sql);
        $s->execute(array(
			'carer_id' => $carerID,
			'helper_id' => $helperID,
			'requested_by_id' => $_SESSION['userID'],
			'status' => $statusID,
		));
	
	}

    function helpers() {
		$links = array();
        $db = getDB();
        $sql = "
			SELECT u.*, h.*, l.username FROM helpers h 
			JOIN users u on u.id = h.helper_id
			JOIN logins l on l.user_id = u.id
			WHERE h.carer_id = :userid
			AND h.status > -1";
        $s = $db->prepare($sql);
        $s->execute(array('userid'=>$_SESSION['userID']));

        if ($s->rowCount() > 0) {
            while($link = $s->fetch(PDO::FETCH_ASSOC)) {
				$link['status'] = $link['status'] ? 'approved' : 'pending';  
				$links[] =  $link;
            }
        }

        return $links;
    }

	function approve($helperID) {
		$this->approveOrIgnore($helperID, 1);
	}

	function ignore($helperID) {
		$this->approveOrIgnore($helperID, -1);
	}

	private function approveOrIgnore($helperID, $status) {
		$links = array();
        $db = getDB();
        $sql = "UPDATE helpers 
			SET status = :status 
			WHERE helper_id = :helperid 
			AND carer_id = :userid ";
        $data = array(
			'status' => $status,
			'helperid'=>$helperID,
        	'userid'=>$_SESSION['userID']);
        $s = $db->prepare($sql);
        $s->execute($data);
	}

	function getUserId($username) {

		$userID = null;
		$db = getDB();
		$sql = "SELECT user_id FROM logins WHERE username = :username";
		$s = $db->prepare($sql);
		$s->execute(array('username'=>$username));
		if($s->rowCount() > 0) {
            $user = $s->fetch(PDO::FETCH_ASSOC);
			$userID  = $user['user_id'];
		}
		return $userID;

	}

}
