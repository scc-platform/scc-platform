<?php
require '../src/global.php';
mustBeLoggedIn();

$c = new PreferencesController($CURRENT_USER['id']);

if (isset($_POST['makeInactivate']) && $_POST['makeInactivate'] == 'yes') {
	$c->setIsActive(false);
	$c->save();
}

if (isset($_POST['makeActive']) && $_POST['makeActive'] == 'yes') {
	$c->setIsActive(true);
	$c->save();
}



$s = getSmarty();
$s->assign('isActive',$c->isActive());
$s->display('prefs.htm');

