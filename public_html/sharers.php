<?php
require '../src/global.php';
checkUserSession();


$s = getSmarty();
$s->display('sharers.htm');