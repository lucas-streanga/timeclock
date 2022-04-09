<?php @session_start();
include "include/db_connect.php";
include "include/error_reporting.php";
include "include/report_gen.php";
include "include/navbar.html";
include "include/create_task.html";
include "include/check_login.php";
include "include/delete_task.php";

check_login_or_redirect();
$userid = $_SESSION["userid"];

$conn = db_connect("test");

delete_task_form($conn, $userid);

if(isset($_POST['submit'])){

if(!$conn)
{
    die("Connection to database failed!");
}
else
{
    $taskName = filter_input(INPUT_POST, 'task_entered');
    if($taskName != "")
    {
        $query = $conn->prepare("SELECT * FROM task WHERE name=:taskName AND userid=:userid");
        $query -> bindParam(":taskName", $taskName);
        $query -> bindParam(":userid", $userid);
        $query -> execute();
        $rows = $query -> fetchall(PDO::FETCH_ASSOC);

        if(count($rows) == 0)
        {
            $query = $conn->prepare("INSERT INTO task(name, userid) VALUES (:taskName, :userid);");
            $query -> bindParam(":taskName", $taskName);
            $query -> bindParam(":userid", $userid);
            $success = true;
            $rows = null;
            try
            {
                $query -> execute();
                $query = $conn -> prepare("SELECT * from task WHERE name=:taskName AND userid=:userid");
                $query -> bindParam(":taskName", $taskName);
                $query -> bindParam(":userid", $userid);
                $query -> execute();
                $rows = $query -> fetchall(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
                echo "<p> <font color=red size='4pt'>Unable to create task: </font>". "<br>". $e->getMessage(). "</p>";
				$success = false;
            }

            if($success)
            	echo "<p> <font color=green size='4pt'>". 'Success! Created task with name "'.$taskName. '"</b>.'. " <a href='timeclock.php'>Back</a></font> </p>";
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

}
?>
