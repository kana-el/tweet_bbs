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


if(isset($_SESSION['id'])){

  $id =$_REQUEST['id'];

  $message = $dbh->prepare('SELECT * FROM posts WHERE id=?');
  $message ->execute(array($id));
  $message = $message->fetch();

  if($message['member_id'] = $_SESSION['id']){
    $delete = $dbh->prepare('DELETE FROM posts WHERE id=?');
    $delete ->execute(array($id));
  }
}

header('Location: member_index.php');
exit();

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>投稿削除</title>
  <link rel="stylesheet" type="text/css" href="">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

</body>
