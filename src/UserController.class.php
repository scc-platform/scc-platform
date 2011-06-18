<?php

class UserController {

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
			WHERE h.carer_id = :userid";
        $s = $db->prepare($sql);
        $s->execute(array('userid'=>$_SESSION['userID']));

        if ($s->rowCount() > 1) {
            while($link = $s->fetch(PDO::FETCH_ASSOC)) {
				$link['status'] = $link['status'] ? 'approved' : 'pending';  
				$links[] =  $link;
            }
        }

        return $links;
    }

}
