<?php @session_start(); ?>
<!DOCTYPE html><html><head><title>Home</title></head>
<?php
//Check if the user is logged in
//If not, only show them the home and login navbar...

include "include/check_login.php";

if(check_login())
	include "include/navbar.html";
else
{
	echo "
	<html>
		<div id='navbar'>
	 		<a href='./login.php'>Login</a>
		</div>
	</html>";
}
?>

<div align="center">
	<h1>Welcome to Timeclock!</h1>
</div>

</html>
