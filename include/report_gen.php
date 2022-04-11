<?php
include "error_reporting.php";

//Simple function to generate an HTML table from a SQL Query Result
function html_table($rows)
{
	$ret = "";
	$table_headers = $rows[0];
	$ret = $ret . "<table style='size:4pt;'>";
	foreach(array_keys($table_headers) as &$column_name)
		$ret = $ret . "<th style='padding:4px'>" . $column_name . "</th>";

	foreach($rows as &$individual_row)
	{
		$ret = $ret . "<tr>";
		foreach($individual_row as &$value)
			$ret = $ret . "<td style='padding:4px'>" . $value . "</td>";
		$ret = $ret . "</tr>";
	}

	$ret = $ret . "</table>";

	return $ret;
}

function execute_by_userid($conn, $userid, $sql)
{
	$query = $conn->prepare($sql);
	echo $sql. "<br>";
	$query->bindParam(':userid', $userid);
	$query->execute();
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	return $rows;
}

function date_report($conn, $userid, $start_date, $end_date)
{
	//Formulate a report and return by start date and end date...
	//This is trivial... but the dates should be properly formatted before being called!!
}

//Generate a report, inserting your own date clause!
//General purpose!
//There is NO SQL INJECTION PROTECTION on the Where clause!
//So your WHERE clause should be made by YOU, don't just take user input!
//Check that user input is the right format!
function gen_report($conn, $userid, $WHERE)
{
	$overall_sql = '
	SELECT DAYNAME(a.clock_in) as Day,
	b.task_name as Task,
	a.clock_in as "In",
	a.clock_out as "Out",
	TIMEDIFF(a.clock_out, a.clock_in) as Time
	FROM Working_Period a
	JOIN Task b ON a.task_name = b.task_name '
	.$WHERE.
	' GROUP BY DAYNAME(a.clock_in)
	ORDER BY DAY(a.clock_in);';

	$totals_per_day_sql = '
	SELECT DAYNAME(clock_in) as Day,
	total_seconds_to_time(SUM(TIME_TO_SEC(TIMEDIFF(clock_out, clock_in))))
	as "Total (HH:MM:SS)"
	FROM Working_Period a '
	.$WHERE.
	' GROUP BY DAYNAME(clock_in)
	ORDER BY DAY(clock_in);';

	$totals_per_task_sql = '
	SELECT b.task_name as Task,
	total_seconds_to_time(SUM(TIME_TO_SEC(TIMEDIFF(a.clock_out, a.clock_in))))
	as "Total (HH:MM:SS)"
	FROM Working_Period a
	JOIN Task b ON a.task_name = b.task_name ' 
	.$WHERE.
	' GROUP BY b.task_name
	ORDER BY DAY(a.clock_in);';

	$report_total_sql = '
	SELECT total_seconds_to_time(SUM(TIME_TO_SEC(TIMEDIFF(clock_out, clock_in))))
	as "Report Total (HH:MM:SS)"
	FROM Working_Period a '
	.$WHERE.
	' ;';

	$html_ret = "";

	//Don't bother catching exceptions here, we'll do that when we call this function...

	$rows = execute_by_userid($conn, $userid, $overall_sql);
	//Uh oh! Nothing to show...
	if(count($rows) == 0 || !$rows)
	{
		return null;
	}
	$html_ret .= "<font font-size='4px'><b>Hours by Day and Task</b>". html_table($rows);

	$rows = execute_by_userid($conn, $userid, $totals_per_task_sql);
	//Uh oh! Nothing to show...
	if($rows && count($rows) != 0)
		$html_ret .= "<br><font font-size='4px'><b>Totals by Task</b>". html_table($rows);

	$rows = execute_by_userid($conn, $userid, $totals_per_task_sql);
	//Uh oh! Nothing to show...
	if($rows && count($rows) != 0)
		$html_ret .= "<br><font font-size='4px'><b>Totals by Day</b>". html_table($rows);

	$rows = execute_by_userid($conn, $userid, $report_total_sql);
	//Uh oh! Nothing to show...
	if($rows && count($rows) != 0)
		$html_ret .= "<br><font font-size='4px'><b>Overall Total</b>". html_table($rows);

	return $html_ret;
}

function all_time_report($conn, $userid)
{
	$WHERE = 'WHERE a.FK_user_id=:userid';
	return gen_report($conn, $userid, $WHERE);
}

function last_week_report($conn, $userid)
{
	$WHERE = 'WHERE a.FK_user_id=:userid 
	AND a.clock_out >= (curdate() - INTERVAL((WEEKDAY(curdate()))+7) DAY)
   	AND a.clock_out < (curdate() - INTERVAL((WEEKDAY(curdate()))+1) DAY)';
	
	return gen_report($conn, $userid, $WHERE);
}

?>
