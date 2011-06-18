<?php
require '../src/global.php';

$c = new SignUpController();

if (isset($_POST['email']) && $_POST['email']) {
	if ($c->signUp($_POST['email'], $_POST['username'], $_POST['password'])) {
		
	}
}

$s = getSmarty();
$s->display('signup.htm');


