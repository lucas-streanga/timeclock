<?php include "include/navbar.html";
$start_date = new DateTime();
$start_date->setDate(2022, 4, 4);
$end_date = new DateTime();
$end_date->setDate(2022, 4, 10);
include "include/rand_data_gen.php";
?>

<html><head><title>Home</title></head>
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
