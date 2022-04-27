<?php
include_once "include/error_reporting.php";

//This script is used to delete a task!
//This is intended to be included in other files (like create_task)
//So, no html head here!

function print_delete_task_form($conn, $userid)
{
	echo "<br>";
	//Form!
	echo '
	<form method="post" action="";><fieldset>
                <legend align="center" style="font-size:24px">Delete Task</legend>';

	//Use a query to get all the task names for this user...
    $query = $conn->prepare("SELECT task_name FROM Task WHERE assignee_id=:id");
    $query->bindParam(':id', $userid);
    $query->execute();
    $rows = $query->fetchall(PDO::FETCH_ASSOC);
	echo '<br><br>
		<label for="task_select">Choose a task:</label>
		<select style="width: 25%"name="task_select" id="task_select">
	';

	foreach($rows as &$individual_row)
		foreach($individual_row as &$value)
			echo '<option>'. htmlentities($value). '</option>';

	echo '</select>';

	echo '
        <div align="center">
            <input id="submit_button" type="submit" name="delete_task_submit" value="Delete Task">
        </div>
        ';
	echo '</form></fieldset>';
}

function delete_task_form($conn, $userid)
{
  print_delete_task_form($conn, $userid);
	//They clicked the delete task button
	if(isset($_POST['delete_task_submit']))
	{
    //Now we gotta delete the task
    $task_name = filter_input(INPUT_POST, 'task_select');
    if($task_name == "")
    {
      echo "<p> <font color=red size='4pt'>You must select a task to delete.</font></p>";
    }
    else
    {
	  $success = true;
      //Delete the task. We already know it exists bc of the prev function...
      $query = $conn->prepare("DELETE FROM Task WHERE task_name=:task_name AND assignee_id=:userid;");
      $query->bindParam(":task_name", $task_name);
      $query->bindParam(":userid", $userid);
      try { $query->execute(); }
      catch(Throwable $e)
      {
        echo "<p> <font color=red size='4pt'>Unable to delete task.</font></p>";
		$success = false;
      }
	  if($success)
	  		echo "<p> <font color=green size='4pt'>". 'Success! Deleted task: "'. $task_name. '".';

    }
  }
}
?>
