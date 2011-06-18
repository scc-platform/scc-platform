<?php
require '../src/global.php';
mustBeLoggedIn();

$c = new SendMessageController();
$c->setCarerID($CURRENT_USER['id']);

if (isset($_POST['msg']) && $_POST['msg']) {
	$c->setMsg($_POST['msg']);
	$id = $c->send();
	header("Location: /message.php?id=".$id);
}

$s = getSmarty();
$s->display('send.htm');

