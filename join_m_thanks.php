<?php
session_start();

  if(!isset($_SESSION['flg']) && $_SESSION['flg'] !== "join_m"){
    header("Location: ./ndex.php");
    exit();
  }

  $db = "mysql:dbname=bbs;host=localhost";
  $user = "root";
  $password = "knm06978";

  try{
    $dbh = new PDO($db, $user, $password);
  }catch (PDOEXception $e){
    echo "接続エラー".$e->getmessage();
  }

  $name = $_SESSION['join']["name"];
  $email =$_SESSION['join']["email"];
  $password = sha1($_SESSION['join']["password"]);
  $image = $_SESSION['join']["image"];

  $sql = "INSERT INTO managers SET name=?, email=?, password=?, picture=?, created=NOW()";
  $statement =$dbh ->prepare($sql);
  $statement ->execute(array($name, $email, $password, $image ));

  session_destroy();
  header("Location: ./index.php");
  exit();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>管理者登録画面_完了画面</title>
  <link rel="stylesheet" type="text/css" href="join_thanks.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

<?PHP
  Print_r($_SESSION);

  ?>


</body>
