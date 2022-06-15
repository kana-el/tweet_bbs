<?php
session_start();

$db = "mysql:dbname=bbs;host=localhost";
$user = "root";
$password2 = "knm06978";

try{
  $dbh = new PDO($db, $user, $password2);
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

$statement2 =$dbh ->prepare("DELETE FROM members WHERE id=?");
$statement2 ->execute(array($_SESSION["id"]));

$statement3 =$dbh ->prepare("DELETE FROM posts WHERE member_id=?");
$statement3 ->execute(array($_SESSION["id"]));

session_destroy();
header('Location: index.php');
exit();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>退会</title>
  <link rel="stylesheet" type="text/css" href="">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

</body>
