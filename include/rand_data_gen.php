<?php

// This file picks 2-5 users, generates 10 - 25 tasks for each user, generates 10 - 25 working-periods for each task, and then inserts these
// into the database in between the years passed as parameters

$usernames_list = array(
	"Adams", "Baker", "Clark", "Davis", "Evans", "Frank", "Ghosh", "Hills", "Irwin", "Jones",
	"Klein", "Lopez", "Mason", "Nalty", "Ochoa", "Patel", "Quinn", "Reily", "Smith", "Trott", 
	"Usman", "Valdo", "White", "Xiang", "Yakub", "Zafar", "Sneezy", "Sleepy", "Dopey", "Doc",
	"Happy", "Bashful", "Grumpy", "Mufasa", "Sarabi", "Simba", "Nala", "Kiara", "Kovu", "Timon",
	"Pumbaa", "Rafiki", "Shenzi" 
);

$taskname_list = array(
	"Direct a Play",  "Become a Bartender",  "Join the Air Force",  "Get Nominated For an Award",
	"Become a Lawyer",  "Become a Psychotherapist",  "Get my Own Wikipedia Page",  "Work As a Teacher",
	"Work For a Nonprofit",  "Become an Entrepreneur",  "Have a Seat in Government",  "Become a Politician",
	"Become a Stamp Collector",  "Become a Sommelier",  "Become a Billionaire",  "Become a Good Horse Trainer",
	"Have my Name on Wikipedia",  "Become a Supermodel",  "Incorporate a Business",  "Make a $5,000 Profit in One Day",  
	"Apply to Be a Flight Attendant",  "Earn Over 100K a Year",  "Become a Famous Business Women",
	"Work on a Crew For a Hot Air Balloon",  "Become a Professor",  "Become a Nurse in the Army",  "Obtain a Patent",
	"Become an Interior Designer",  "Have my Paintings Exhibited in a Gallery",  "Work As a Computer Animator",  "Become a Youth Sports Coach",
	"Earn Over 50K a Year",  "Become a Photographer",  "Become a United Nations Interpreter",  "Become a Sage",
	"Work at a Daycare",  "Have a Profitable Online Business",  "Open a Swiss Bank Account",  "Do Something I Love For a Living",
	"Become a Journalist",  "Work For a Culinary Magazine",  "Become an Art Collector",  "Work As a Counselor",
	"Become a Wine Connoisseur",  "Get 1St Rank of my Primary Keyword",  "Become a Dual Citizen",  "Start a New Profession",
	"Be my Own Boss",  "Become a Professional Dancer",  "Become Mayor of my City",  "Get a Job As a Teaching Assistant",
	"Become a World Renowned Artist",  "Become a Dancer",  "Become an Attorney",  "Become a Stand-Up Comedian",
	"Get a Teaching Job in a Foreign Country",  "Open a Restaurant",  "Direct my First Feature Film Before I'M 25",  "Become an Investigator",
	"Become a Paramedic",  "Work As an Art Director",  "Become a Freelance Writer",  "Work For a Feminist Organization",
	"Become a Registered Scientist",  "Become a Corporal in the Marine Corps",  "Join the Peace Corps",  "Start a Successful Restaurant",
	"Become a Runway Model",  "Become a Model",  "Get an Internationally-Known Award",  "Figure Out a Career",
	"Have my Own Boutique",  "Become a Millionaire",  "Be Recognized As an Authority my Field",  "Work on a Vineyard",
	"Direct a Movie",  "Find a Dream Job",  "Work As a Researcher",  "Become a Professional Athlete",
	"Work at a Publishing Company",  "Have my Own Clothing Line",  "Work in Healthcare",  "Manage a Nightclub",
	"Work With Zoo Animals",  "Make at Least $1000 a Month from the Internet",  "Create a Profitable Business",  "Earn a Million Dollars By Myself",
	"Become a Councilor at a Summer Camp in America",  "Become a Ballet Dancer",  "Earn Pocket Money",  "Become a Reiki Master",
	"Ask For a Pay Raise",  "Become an Expert Scuba-Diver",  "Work As a Tour Manager",  "Organize a Conference",
	"Become an Achieved Baker",  "Do Engineering Design Work on Ducati Motorcycles",  "Become a Landlord",  "Become a Voice Actor",
	"Open an Antique Shop", "Have a Job That Travels ", "Organize a Conference ", "Become a Life Coach ", "Open a Bakery ",
	"Become a Sailboat Captain ", "Become a Professional Cook ", "Work in Healthcare ", "Get a Job As a Teaching Assistant ",
	"Become an Expert Scuba-Diver ", "Work at the Playboy Mansion ", "Have my Name on Wikipedia ", "Become a Ballet Dancer ",
	"Become a Corporal in the Marine Corps ", "Work at a Publishing Company ", "Become a Doctor ", "Join the Air Force ",
	"Have a Seat in Government ", "Become a Psychologist ", "Work at a Football Club ", "Become a Good Horse Trainer ",
	"Become a Certified Personal Trainer ", "Register As a Psychologist ", "Have my Own Clothing Line ", "Become a World Renowned Artist ",
	"Open a Gourmet Café ", "Work at a Daycare ", "Become a Farmer ", "Do Engineering Design Work on Ducati Motorcycles ",
	"Become a Yoga Instructor ", "Be my Own Boss ", "Become a Wine Connoisseur ", "Become a Zen Master ",
	"Obtain a Patent ", "Become a Translator ", "Become a Journalist ", "Become a Stamp Collector ",
	"Open a Haunted Attraction ", "Become a Wild Life Photographer ", "Become a Priest ", "Become a Lifeguard ",
	"Earn Over 50K a Year ", "Get Elected Into Parliament ", "Become a Millionaire ", "Become a Philanthropist ",
	"Open an Antique Shop ", "Work on a Vineyard ", "Become a Landlord ", "Get a Teaching Job in a Foreign Country ",
	"Become an Investigator ", "Get a Job That I Love ", "Have a Profitable Online Business ", "Become a Very Successful Lawyer ",
	"Become a Military Police Officer ", "Work As a Computer Animator ", "Become a Film Maker ", "Make at Least $1000 a Month from the Internet ",
	"Work in a Zoo ", "Have my Own Boutique ", "Become a Model ", "Be Elected to Political Office ",
	"Get Employed at Pixar ", "Become a Legend ", "Become an Interior Designer ", "Get a Job As a Tour Guide ",
	"Become a Dentist ", "Work As a Ski Instructor ", "Become a Yoga Master ", "Become an NLP Master Practitioner ",
	"Become a Recognized Economist ", "Become a Good Kick Boxer ", "Work in a Bar ", "Have my Paintings Exhibited in a Gallery ",
	"Incorporate a Business ", "Get a Photo Published in Magazine ", "Become a Senator ", "Become a Personal Trainer ",
	"Become a Memory Artist ", "Become a Councilor at a Summer Camp in America ", "Open my Own Accounting Office ", "Launch my Own T-Shirt Clothing Line ",
	"Enjoy my Career ", "Become a Programmer ", "Become a Psychotherapist ", "Become a Qualified Scuba Diver ",
	"Become a Dual Citizen ", "Become a Registered Organ Donor ", "Work As a Tour Manager ", "Become an Author a Successful Blog ",
	"Earn 100K a Year ", "Land a Job in Voice Over ", "Become a Geologist ", "Ask For a Pay Raise ",
	"Become a Certified Sky Diver ", "Join the Peace Corps ", "Become an Attorney ", "Work With Zoo Animals ",
	"Start a New Profession ", "Work For a Nonprofit ", "Work For a Magazine ", "Direct a Movie"
);

