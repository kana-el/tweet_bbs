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

if(!empty($_POST)){

  if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $sql = "SELECT * FROM members WHERE email=? AND password=?";
    $statement =$dbh->prepare($sql);
    $statement ->execute(array($email, $password));
    $member = $statement->fetch();

    $sql2 = "SELECT * FROM managers WHERE email=? AND password=?";
    $statement2 =$dbh->prepare($sql2);
    $statement2 ->execute(array($email, $password));
    $manager = $statement2->fetch();


    if($member['authority'] == 2){
      $_SESSION['id'] = $member['id'];
      header('Location: member_index.php');
      exit();
    }elseif($manager['authority'] == 1){
      $_SESSION['id'] = $manager['id'];
      header('Location: manager_index.php');
      exit();
    }else{
      session_destroy();
      header('Location: index.php');
      exit();
    }

   }else{
     session_destroy();
     header('Location: index.php');
     exit();
   }

 }


  ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" type="text/css" href="">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>


</body>
