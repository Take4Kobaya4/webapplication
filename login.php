<?php

require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

if (isset($_POST['submitButton'])) {
  // submitButtonというPOSTの値が取れた時のそれぞれの値
  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

  $success = $account->login($username, $password);


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
  <title>ログイン</title>
  <link rel="stylesheet" href="/reecefix/style/style.css" type="text/css">
</head>

<body>
  <div class="signContainer">

    <div class="column">

      <div class="header">
        <h3>ログイン</h3>
      </div>
      <!-- 登録用フォーム methodはPOSTを利用。 ログインはユーザー名とPWの入力を求めるように実施-->
      <form action="" method="POST">

        <?php echo $account->getError(Constants::$loginFailed); ?>
        <input type="text" name="username" placeholder="User name" value="<?php getInputValue("username"); ?>" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" name="submitButton" value="ログイン">

      </form>

      <a href="register.php" class="signInMessage">アカウントはお持ちですか？ お持ちでない場合は、こちらへ！</a>
    </div>
  </div>
</body>

</html>
