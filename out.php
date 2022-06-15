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

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>退会確認</title>
  <link rel="stylesheet" type="text/css" href="out.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

  <form action="./out2.php" method="post" name="form">

    <div class="form1">

    <div class="text1">
    <p>退会してもよろしいでしょうか？</p>
    </div>

    <div class="form2">

    <div class="form3">

    <div class="button7">
    <input type="button" onclick=history.back() class="button5" value="戻 る">

    <input type="submit" class="button6" value="退 会">
    </div>

    </div>

    </div>

    </div>

  </form>

</body>
