<?php
require dirname(__FILE__).'/../src/global.php';

$c = new ProcessMessage();
if (!$c->loadNext()) {
	print "No more to send!";
	die();
}


$c->loadUsersSenderRequested();
var_dump($c->desiredToUsers);
$c->filterUsersCanReceiveMessages();
var_dump($c->actualToUsers);
$c->sendToUsers();