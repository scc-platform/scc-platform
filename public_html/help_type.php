<?php
require '../src/global.php';
mustBeLoggedIn();

$c = new HelpTypeController($CURRENT_USER['id']);

if (isset($_POST['helpType']) && $_POST['helpType']) {
	$c->add($_POST['helpType']);
}

$s = getSmarty();
$s->assign('helpTypes',$c->getHelpTypes());
$s->display('help_type.htm');
