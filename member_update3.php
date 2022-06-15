<?php
session_start();

$db = "mysql:dbname=bbs;host=localhost";
$user = "root";
$password = "knm06978";

try{
  $dbh = new PDO($db, $user, $password);
}catch (PDOEXception $e){
  echo "接続エラー".$e->getmessage();
}


if(isset($_SESSION['id'])){
  $sql = "SELECT * FROM members WHERE id=?";
  $statement =$dbh->prepare($sql);
  $statement ->execute(array($_SESSION['id']));
  $member = $statement->fetch();
}else{
  header('Location: index.php');
  exit();
}

$statement2 =$dbh ->prepare("UPDATE members SET name=?, nickname=?, email=? WHERE id=?");
$statement2 ->execute(array($_SESSION['name'], $_SESSION['nickname'], $_SESSION['email'], $_SESSION['id']));

  header("Location: ./member_index.php");
  exit();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>情報変更_完了画面</title>
  <link rel="stylesheet" type="text/css" href="">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

</body>
