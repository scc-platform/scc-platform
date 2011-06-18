<?php
require '../src/global.php';
checkUserSession();

$c = new LoginController();

if (isset($_POST['username']) && isset($_POST['password'])) {
	if ($c->login($_POST['username'], $_POST['password'])) {
		header("Location: /");
		die();
	}
}

$s = getSmarty();
$s->assign('PAGETITLE','Welcome to');
$s->assign('CANONICALURL','/login/');
$s->display('login.htm');
