<?php @session_start();
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/navbar.html";

//Check if the user is currently logged in, then display the logout button
//Use session to check if they're logged in

//This script will check the login status
include "include/check_login.php";

//Establish connection to the DB
$conn = db_connect("timeclock_dev");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	if(isset($_POST['submit']))
	{

		// Unset all of the session variables.
		$_SESSION = array();
		
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}
		
		// Finally, destroy the session.
		session_destroy();
		echo "<br><br>";
		echo '<font size = "4pt">You are now logged out. You may now close this browser window. </font>';
	}
	else
	{
		$username = htmlentities($_SESSION['username']);
		echo '<font size = "4pt">You are currently logged in as <b>'. $username. '</b></font>';
    	include "include/logout.html";
	}
}

?>

