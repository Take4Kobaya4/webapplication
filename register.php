<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

if (isset($_POST['submitButton'])) {
  // submitButtonというPOSTの値が取れた時のそれぞれの値
  $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
  $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
  $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

  $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);


  if ($success) {
    $_SESSION["userLoggedIn"] = $username;
    header("Location: index.php");
  }
}

function getInputValue($name)
{
  if (isset($_POST[$name])) {
    echo $_POST[$name];
  }
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
  <link rel="stylesheet" href="/reecefix/style/style.css" type="text/css">
</head>

<body>
  <div class="signContainer">

    <div class="column">

      <div class="header">
        <h3>新規登録</h3>
      </div>
      <!-- 登録用フォーム methodはPOSTを利用。 -->
      <form action="" method="POST">

        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
        <input type="text" name="firstName" placeholder="First name" value="<?php getInputValue("firstName"); ?>" required>

        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
        <input type="text" name="lastName" placeholder="Last name" value="<?php getInputValue("lastName"); ?>" required>

        <?php echo $account->getError(Constants::$usernameCharacters); ?>
        <?php echo $account->getError(Constants::$usernameTaken); ?>
        <input type="text" name="username" placeholder="User name" value="<?php getInputValue("username"); ?>" required>

        <?php echo $account->getError(Constants::$emailsDontMatch); ?>
        <?php echo $account->getError(Constants::$emailInvalid); ?>
        <?php echo $account->getError(Constants::$emailTaken); ?>
        <input type="email" name="email" placeholder="Email Address" value="<?php getInputValue("email"); ?>" required>

        <input type="email" name="email2" placeholder="confirm email" value="<?php getInputValue("email2"); ?>" required>

        <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
        <?php echo $account->getError(Constants::$passwordLength); ?>
        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="password2" placeholder="Confirm Password" required>

        <input type="submit" name="submitButton" value="登録">

      </form>

      <a href="login.php" class="signInMessage">既にアカウントはお持ちですか？ログインはこちらへ！</a>
    </div>
  </div>
</body>

</html>
