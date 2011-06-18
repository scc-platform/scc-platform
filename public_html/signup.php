<?php
require '../src/global.php';

$c = new SignUpController();

if (isset($_POST['email']) && $_POST['email']) {
	$id = $c->signUp($_POST['email'], $_POST['username'], $_POST['password']);
	session_start();
	$_SESSION['userID'] = $id;
	header("Location: /");
	die();
}

$s = getSmarty();
$s->display('signup.htm');


