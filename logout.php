<?php
error_reporting(E_ERROR);
session_start();
$_SESSION = [];
session_unset();
session_destroy();
setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);
clearstatcache();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Location: login.php');
exit;
