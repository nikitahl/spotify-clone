<!DOCTYPE html>

<?php
  include("includes/classes/Account.php");

  $account = new Account();

  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register page!</title>
</head>
<body>
  <div id="inputContainer">
    <!-- action is what page we're going to send the data to (in this case the current page) -->
    <form action="register.php" method="POST" id="loginForm">
      <h2>Login to your account</h2>
      <p>
        <label for="loginUsername">Username</label>
        <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. John Doe" required>
      </p>
      <p>
        <label for="loginPassword">Password</label>
        <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
      </p>
      <button type="submit" name="loginButton">Log in</button>
    </form>

    <form action="register.php" method="POST" id="registerForm">
      <h2>Create your free account</h2>
      <p>
        <?php echo $account->getError("Your username must be between 5 and 25 characters"); ?>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="e.g. John Doe" required>
      </p>

      <p>
        <?php echo $account->getError("Your first name must be between 2 and 25 characters"); ?>
        <label for="firstName">First name</label>
        <input id="firstName" name="firstName" type="text" placeholder="John" required>
      </p>

      <p>
        <?php echo $account->getError("Your last name must be between 2 and 25 characters"); ?>
        <label for="lastName">Last name</label>
        <input id="lastName" name="lastName" type="text" placeholder="Doe" required>
      </p>

      <p>
        <?php echo $account->getError("Your emais don't match"); ?>
        <?php echo $account->getError("Email is invalid"); ?>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="john@doe.com" required>
      </p>
      <p>
        <label for="email2">Confirm email</label>
        <input id="email2" name="email2" type="email" placeholder="john@doe.com" required>
      </p>

      <p>
        <?php echo $account->getError("Your passwords don't match"); ?>
        <?php echo $account->getError("Your password can only contain numbers and letters"); ?>
        <?php echo $account->getError("Your password must be between 5 and 30 characters"); ?>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="Your password" required>
      </p>
      <p>
        <label for="password2">Confirm password</label>
        <input id="password2" name="password2" type="password" placeholder="Your password" required>
      </p>
      <button type="submit" name="registerButton">Sign in</button>
    </form>
  </div>
</body>
</html>