$usermap = array();

///Chooses 2-5 unique usernames from $usernames_list
$username_gen = function (){
	$amt = rand(2, 5);
	$return_array = array();
	for($i = 0; $i < $amt; i++)
	{
		$rand = rand(count($usernames_list));
		array_push($return_array, $usernames_list[$randnum]);
		array_splice($usernames_list, $randnum, 1);
	}

	return $return_array;
};

///Chooses 10-25 unique tasks from $taskname_list
$taskname_gen = function (){
	$amt = rand(10, 25);
	$return_array = array();
	for($i = 0; $i < $amt; i++)
	{
		$rand = rand(count($taskname_list));
		array_push($return_array, $taskname_list[$randnum]);
		array_splice($taskname_list, $randnum, 1);
	}

	return $return_array;
};

$user_create = function($username){
	$query = $conn->prepare("SELECT * FROM account WHERE username=:username");
	$query->bindParam(':username', $username);
	$query->execute();
	$rows = $query->fetchall();

    if(count($rows) == 0)
    {
       	//Perfect, no account with this username  so we will create it!
		$query = $conn->prepare("INSERT INTO account VALUES (:username, NULL);");
		$query->bindParam(':username', $username);
		$success = true;
		$rows = null;
		try
		{
			$query->execute(); 
			$query = $conn->prepare("SELECT id from account WHERE username=:username;");
			$query->bindParam(':username', $username);
			$query->execute();
			$rows = $query->fetchall(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) 
		{
			echo "<p> <font color=red size='4pt'>Unable to create account: </font>". "<br>". $e->getMessage(). "</p>";
			$success = false;
    	}
		$id = $rows[0]["id"];
		
		if($success)
		{
			echo "<p> <font color=green size='4pt'>". 'Success! Created account with username "'. $username. '" with user ID <b>'. $id. '</b>.'. " </font> </p>";
			array_push($usermap, $id => $username);
		}
	}
	else
	{
		//Uh oh, account already exists!
       	echo "<p> <font color=red size='4pt'>". "Account with username ". $username. " already exists!". "</font> </p>";
	}
};

$task_create = function($userid, $taskname){
	$query = $conn->prepare("SELECT * FROM task WHERE name=:taskName AND userid=:userid");
	$query -> bindParam(":taskName", $taskname);
	$query -> bindParam(":userid", $userid);
	$query -> execute();
	$rows = $query -> fetchall(PDO::FETCH_ASSOC);
	
	if(count($rows) == 0)
	{
	    $query = $conn->prepare("INSERT INTO task(name, userid) VALUES (:taskName, :userid);");
	    $query -> bindParam(":taskName", $taskname);
	    $query -> bindParam(":userid", $userid);
	    $success = true;
	    $rows = null;
	    try
	    {
	        $query -> execute();
	        $query = $conn -> prepare("SELECT * from task WHERE name=:taskName AND userid=:userid");
	        $query -> bindParam(":taskName", $taskname);
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
	    	echo "<p> <font color=green size='4pt'>". 'Success! Created task with name "'.$taskname. '"</b>.'. " </font></p>";
	}
	else
	{
	    echo "<p> <font color=red size='4pt'>". "Task with name ". $taskname. " already exists!". "</font> </p>";
	}
}

// If you wish for this generator to run, include it in a page, 
// and then create two variables before the include statement called $start_date and $end_date
// make sure both are datetime objects, when you've navigated to the page you used this on, 
// don't refresh the page or re-navigate to it without removing them, or you'll
if(isset($start_date) && isset($end_date))
{
	//get the day differential between $start_date and $end date
	$diff = $end_date:sub()
}
?>