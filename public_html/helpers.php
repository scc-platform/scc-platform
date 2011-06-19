<?php
require '../src/global.php';
mustBeLoggedIn();

$c = new UserController();
$h = new HelperGroupController();
$s = getSmarty();

if (isset($_POST['action']) && $_POST['action'] == 'approve' && 
	isset($_POST['userID']) && ctype_digit($_POST['userID'])) {
	$c->approve($_POST['userID']);
	header("Location: /helpers.php");
	die();
}
elseif (isset($_POST['action']) && $_POST['action'] == 'ignore' && 
	isset($_POST['userID']) && ctype_digit($_POST['userID'])) {
	$c->ignore($_POST['userID']);
	header("Location: /helpers.php");
	die();
}

$helpers = $c->helpers();
$helper_groups = $h->groups();

$s->assign('helpers', $helpers);
$s->assign('helper_groups', $helper_groups);
$s->display('helpers.htm');


