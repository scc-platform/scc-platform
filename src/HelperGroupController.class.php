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


}
