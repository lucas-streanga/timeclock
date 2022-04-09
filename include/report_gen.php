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

function last_week_report($conn, $userid)
{
	$overall_sql = '
	SELECT  DAYNAME(clock_in) as Day,
	task_name as Task,
	clock_in as "In",
	clockout as "Out",
	TIMEDIFF(clockout, clock_in) as Time
	FROM working_period
	WHERE user_id=:userid AND clockout BETWEEN NOW()-INTERVAL 1 WEEK AND NOW()
	GROUP BY DAYNAME(clock_in)
	ORDER BY DAY(clock_in);';

	$totals_per_task_sql = '
	SELECT task_name as Task,
	total_seconds_to_time(SUM(TIME_TO_SEC(TIMEDIFF(clockout, clock_in))))
	as "Total (HH:MM:SS)"
	FROM working_period
	WHERE user_id=:userid
	GROUP BY task_name
	ORDER BY DAY(clock_in);';

	$totals_per_day_sql = '
	SELECT DAYNAME(clock_in) as Day,
	total_seconds_to_time(SUM(TIME_TO_SEC(TIMEDIFF(clockout, clock_in))))
	as "Total (HH:MM:SS)"
	FROM working_period
	WHERE user_id=:userid AND clockout BETWEEN NOW()-INTERVAL 1 WEEK AND NOW()
	GROUP BY DAYNAME(clock_in)
	ORDER BY DAY(clock_in);';

	$report_total_sql = '
	SELECT total_seconds_to_time(SUM(TIME_TO_SEC(TIMEDIFF(clockout, clock_in))))
	as "Report Total (HH:MM:SS)"
	FROM working_period
	WHERE user_id=:userid;';

	$html_ret = "";

	//Don't bother catching exceptions here, we'll do that when we call this function...

	$query = $conn->prepare($overall_sql);
	$query->bindParam(':userid', $userid);
	$query->execute();
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	//Uh oh! Nothing to show...
	if(count($rows) == 0 || !$rows)
	{
		return null;
	}
	$html_ret .= "<font font-size='4px'><b>Hours by Day and Task</b>". html_table($rows);

	$query = $conn->prepare($totals_per_task_sql);
	$query->bindParam(':userid', $userid);
	$query->execute();
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	//Uh oh! Nothing to show...
	if($rows && count($rows) != 0)
		$html_ret .= "<br><font font-size='4px'><b>Totals by Task</b>". html_table($rows);

	$query = $conn->prepare($totals_per_day_sql);
	$query->bindParam(':userid', $userid);
	$query->execute();
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	//Uh oh! Nothing to show...
	if($rows && count($rows) != 0)
		$html_ret .= "<br><font font-size='4px'><b>Totals by Day</b>". html_table($rows);

	$query = $conn->prepare($report_total_sql);
	$query->bindParam(':userid', $userid);
	$query->execute();
	$rows = $query->fetchall(PDO::FETCH_ASSOC);
	//Uh oh! Nothing to show...
	if($rows && count($rows) != 0)
		$html_ret .= "<br><font font-size='4px'><b>Overall Total</b>". html_table($rows);

	return $html_ret;
}

?>
