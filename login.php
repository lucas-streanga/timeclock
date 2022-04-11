<?php @session_start();?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <title>Login to Timeclock</title>
  <link rel='stylesheet' href='css/form_style.css'>
  <meta charset="UTF-8">
</head>
<body>
<div id="login-form-wrap">
  <?php
  include "include/navbar.html";
  if (@isset($_SESSION['login_fail'])): ?>
    <div class="form-errors">
        <p> <font color=red size='4pt'>Invalid Username or User ID</font> </p>
    </div>
  <?php endif; ?>
  <form action="loginhandler.php" method="post"><fieldset>
  <legend align="center" style="font-size:24px">Login to Timeclock</legend>
    <p>
    <input type="text" id="username" name="username" placeholder="Username" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="text" id="userid" name="userid" placeholder="User ID" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
	<div align="center">
    	<input type="submit" id="login" value="Login">
	</div>
    </p>
  </form></fieldset>
  <div id="create-account-wrap">
    <p>No Account? <a href="create_account.php">Create Account</a><p>
  </div>
</div>
  
</body>
</html>
