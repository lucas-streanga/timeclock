<?php
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/check_login.php";

include "include/navbar.html";

include "include/create_account.html";

//Check if the form was submitted, then run this code
if(isset($_POST['submit'])){ 

echo '<br><br>';

//Establish connection to the DB
$conn = db_connect("timeclock_dev");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	$username = filter_input(INPUT_POST, 'username');

	if($username != "")
	{
		//We need to use parameterized arguments for safety
		//Check and see if an account with the ID already exists
    	$query = $conn->prepare("SELECT * FROM TC_User WHERE user_name=:username");
		$query->bindParam(':username', $username);
		$query->execute();
		$rows = $query->fetchall();

    	if(count($rows) == 0)
    	{
        	//Perfect, no account with this username  so we will create it!
			$query = $conn->prepare("INSERT INTO TC_User VALUES (NULL, :username);");
			$query->bindParam(':username', $username);
			$success = true;
			$rows = null;
			try
			{
				$query->execute(); 
				$query = $conn->prepare("SELECT user_id from TC_User WHERE user_name=:username;");
				$query->bindParam(':username', $username);
				$query->execute();
				$rows = $query->fetchall(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e) 
			{
				echo "<p> <font color=red size='4pt'>Unable to create account: </font>". "<br>". $e->getMessage(). "</p>";
				$success = false;
    		}
			$id = $rows[0]["user_id"];
			
			if($success)
				echo "<p> <font color=green size='4pt'>". 'Success! Created account with username "'. $username. '" with user ID <b>'. $id. '</b>.'. " <a href='login.php'>Login</a></font> </p>";
    	}
		else
		{
			//Uh oh, account already exists!
        	echo "<p> <font color=red size='4pt'>". "Account with username ". $username. " already exists!". "</font> </p>";
		}
	}
	if($username == "")
		echo "<p> <font color=red size='4pt'>Username must not be blank.</font> </p>";
}

}
?>

