<?php
require '../src/global.php';

$c = new SignUpController();

if (isset($_POST['email']) && $_POST['email']
	&& isset($_POST['username']) && $_POST['username']
	&& isset($_POST['password']) && $_POST['password']) {

	if($c->userExists($_POST['username'])) {
		$c->addFlashMsg(sprintf("'%s' is being used by another user.", $_POST['username']));
		header("Location: /" . basename(__FILE__));
		die();
	}
	else {
		$id = $c->signUp($_POST['email'], $_POST['username'], $_POST['password']);
		session_start();
		$_SESSION['userID'] = $id;
		header("Location: /");
		die();
	}
}

$s = getSmarty();
$s->display('signup.htm');


