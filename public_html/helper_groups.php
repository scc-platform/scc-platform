<?php
require '../src/global.php';
mustBeLoggedIn();

$h = new HelperGroupController();
$u = new UserController();

if (isset($_POST['action']) && $_POST['action'] == 'add' && 
	isset($_POST['title']) && $_POST['title']) {
	$h->create($_POST['title']);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'delete' && 
	isset($_POST['groupID']) && ctype_digit($_POST['groupID'])) {
	$h->delete($_POST['groupID']);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'addto' && 
	isset($_POST['groupID']) && ctype_digit($_POST['groupID']) &&
	isset($_POST['userID']) && ctype_digit($_POST['userID'])) {
	$h->addToGroup($_POST['groupID'], $_POST['userID']);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'remove' && 
	isset($_POST['groupID']) && ctype_digit($_POST['groupID']) &&
	isset($_POST['userID']) && ctype_digit($_POST['userID'])) {
	$h->removeFromGroup($_POST['groupID'], $_POST['userID']);
}

if(count($_POST)) { // get after post
	header('Location: /helper_groups.php');
	exit();
}

$helper_groups = $h->groups();
$helpers_in_groups = $h->helpers_in_groups();
$helpers = $u->helpers();

$s = getSmarty();
$s->assign('helper_groups', $helper_groups);
$s->assign('helpers_in_groups', $helpers_in_groups);
$s->assign('helpers', $helpers);
$s->display('helper_groups.htm');


