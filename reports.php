<?php
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/navbar.html";

//Check if the form was submitted, then run this code
if(isset($_POST['submit'])){ 

//Establish connection to the DB
$conn = db_connect("test");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	//The report view html file includes a print button
	//You can output whatever you want to the screen and it will get printed on the button press
	include "include/report_view.html";
	echo "This is where the report for the last week would go :) <br>";
	echo "Also the navbar is gone on this page, so we can get a pretty page to print";
}

}
else
{
	//Only show the html code if the form is not yet submitted
	//This way, when they submit the form we get a blank page and can format the report
	include "include/reports.html";
}
?>

