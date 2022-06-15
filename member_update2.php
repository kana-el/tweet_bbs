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


$name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
$nickname = htmlspecialchars($_POST["nickname"], ENT_QUOTES, "UTF-8");
$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");


$_SESSION["name"] = $name;
$_SESSION["nickname"] = $nickname;
$_SESSION["email"] = $email;


if($name == ""){
  $_SESSION["error1"] = "氏名は必須入力です。";
  header("Location: ./member_update.php");
}

if($nickname == ""){
  $_SESSION["error2"] = "ニックネームは必須入力です。";
  header("Location: ./member_update.php");
}

if($email == ""){
  $_SESSION["error3"] = "メールアドレスは必須入力です。";
  header("Location: ./member_update.php");
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $_SESSION["error4"] = "正しいメールアドレスを入力してください。";
  header("Location: ./member_update.php");
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>情報変更_確認画面</title>
  <link rel="stylesheet" type="text/css" href="member_update2.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

  <form action="./member_update3.php" method="post" name="form">

    <div class="form1">

    <div class="text1">
    <p>入力内容はこちらでよろしいでしょうか？</p>
    </div>

    <div class="form2">

    <div class="form3">

    <div class="text2">
    <p>氏名:<?php echo $name ?> </p>
    </div>

    <div class="text3">
    <p>ニックネーム:<?php echo $nickname ?> </p>
    </div>

    <div class="text4">
    <p>メールアドレス:<?php echo $email ?> </p>
    </div>


    <div class="button7">
    <input type="button" onclick=history.back() class="button5" value="戻 る">

    <input type="submit" class="button6" value="登 録">
    </div>

    </div>

    </div>

    </div>

  </form>


</body>
