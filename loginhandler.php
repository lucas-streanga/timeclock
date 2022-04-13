<?php @session_start();
include "include/db_connect.php";
include "include/error_reporting.php";

//Establish connection to the DB
$conn = db_connect("timeclock_dev");


// Check the connection
if(!$conn)
	
	die("Connection to database failed!");
else
{
	$username = filter_input(INPUT_POST, 'username');
	$id = filter_input(INPUT_POST, 'userid');

	if($id != "" && $username != "" && is_numeric($id))
	{
		//We need to use parameterized arguments for safety
		//Check and see if an account with the ID already exists
    	$query = $conn->prepare("SELECT * FROM TC_User WHERE user_id=:userid AND user_name=:username");
		$query->bindParam(':userid', $id);
		$query->bindParam(':username', $username);
		//We should try to catch this excpetion, bc the query id could be out of range
		try { $query->execute(); $rows = $query->fetchall(); }
		catch(Throwable $e)
		{
			//Dont log them in!
			if (!@isset($_SESSION['login_fail']))
                $_SESSION['login_fail'] = true;
            echo "<meta http-equiv=\"refresh\" content=\"0;url=login.php\">";
		}
    	if(count($rows) > 0)
    	{
			//account exists, set session variables for later use
			$_SESSION['username'] = $username;
			$_SESSION['userid'] = $id;
			if (@isset($_SESSION['login_fail']))
			{
				unset($_SESSION['login_fail']);
			}
			echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
        }
		else
		{
			//Account doesn't exist, set login fail session variable, and redirect back to login form
        	if (!@isset($_SESSION['login_fail']))
				$_SESSION['login_fail'] = true;
			echo "<meta http-equiv=\"refresh\" content=\"0;url=login.php\">";
		}
	}
}
?>
