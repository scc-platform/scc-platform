<?php
require '../src/global.php';
checkUserSession();
mustBeLoggedIn();

$c = new HelperGroupController();

if (isset($_POST['action']) && $_POST['action'] == 'add' && 
	isset($_POST['title']) && $_POST['title']) {
	$c->create($_POST['title']);
	header('Location: /helper_groups.php');
	exit();
}
elseif (isset($_POST['action']) && $_POST['action'] == 'delete' && 
	isset($_POST['groupID']) && ctype_digit($_POST['groupID'])) {
	$c->delete($_POST['groupID']);
	header('Location: /helper_groups.php');
	exit();
}
elseif (isset($_POST['action']) && $_POST['action'] == 'addto' && 
	isset($_POST['groupID']) && ctype_digit($_POST['groupID']) &&
	isset($_POST['userID']) && ctype_digit($_POST['userID'])) {
	$c->addToGroup($_POST['groupID'], $_POST['userID']);
	header('Location: /helpers.php');
	exit();
}

$helper_groups = $c->groups();
$helpers_in_groups = $c->helpers_in_groups();

$s = getSmarty();
$s->assign('helper_groups', $helper_groups);
$s->assign('helpers_in_groups', $helpers_in_groups);
$s->display('helper_groups.htm');


