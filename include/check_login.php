<?php

//Super simple script, will simply check if the user is logged in
//If not, redirect them to home and end the script
//You can include this anywhere on any page a log in is necessary!

//We don't even need to establish a coonnection to the db
//Just check if the session is still alive, if not they are not logged in!

//For the real thing, determine this based off the session
$logged_in = true;

if(!$logged_in)
{
	echo "<br><br>";
	echo "<p> <font color=red size='4pt'>You are not currently logged in. <a href='index.php'>Home</a> </font> </p>";

	//the exit is necessary so nothing else will print, regardless of the script
	exit(0);
}
?>
