<?php @session_start();?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
</head>
<body>
<div id="login-form-wrap">
  <h2>Login to TimeClock</h2>
  <?php
  if (@isset($_SESSION['login_fail'])): ?>
    <div class="form-errors">
        <p> <font color=red size='4pt'>Invalid Username or User ID</font> </p>
    </div>
  <?php endif; ?>
  <form action="loginhandler.php" method="post">
    <p>
    <input type="text" id="username" name="username" placeholder="Username" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="text" id="userid" name="userid" placeholder="User ID" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
    <input type="submit" id="login" value="Login">
    </p>
  </form>
  <div id="create-account-wrap">
    <p>No Account? <a href="create_account.php">Create Account</a><p>
  </div>
</div>
  
</body>
</html>