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

if (isset($_POST['prefs']) && $_POST['prefs'] == 'change') {
	$c->setUseEmail(isset($_POST['useEmail']) && $_POST['useEmail'] ? true : false );
	$c->setUseTwitter(isset($_POST['useTwitter']) && $_POST['useTwitter'] ? true : false );
	$c->setUseTxt(isset($_POST['useTxt']) && $_POST['useTxt'] ? true : false );
	$c->setPhone($_POST['txtNumber']);
	$c->save();
}

$s = getSmarty();
$s->assign('isActive',$c->isActive());
$s->assign('useEmail',$c->useEmail());
$s->assign('useTxt',$c->useTxt());
$s->assign('useTwitter',$c->useTwitter());
$s->assign('phone',$c->getPhone());
$s->display('prefs.htm');

