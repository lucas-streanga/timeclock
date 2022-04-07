<?php
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/navbar.html";

//Check login (use the check loging script!)
include "include/check_login.php";
check_login_or_redirect();

//Check if any form was submitted, then run this code
if($_SERVER["REQUEST_METHOD"] == "POST"){ 

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
	
	if(isset($_POST['simple_report_submit']))
	{
		echo "This is where the report for the last week would go :) <br>";
		echo "Also the navbar is gone on this page, so we can get a pretty page to print";
		//We can run queries and generate the reports here, output them to html easily
		//The report_gen.php file will include functions for generating the reports.
		//Right now, only html_table() is included, to generate an html table from a db select.
	}
	//Other form submittals will be here if we have them
}

}
else
{
	//Only show the html code if the form is not yet submitted
	//This way, when they submit the form we get a blank page and can format the report
	include "include/reports.html";
}
?>

