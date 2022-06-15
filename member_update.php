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
  <title>情報変更_入力画面</title>
  <link rel="stylesheet" type="text/css" href="member_update.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

  <form action="./member_update2.php" method="post" name="form">

    <div class="form1">

    <div class="text1">

    <h1>ユーザー情報変更</h1>

    </div>

    <div class="form2">

    <h2>下記項目にご記入の上確認ボタンを押してください</h2>

    <div class="text2">

    <p><span>*</span>は必須項目となります。</p>

    </div>


    <label class="label1">氏名<span>*</span></label>

    <span><?php if(isset($_SESSION["error1"])){echo $_SESSION["error1"];unset($_SESSION["error1"]);}?></span>

    <input type="text" class="text3" name="name" value ="<?php if(isset($_SESSION["name"])){echo $_SESSION["name"];}else{echo $member['name'];} ?>">

    <label class="label2">ニックネーム<span>*</span></label>

    <span><?php if(isset($_SESSION["error2"])){echo $_SESSION["error2"];unset($_SESSION["error2"]);}?></span>

    <input type="text" class="text4" name="nickname" value ="<?php if(isset($_SESSION["nickname"])){echo $_SESSION["nickname"];}else{echo $member['nickname'];} ?>">

    <label class="label3">メールアドレス<span>*</span></label>

    <span><?php if(isset($_SESSION["error3"])){echo $_SESSION["error3"];unset($_SESSION["error3"]);}?></span>
    <span><?php if(isset($_SESSION["error4"])){echo $_SESSION["error4"];unset($_SESSION["error4"]);}?></span>

    <input type="email" class="text5" name="email" value ="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];}else{echo $member['email'];} ?>">

    <div class="form3">

    <input type="button" onclick=history.back() class="button6" value="戻 る">

    <input type="submit" class="button5" value="入力内容を確認">

    </div>

    </div>

    </div>


  </form>

</body>
