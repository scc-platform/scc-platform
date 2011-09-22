<?php

class BaseController {

	public function __construct() {
		session_start();
	}

	function addFlashMsg($msg) {
		$_SESSION['flash_msgs'][] = $msg; 
	}

	function getFlashMsgs() {
       	$_msgs = $_SESSION['flash_msgs']; 
		unset($_SESSION['flash_msgs']); 
		return $_msgs;
	}
}
