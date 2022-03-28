<?php
include "include/db_connect.php";
include "include/error_reporting.php";

//Read out the html form
include "include/navbar.html";
include "include/create_account.html";

//Check if the form was submitted, then run this code
if(isset($_POST['submit'])){ 

echo '<br><br>';

//Establish connection to the DB
$conn = db_connect("test");

// Check the connection
if(!$conn)
	die("Connection to database failed!");
else
{
	$username = filter_input(INPUT_POST, 'username');
	$id = filter_input(INPUT_POST, 'id');

	if($id != "" && $username != "" && is_numeric($id))
	{
		//We need to use parameterized arguments for safety
		//Check and see if an account with the ID already exists
    	$query = $conn->prepare("SELECT * FROM account WHERE id=:id");
		$query->bindParam(':id', $id);
		$query->execute();
		$rows = $query->fetchall();

    	if(count($rows) == 0)
    	{
        	//Perfect, no account with this ID so we will create it!
			$query = $conn->prepare("INSERT INTO account VALUES (:username, :id);");
			$query->bindParam(':username', $username);
			$query->bindParam(':id', $id);
			$success = true;
			try
			{
				$query->execute(); 
			}
			catch(PDOException $e) 
			{
				echo "<p> <font color=red size='4pt'>Unable to create account: </font>". "<br>". $e->getMessage(). "</p>";
				$success = false;
    		}
			
			if($success)
				echo "<p> <font color=green size='4pt'>". 'Success! Created account with username "'. $username. '" and ID '. $id. '.'. "</font> </p>";
    	}
		else
		{
			//Uh oh, account already exists!
        	echo "<p> <font color=red size='4pt'>". "Account with ID ". $id. " already exists!". "</font> </p>";
		}
	}
	if($id == "" || $username == "")
		echo "<p> <font color=red size='4pt'>Username and ID must not be blank.</font> </p>";
	if(is_numeric($id) == false)
		echo "<p> <font color=red size='4pt' align='center'>ID must be an integer number.</font> </p>";
}

}
?>

