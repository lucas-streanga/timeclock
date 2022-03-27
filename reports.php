<?php
include "include/db_connect.php";
include "include/error_reporting.php";

//Check if the form was submitted, then run this code
if(isset($_POST['submit'])){ 

echo '<br><br>';

//Establish connection to the DB
$conn = db_connect("test");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
    echo "This is where the report for the last week would go :) <br>";
	echo "Also the navbar is gone on this page, so we can get a pretty page to print";
}

}
else
{
	//Only show the html code if the form is not yet submitted
	//This way, when they submit the form we get a blank page and can format the report
	include "include/navbar.html";
	include "include/reports.html";
}
?>

