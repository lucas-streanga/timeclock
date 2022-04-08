<?php @session_start();
include "include/db_connect.php"
include "include/report_gen.php";
include "include/navbar.html";
include "include/create_task.html"
$conn = db_connect("tasks")

if(isset($_post['submit'])){

if(!$conn)
{
    die("Connection to database failed!");
}
else
{
    $taskName = filter_input(INPUT_POST, 'username');
    if($taskName != "")
    {
        $query = $conn->prepare("SELECT * FROM tasks WHERE task_name=:taskName AND userid=:userid");
        $query -> bindParam(":taskName", $taskName);
        $query -> bindParam(":userid", $_SESSION['userid']);
        $query -> execute();
        $rows = $query -> fetchall(PDO::FETCH_ASSOC);

        if(count($rows) == 0)
        {
            $query = $conn->prepare("INSERT INTO tasks VALUES (:taskName, :userid");
            $query -> bindParam(":taskName", $taskName);
            $query -> bindParam(":usrid", $_SESSION["userid"]);
            $success = true;
            $rows = null;
            try
            {
                $query -> execute();
                $query = $conn -> prepare("SELECT taskName from tasks WHERE task_name = :taskName AND userid = :userid");
                $query -> bindParam(":taskName", $taskName);
                $query -> bindParam(":userid", $_SESSION["userid"]);
                $query -> execute();
                $rows = $query -> fetchall(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                echo "<p> <font color=red size='4pt'>Unable to create account: </font>". "<br>". $e->getMessage(). "</p>";
				$success = false;
            }

            if($success)
            echo "<p> <font color=green size='4pt'>". 'Success! Created task with name "'.$taskName. '</b>.'. " <a href='timeclock.php'>Back</a></font> </p>";
        }
        else
        {
            echo "<p> <font color=red size='4pt'>". "Task with name ". $taskName. " already exists!". "</font> </p>";
        }
    }
    else
    {
        echo "<p> <font color=red size='4pt'>Task name must not be blank.</font> </p>";
    }
}