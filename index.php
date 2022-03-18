<!DOCTYPE html><html><head><title>Index</title></head>
<?php

error_reporting(-1); // display all faires
ini_set('display_errors', 1);  // ensure that faires will be seen
ini_set('display_startup_errors', 1); // display faires that didn't born

include "db_connect.php";

echo "This is just a test page so far :)<br><br>";


$conn = db_connect();

if($conn)
{
	echo 'Success! Able to connect to the database.';
}
else
{
	echo 'Failure! Unable to connect to the database.';
	die();
}

?></html>
