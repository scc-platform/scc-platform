<?php
require '../src/global.php';
checkUserSession();
mustBeLoggedIn();

$c = new UserController();

// 'user' is the carer they want to 'help'
if (isset($_GET['action']) && $_GET['action'] == 'help' && 
	isset($_GET['userID']) && ctype_digit($_GET['userID'])) {
	$c->associate($_SESSION['userID'], $_GET['userID']);
}
else {
	$helpers = $c->helpers();
}

$s = getSmarty();
$s->assign('helpers', $helpers);
$s->display('links.htm');


