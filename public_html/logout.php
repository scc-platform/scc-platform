<?php
require '../src/global.php';

checkUserSession();
$_SESSION['userID'] =  null;

header("Location: /");