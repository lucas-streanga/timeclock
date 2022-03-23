<?php

function db_connect($dbname)
{
	$host = 'localhost';
	$dbusername = 'root';
	$dbpassword = 'w,eFd@U!!G,E]6.S__yvPS:A';

	//Now open a connection to the database

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

