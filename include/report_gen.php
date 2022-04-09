<?php

//Simple function to generate an HTML table from a SQL Query Result
function html_table($rows)
{
	$ret = "";
	$table_headers = $rows[0];
	$ret = $ret . "<table style =\"width:100%;\">";
	foreach(array_keys($table_headers) as &$column_name)
		$ret = $ret . "<th style = \"text-align: left\">" . $column_name . "</th>";

	foreach($rows as &$individual_row)
	{
		$ret = $ret . "<tr>";
		foreach($individual_row as &$value)
			$ret = $ret . "<td style = \"\">" . $value . "</td>";
		$ret = $ret . "</tr>";
	}

	$ret = $ret . "</table>";

	return $ret;
}

function total_per_task($rows)
{
	//Return an array, with the keys being the column names and the results being the total per task
	//You could run a SQL query for this, but this is easier for me.

	$ret = array(array());
	$i= 0;
	foreach($rows as &$individual_row)
		foreach(array_keys($individual_row) as &$column_name)
		{
			if($column_name = "Task")
			{
				$task_name = $individual_row[$column_name];
				$exists = false;
				//Check if the task already exists in the output...
				foreach($ret as &$individual_ret)
					if(array_key_exists($individual_ret, $column_name))
						$exists = true;

				if(!$exists)
				{
					$ret[$i] = array("Task" => $individual_row[$column_name], "Total" => ".");
					$i++;
				}
			}
		}
		return $ret;

}

?>
