<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use coloco\config\Database;

$db = new Database();
$con = $db->connect();


