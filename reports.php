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
$conn = db_connect("timeclock");

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
		if (!$result) {
		    echo "Error executing query: " . mysql_error();
		    exit;
		}

		if (mysql_num_rows($result) == 0) {
		    echo "Empty result set";
		    exit;
		}
		$sql = "SELECT c.Employee_Name, a.Employee_Id AS User, b.Task_Id_WP AS Task, (b.Clock_out-b.Clock_in) AS Time
			FROM   TC_User a
			JOIN   Working_Period b ON a.Employee_Id = b.Employee_Id
            JOIN   TC_User c ON a.Employee_Id = c.Employee_Id
			WHERE  b.Clock_out BETWEEN NOW()-INTERVAL 1 WEEK AND NOW()
			GROUP BY Task";

		$result = mysql_query($sql);
		
		echo "This is where the report for the last week would go :) <br>";
		echo "Also the navbar is gone on this page, so we can get a pretty page to print";
		while ($row = mysql_fetch_assoc($result)) {
				echo $row["Username"];
    			echo $row["User"];
    			echo $row["Task"];
   		        echo $row["Time"];
		}
		mysql_free_result($result);
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

