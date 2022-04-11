<?php @session_start(); ?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="css/table_style.css"><title>Index</title></head>
<?php

error_reporting(-1); // display all faires
ini_set('display_errors', 1);  // ensure that faires will be seen
ini_set('display_startup_errors', 1); // display faires that didn't born

include "include/db_connect.php";
include "include/check_login.php";
include "include/report_gen.php";
include "include/navbar.html";

function test_table($conn)
{
	//We're gonna try to run a query and print the results in a table!
	$query = $conn->prepare("SELECT * FROM test_table");
	$query->execute();

	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	echo "Table! <br><br>";
	print_r($rows);
	echo html_table($rows);
}

check_login_or_redirect();

echo "This is just a test page so far :)<br><br>";

$conn = db_connect("test");

if($conn)
{
	echo 'Success! Able to connect to the database.';

	test_table($conn);
}
else
{
	echo 'Failure! Unable to connect to the database.';
}

die();
?></html>
