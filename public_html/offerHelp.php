<?php
require '../src/global.php';
checkUserSession();


$c = new UserController();

$s = getSmarty();
$s->assign('associated', false);

// 'user' is the carer they want to 'help'
$userID = null;
if(isset($_POST['userID']) && intval($_POST['userID']) > 0) {
		$userID = filter_var($_POST['userID']);
}
elseif(isset($_POST['userID'])) {
		$username = filter_var($_POST['userID']);
		$userID = $c->getUserId($username);
}

if(!is_null($userID)) {
	$u = new User($userID);
	$c->associate($_SESSION['userID'], $userID);
	$c->addFlashMsg(sprintf("Yay! Thanks. Your request to help \"%s\" has been sent & is pending approval.", $u->username));
	header('Location: /'.basename(__FILE__));
	exit();
}

$s->display('offerHelp.htm');


