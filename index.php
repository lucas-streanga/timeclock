<?php @session_start(); ?>
<!DOCTYPE html><html><head><title>Home</title></head>
<?php
include "include/navbar.html";
include "include/check_login.php";
check_login_or_redirect();
?>

<div align="center">
	<h1>Welcome to Timeclock!</h1>
</div>

</html>
