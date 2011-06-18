<?php
require '../src/global.php';
mustBeLoggedIn();


$c = new ReadMessageController();
$c->setCarerID($CURRENT_USER['id']);
$c->setMessageID($_GET['id']);


if ($c->isReadAllowed()) {
	$s = getSmarty();
	$s->assign('body',$c->getMsgBody());
	$s->display('message.htm');
} else {
	print "Not allowed";
	die();
}
