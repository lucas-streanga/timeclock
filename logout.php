<?php
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/navbar.html";

//Check if the user is currently logged in, then display the logout button
//Use session to check if they're logged in

//This script will check the login status
include "include/check_login.php";

//Establish connection to the DB
$conn = db_connect("test");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	if(isset($_POST['submit']))
	{
		//Unset the session variables here!
		echo "<br><br>";
		echo '<font size = "4pt">You are now logged out. <a href="index.php">Home</a> </font>';
	}
	else
	{
    	include "include/logout.html";
	}
}

?>

