<?php @session_start(); ?>
<!DOCTYPE html><html><head><title>Home</title></head>
<?php
//Check if the user is logged in
//If not, only show them the home and login navbar...

include "include/navbar.html";

<div align="center">
	<br>
	<h1>Welcome to Timeclock!</h1>
	<br>
	<h2>
		Timeclock is a web application for tracking hours. <br>
		Create an account or login to start clocking time. <br>
		You can categorize your time clocks by <i> task</i>.<br>
		You can view and print reports of your time spent. <br>
	</h2>
</div>

</html>
