<?php
require '../src/global.php';
mustBeLoggedIn();


$h = new HelperGroupController();
$c = new SendMessageController();
$c->setCarerID($CURRENT_USER['id']);
$ht = new HelpTypeController($CURRENT_USER['id']);

if (isset($_POST['helper_group_id']) && ctype_digit($_POST['helper_group_id'])) {
	$c->setHelperGroupId($_POST['helper_group_id']);
}

if (isset($_POST['msg']) && $_POST['msg']) {
	$c->setMsg($_POST['msg']);
	if (is_array($_POST['helperTypes'])) {
		foreach($_POST['helperTypes'] as $ht) {
			$c->addHelpType($ht);
		}
	}
	$id = $c->send();
	header("Location: /message.php?id=".$id);
}

$helper_groups = $h->groups();

$s = getSmarty();
$s->assign('helper_groups', $helper_groups);
$s->assign('helperTypes', $ht->getHelpTypes());
$s->display('send.htm');

