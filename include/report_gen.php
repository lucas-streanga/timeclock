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

?>
