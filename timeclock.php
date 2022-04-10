<?php @session_start();
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/report_gen.php";

//Read out the html form
include "include/navbar.html";

//Check if the user is logged in (can't clock in and out if you're not logged in!)
include "include/check_login.php";
check_login_or_redirect();
$userid = $_SESSION["userid"];

echo "<html><head><title>Timeclock</title><link rel='stylesheet' href='css/timeclock.css'></head><html>";

function print_clockin_form($conn, $userid)
{
	//Form!
	echo '
	<form method="post" action="";><fieldset>
                <legend align="center" style="font-size:24px">Timeclock</legend>';

	//Use a query to get all the task names for this user...
    $query = $conn->prepare("SELECT name FROM task WHERE userid=:id");
    $query->bindParam(':id', $userid);
    $query->execute();
    $rows = $query->fetchall(PDO::FETCH_ASSOC);
	echo '<br><br>
		<label for="task_select">Choose a task:</label>
		<select name="task_select" id="task_select">
	';
	
	foreach($rows as &$individual_row)
		foreach($individual_row as &$value)
			echo '<option>'. $value. '</option>';

	echo '</select>';
	echo "<br>Or,  <a href='create_task.php'>create a new task</a>";

	echo '
        <div align="center">
            <input id="submit_button" type="submit" name="submit" value="Clock In">
        </div>      
        ';
	echo '</form></fieldset>';


}

function print_clockout_form($rows)
{
	//Get the task, and when they clocked in
	$clockin_time = $rows[0]["clock_in"];
	$task_name = $rows[0]["task_name"];

	echo '<form method="post" action="";><fieldset>
                <legend align="center" style="font-size:24px">Timeclock</legend>';
	
	echo 'You are currently clocked in under the task: '. $task_name;
	echo '<br>You clocked in at: '. $clockin_time;
	echo '
        <div align="center">
            <input id="submit_button" type="submit" name="submit" value="Clock Out">
        </div>';
    echo '</form></fieldset>';

}

function query_working_period($conn, $userid)
{
	$query = $conn->prepare("SELECT * FROM working_period  WHERE user_id=:id AND clockout is NULL;");
    $query->bindParam(':id', $userid);
    $query->execute();
    $rows = $query->fetchall(PDO::FETCH_ASSOC);
	return $rows;
}

function clockin_routine($conn, $userid)
{
	$task = filter_input(INPUT_POST, 'task_select');
	if($task == "")
	{
		echo "<p> <font color=red size='4pt'>You must create at least one task to clock in. <a href='timeclock.php'>Back</a></font></p>";
		die();
	}
	//Unfortunately, we need to check the clock-in status again...
	$rows = query_working_period($conn, $userid);
	if(!(count($rows) == 0))
	{
    	echo "<p> <font color=red size='4pt'>Unable to clock in. Are you already clocked in? <a href='timeclock.php'>Back</a></font></p>";
		die();
	}
	$query = $conn->prepare("INSERT INTO working_period (clock_in, clockout, id, task_name, user_id) VALUES (NOW(), NULL, NULL, :task, :id);");
	$query->bindParam(':id', $userid);
	$query->bindParam(':task', $task);
	try{$query->execute();}
	catch(Throwable $e)
	{
		echo "<p> <font color=red size='4pt'>Unable to clock in. <a href='timeclock.php'>Back</a></font></p>";
		die();
	}
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	echo "<p> <font size='4pt'>You have been clocked in under the task '". $task. "'. <a href='index.php'>Home</a></font></p>";
}

function clockout_routine($conn, $userid)
{
	$rows = query_working_period($conn, $userid);
	if((count($rows) == 0))
	{
		echo "<p> <font color=red size='4pt'>Unable to clock out. Are you already clocked out? <a href='timeclock.php'>Back</a></font></p>";
		die();
	}
	$query = $conn->prepare("UPDATE working_period SET clockout=NOW() WHERE user_id=:id;");
	$query->bindParam(':id', $userid);
	try{$query->execute();}
	catch(Throwable $e)
	{
		echo "<p> <font color=red size='4pt'>Unable to clock out. <a href='timeclock.php'>Back</a></font></p>";
		die();
	}
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	echo "<p><font size='4pt'>You have been clocked out. <a href='index.php'>Home</a></font></p>";
}

//First, we need to check if the user is currently clocked in or clocked out!
//the user id is given by the session, run a query to see if they're clocked in or not.

$conn = db_connect("test");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	//First we need to check if the user is clocked in or clocked out...
	//Userid is grabbed from the session at the start of this script
	$rows = query_working_period($conn, $userid);
	$clocked_in = !(count($rows) == 0);

	//They clicked the clock-in/clock-out button
	if(isset($_POST['submit']))
	{
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$clocked_in)
		{
			//clock-in!
			clockin_routine($conn, $userid);
		}
		else
		{
			//clock-out!
			clockout_routine($conn, $userid);
		
		}
	}
	else
	{
		if(!$clocked_in)
		{
			print_clockin_form($conn, $userid);
		}
		else
		{
			print_clockout_form($rows);
		}
	}
}

?>

