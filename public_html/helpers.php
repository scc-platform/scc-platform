<?php
require '../src/global.php';
checkUserSession();
mustBeLoggedIn();

$c = new UserController();
$s = getSmarty();

// 'user' is the carer they want to 'help'
if (isset($_GET['action']) && $_GET['action'] == 'help' && 
	isset($_GET['userID']) && ctype_digit($_GET['userID'])) {
	$c->associate($_SESSION['userID'], $_GET['userID']);
	$s->assign('associated', true);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'approve' && 
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

$s->assign('helpers', $helpers);
$s->display('helpers.htm');


