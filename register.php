<!DOCTYPE html>

<?php
  include("includes/config.php");
  include("includes/classes/Account.php");
  include("includes/classes/Constants.php");

  // The $con is a global variable defined in the config.php file
  $account = new Account($con);

  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");

  function getInputValue ($name) {
    if (isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }
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
        <?php echo $account->getError(Constants::$userNameCharacters); ?>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php getInputValue('username') ?>" placeholder="e.g. John Doe" required>
      </p>

      <p>
        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
        <label for="firstName">First name</label>
        <input id="firstName" name="firstName" type="text" value="<?php getInputValue('firsName') ?>" placeholder="John" required>
      </p>

      <p>
        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
        <label for="lastName">Last name</label>
        <input id="lastName" name="lastName" type="text" value="<?php getInputValue('lastName') ?>" placeholder="Doe" required>
      </p>

      <p>
        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
        <?php echo $account->getError(Constants::$emailInvalid); ?>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?php getInputValue('email') ?>" placeholder="john@doe.com" required>
      </p>
      <p>
        <label for="email2">Confirm email</label>
        <input id="email2" name="email2" type="email" value="<?php getInputValue('email2') ?>" placeholder="john@doe.com" required>
      </p>

      <p>
        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
        <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
        <?php echo $account->getError(Constants::$passwordCharachters); ?>
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