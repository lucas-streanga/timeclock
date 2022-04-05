<?php @session_start();
include "include/db_connect.php";

//Establish connection to the DB
$conn = db_connect("test");

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
    	$query = $conn->prepare("SELECT * FROM account WHERE user_id=:userid");
		$query->bindParam(':userid', $id);
		$query->execute();
		$rows = $query->fetchall();

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
			{
				$_SESSION['login_fail'] = true;
				echo "<meta http-equiv=\"refresh\" content=\"0;url=login.php\">";
			}
		}
	}
}
?>