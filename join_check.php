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


if(!isset($_SESSION['flg']) && $_SESSION['flg'] !== "join"){
  header("Location: ./index.php");
  exit();
}

$_SESSION['flg']= "join";

$name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
$nickname = htmlspecialchars($_POST["nickname"], ENT_QUOTES, "UTF-8");
$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
$password = htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8");


if($name == ""){
  $_SESSION["error1"] = "氏名は必須入力です。";
  header("Location: ./joim_index.php");
}

if($nickname == ""){
  $_SESSION["error2"] = "ニックネームは必須入力です。";
  header("Location: ./join_index.php");
}

if($email == ""){
  $_SESSION["error3"] = "メールアドレスは必須入力です。";
  header("Location: ./join_index.php");
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $_SESSION["error4"] = "正しいメールアドレスを入力してください。";
  header("Location: ./join_index.php");
}

if($password == ""){
  $_SESSION["error5"] = "パスワードは必須入力です。";
  header("Location: ./join_index.php");
}


if(isset($_FILES['image'])){

$fileName = $_FILES['image']['name'];

if(!empty($fileName)){
  $ext = substr($fileName, -3);
  if($ext != 'jpg' &&  $ext != 'gif'){
    $_SESSION["error6"] = ".jpg あるいは .gif で選択してください。";
    header("Location: ./join_index.php");
   }
 }else{
   $_SESSION["error6"] = ".jpg あるいは .gif で選択してください。";
   header("Location: ./join_index.php");
 }
 }

$member = $dbh->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
$member ->execute(array($email));
$record =$member->fetch();

if($record['cnt'] > 0){
  $_SESSION["error7"] = "指定されたメールアドレスは既に登録されています。";
  header("Location: ./join_index.php");
}


if(empty($_SESSION['error6'])) {
  $image = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], 'member_picture/'.$image);
}

$_SESSION["join"] = $_POST;
$_SESSION["join"]['image'] = $_FILES['image']['name'];


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>登録画面_確認画面</title>
  <link rel="stylesheet" type="text/css" href="join_check.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

  <form action="./join_thanks.php" method="post" name="form">

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

    <div class="text5">
    <p>パスワード:<?php echo $password ?> </p>
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
