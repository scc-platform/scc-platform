<?php
require '../src/global.php';
mustBeLoggedIn();


$h = new HelperGroupController();
$c = new SendMessageController();
$c->setCarerID($CURRENT_USER['id']);

if (isset($_POST['helper_group_id']) && ctype_digit($_POST['helper_group_id'])) {
	$c->setHelperGroupId($_POST['helper_group_id']);
}

if (isset($_POST['msg']) && $_POST['msg']) {
	$c->setMsg($_POST['msg']);
	$id = $c->send();
	header("Location: /message.php?id=".$id);
}

$helper_groups = $h->groups();

$s = getSmarty();
$s->assign('helper_groups', $helper_groups);
$s->display('send.htm');

