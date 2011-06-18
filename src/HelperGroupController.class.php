<?php

class HelperGroupController {

    function groups() {
		$groups = array();
        $db = getDB();
        $sql = " SELECT hg.* FROM helper_groups hg WHERE hg.user_id = :userid ";
        $s = $db->prepare($sql);
        $s->execute(array('userid'=>$_SESSION['userID']));

        if ($s->rowCount() > 0) {
            while($g = $s->fetch(PDO::FETCH_ASSOC)) {
				$groups[] =  $g;
            }
        }

        return $groups;
    }

	function create($title) {
        $db = getDB();
        $sql = " INSERT IGNORE into helper_groups (user_id, title) VALUES (:userid, :title)";
        $s = $db->prepare($sql);
        $s->execute(array('title'=>$title, 'userid'=>$_SESSION['userID']));
	}

	// todo add unique index to title
	function delete($groupID) {
        $db = getDB();
        $sql = " DELETE FROM helper_groups WHERE id = :groupid AND user_id = :userid ";
        $s = $db->prepare($sql);
        $s->execute(array('groupid' => $groupID, 'userid'=>$_SESSION['userID']));
	}

	function addToGroup($groupID, $helperID) {
        $db = getDB();
        $sql = " INSERT IGNORE into helper_in_group (helper_group_id, helper_id) VALUES (:groupid, :helperid)";
        $s = $db->prepare($sql);
        $s->execute(array('groupid'=>$groupID, 'helperid'=>$helperID));
	}

    function helpers_in_groups() {
		$helpers= array();
        $db = getDB();
        $sql = "
		 	SELECT l.username, hig.helper_id, hig.helper_group_id, hg.title as helper_group_title
			FROM helper_in_group hig
			JOIN helper_groups hg ON hg.id = hig.helper_group_id
			JOIN helpers h ON h.helper_id = hig.helper_id AND h.carer_id = :userid  
			JOIN users u on u.id = h.helper_id 
			JOIN logins l on l.user_id = u.id
			";
        $s = $db->prepare($sql);
        $s->execute(array('userid'=>$_SESSION['userID']));

        if ($s->rowCount() > 0) {
            while($g = $s->fetch(PDO::FETCH_ASSOC)) {
				$helpers[$g['helper_group_id']][] =  $g;
            }
        }

        return $helpers;
    }


}
