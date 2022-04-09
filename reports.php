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
$conn = db_connect("timeclock");

$userid = $_SESSION["userid"];

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
		$success = true;
		$rows = array();

		/*Time clock totals by tast (HH:MM:SS)
		This took forever...
		SELECT task_name,
		CONCAT(LPAD(FLOOR(SUM(TIME_TO_SEC(TIMEDIFF(clockout, clock_in)))/3600), 2, 0), ":",
		LPAD(FLOOR(SUM(TIME_TO_SEC(TIMEDIFF(clockout, clock_in)))%3600 /60), 2, 0), ":",
		LPAD(FLOOR(SUM(TIME_TO_SEC(TIMEDIFF(clockout, clock_in)))%60%60), 2, 0))
		as "HH:MM:SS"

 	FROM working_period
 	WHERE user_id=3
 	GROUP BY task_name



	If you want the total total, remove the group by.
	I put a lot of this in a routine, see total_seconds_to_time in phpmyadmin
	*/

		$sql = "SELECT DAYNAME(b.Clock_in) as Day, c.Employee_Name, a.Employee_Id AS User, b.Task_Id_WP AS Task, (b.Clock_out-b.Clock_in) AS Time
			FROM   TC_User a
			JOIN   Working_Period b ON a.Employee_Id = b.Employee_Id
            JOIN   TC_User c ON a.Employee_Id = c.Employee_Id
			WHERE  b.Clock_out BETWEEN NOW()-INTERVAL 1 WEEK AND NOW()
			AND a.Employee_Id = :userid
			GROUP BY Task;";

		$query = $conn->prepare($sql);
		$query->bindParam(':userid', $userid);
		try
		{
			$query->execute();
			//Use PDO:FETCH_ASSOC... mysql_fetch_assoc isn't supported...
			$rows = $query->fetchall(PDO::FETCH_ASSOC);
			//PDO is exception based - the rows will be empty if nothing is there
			//If the query fails, you will get an exception! Not an empty result
		}
		//Throwable will catch everything, Exception will miss somethings...
		catch(Throwable $e)
		{
			echo "<p> <font color=red size='4pt'>Unable to fetch report: </font>". "<br>". $e->getMessage(). "</p>";
			$success = false;
		}

		//count will give the correct eval
		if ($rows)
		{
			if(count($rows) == 0)
			{
		    	echo "Empty result set";
			}
			else if($success)
				echo html_table($rows);
		}

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
