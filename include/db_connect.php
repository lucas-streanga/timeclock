<?php

function db_connect($dbname)
{
	$host = 'localhost';
	$dbusername = 'root';
	$dbpassword = getenv('DBROOTP');

	//Now open a connection to the database
	//Force the right database
	$dbname = "timeclock";

	try
	{
		$conn = new PDO('mysql:host='.$host.';dbname='.$dbname, $dbusername, $dbpassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(\Exception $e)
	{
		return null;
	}
	return $conn;
}

?>
