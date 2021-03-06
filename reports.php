<?php
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/navbar.html";
include "include/report_gen.php";

//Check login (use the check loging script!)
include "include/check_login.php";
check_login_or_redirect();

//Check if any form was submitted, then run this code
if($_SERVER["REQUEST_METHOD"] == "POST"){

//Establish connection to the DB
$conn = db_connect("timeclock_dev");

$userid = $_SESSION["userid"];

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	$html = null;
	//The report view html file includes a print button
	//You can output whatever you want to the screen and it will get printed on the button press
	include "include/report_view.html";

	if(isset($_POST['simple_report_submit']))
	{
		try
		{
			$html = last_week_report($conn, $userid);
		}
		//Throwable will catch everything, Exception will miss somethings...
		catch(Throwable $e)
		{
			echo "<p> <font color=red size='4pt'>Unable to fetch report: </font>". "<br>". $e->getMessage(). "</p>";
			die();
		}
	}
	if(isset($_POST['exhaustive_report_submit']))
	{
		try
		{
			$html = all_time_report($conn, $userid);
		}
		//Throwable will catch everything, Exception will miss somethings...
		catch(Throwable $e)
		{
			echo "<p> <font color=red size='4pt'>Unable to fetch report: </font>". "<br>". $e->getMessage(). "</p>";
			die();
		}
	}
	if(isset($_POST['date_report_submit']))
	{
		$start_date = filter_input(INPUT_POST, 'date_picker_start');
		$end_date =filter_input(INPUT_POST, 'date_picker_end');
		if(!strtotime($start_date) || !strtotime($end_date))
		{
			echo "<p> <font color=red size='4pt'>Input was not in date format. <a href='reports.php'>Back</a></font></p>";
		}
		else
		{
			try
			{
				$html = date_report($conn, $userid, $start_date, $end_date);
			}
			//Throwable will catch everything, Exception will miss somethings...
			catch(Throwable $e)
			{
				echo "<p> <font color=red size='4pt'>Unable to fetch report: </font>". "<br>". $e->getMessage(). "</p>";
				die();
			}
		}
	}
	//Other form submittals will be here if we have them



	//The report generator will return null on empty set.
	if (!$html)
	{
		echo "<p> <font color=red size='4pt'>Empty result set...</p>";
	}
	else
	{
		echo $html;
	}
}

}
else
{
	//Only show the html code if the form is not yet submitted
	//This way, when they submit the form we get a blank page and can format the report
	include "include/reports.html";
}
?>
