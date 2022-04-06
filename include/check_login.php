<?php @session_start();

//Super simple script, will simply check if the user is logged in
//If not, redirect them to home and end the script
//You can include this anywhere on any page a log in is necessary!

//We don't even need to establish a coonnection to the db
//Just check if the session is still alive, if not they are not logged in!

//For the real thing, determine this based off the session
function check_login(){
	return @isset($_SESSION['userid']);
}

function check_login_or_redirect()
{
	if(!check_login())
	{
    	echo "<meta http-equiv=\"refresh\" content=\"0;url=login.php\">";
	}
}
?>
