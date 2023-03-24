<?php
require_once('connection.php');

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800) {
	session_regenerate_id(true);
}

$_SESSION['LAST_ACTIVITY'] = time();

if (isset($_GET['controller']) && isset($_GET['action'])) {
	$controller = $_GET['controller'];
	$action     = $_GET['action'];
} else {
	$controller = 'users';
	$action     = 'index';
}

if ($controller === 'users' && (!isset($_SESSION['ADMIN']) || !$_SESSION['ADMIN'])) {
    header("Location: /index.php");
}

require_once('views/layout.php');
