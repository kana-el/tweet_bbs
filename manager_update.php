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


if(isset($_POST['id'])){

  $sql = "SELECT * FROM members WHERE id=?";
  $statement =$dbh->prepare($sql);
  $statement ->execute(array($_POST['id']));
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
  <title>管理者情報変更_入力画面</title>
  <link rel="stylesheet" type="text/css" href="manager_update.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

  <form action="./manager_update2.php" method="post" name="form">

    <div class="form1">

    <div class="form2">

    <label class="label1">氏名</label>

    <input type="text" class="text3" name="name" value ="<?php if(isset($_SESSION["name"])){echo $_SESSION["name"];}else{echo $member['name'];} ?>">

    <label class="label2">ニックネーム</label>

    <input type="text" class="text4" name="nickname" value ="<?php if(isset($_SESSION["nickname"])){echo $_SESSION["nickname"];}else{echo $member['nickname'];} ?>">

    <label class="label3">メールアドレス</label>

    <input type="email" class="text5" name="email" value ="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];}else{echo $member['email'];} ?>">

    <div class="form3">

    <input type="button" onclick=history.back() class="button6" value="戻 る">

    <input type="submit" class="button5" value="変 更">
    <input type="hidden" name="id" value= <?php echo $_POST["id"]?>>

    </div>

    </div>

    </div>

  </form>

</body>
