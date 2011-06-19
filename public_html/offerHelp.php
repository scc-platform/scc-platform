<?php
require '../src/global.php';
checkUserSession();


$c = new UserController();

$s = getSmarty();
$s->assign('associated', false);

// 'user' is the carer they want to 'help'
if (isset($_POST['userID']) && intval($_POST['userID']) > 0) {
	$c->associate($_SESSION['userID'], $_POST['userID']);
	$s->assign('associated', true);
}

$s->display('offerHelp.htm');


