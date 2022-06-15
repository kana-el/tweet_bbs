<?php
session_start();

$_SESSION = array();
if(ini_get("session.use_cookies")){
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
  $params['path'], $params['domain'],
  $params['secure'], $params['httponly']
  );
}

session_destroy();

setcookie('email', '', time() - 3600);
setcookie('password', '', time() - 3600);

header('Location: index.php');
exit();

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ログアウト</title>
  <link rel="stylesheet" type="text/css" href="">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

</body>
