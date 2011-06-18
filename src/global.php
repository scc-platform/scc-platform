<?php
require dirname(__FILE__).'/../config.php';


function my_autoload($class_name){
	$inc = dirname(__FILE__);
	if(file_exists($inc."/".$class_name.'.class.php')){
		require_once($inc."/".$class_name.'.class.php');
		return;
	}
}
spl_autoload_register("my_autoload");

$DB_CONNECTION = null;
/** @return PDO **/
function getDB() {
	global $DB_CONNECTION;
	if (!$DB_CONNECTION) {
		$DB_CONNECTION = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$DB_CONNECTION->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$DB_CONNECTION->exec("SET NAMES 'utf8'");
	}
	return $DB_CONNECTION;
}


/** @return Smarty **/
function getSmarty() {
	global $CURRENT_USER;
	require_once dirname(__FILE__).'/../smarty/Smarty.class.php';
	$s = new Smarty();
	$s->template_dir = dirname(__FILE__) . '/../templates/';
	$s->compile_dir = dirname(__FILE__) . '/../smarty_c/';
	$s->assign('currentUser',$CURRENT_USER);
	return $s;
}



function mustBeLoggedIn() {
	global $CURRENT_USER;
	checkUserSession();
	if (!$CURRENT_USER) {
		header('Location: /');
		die();
	}
}

$CURRENT_USER = null;

function checkUserSession() {
	global $CURRENT_USER;
	session_start();
	if (isset($_SESSION['userID']) && intval($_SESSION['userID']) > 0) {
		$db = getDB();
		$stat = $db->prepare("SELECT * FROM users WHERE id=:id");
		$stat->execute(array('id'=>$_SESSION['userID']));
		if ($stat->rowCount() == 1) {
			$CURRENT_USER = $stat->fetch(PDO::FETCH_ASSOC);
		}
	}
}
