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

  $sql = "SELECT * FROM managers WHERE id=?";
  $statement =$dbh->prepare($sql);
  $statement ->execute(array($_SESSION['id']));
  $manager = $statement->fetch();
}else{
  header('Location: index.php');
  exit();
}


$statement2 =$dbh ->prepare("DELETE FROM members WHERE id=?");
$statement2 ->execute(array($_POST["id"]));

$statement3 =$dbh ->prepare("DELETE FROM posts WHERE member_id=?");
$statement3 ->execute(array($_POST["id"]));

header('Location: ./manager_index.php');
exit();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>管理人削除</title>
  <link rel="stylesheet" type="text/css" href="">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

</body>
