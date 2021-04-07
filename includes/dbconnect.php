<?php

$dbhost = "localhost";
$dbname = "webservice";
$dbuser = "root";
$dbpass = "";
try
{
	$db = new PDO("mysql:host=localhost;dbname=clinic", $dbuser, $dbpass);
}
catch (Exception $error)
{
	echo "Error connecting to database!";
}

?>