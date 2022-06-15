<?php
session_start();

if(!isset($_SESSION['flg']) && $_SESSION['flg'] !== "join"){
  header("Location: ./index.php");
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>登録画面_入力画面</title>
  <link rel="stylesheet" type="text/css" href="join_index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>

  <form action="./join_check.php" method="post" enctype="multipart/form-data" name="form">

    <div class="form1">

    <div class="text1">

    <h1>会員登録</h1>

    </div>

    <div class="form2">

    <h2>下記項目にご記入の上確認ボタンを押してください</h2>

    <div class="text2">

    <p><span>*</span>は必須項目となります。</p>

    </div>


    <label class="label1">氏名<span>*</span></label>

    <span><?php if(isset($_SESSION["error1"])){echo $_SESSION["error1"];unset($_SESSION["error1"]);}?></span>

    <input type="text" class="text3" name="name" value ="<?php if(isset($_SESSION["name"])){echo $_SESSION["name"];} ?>">

    <label class="label2">ニックネーム<span>*</span></label>

    <span><?php if(isset($_SESSION["error2"])){echo $_SESSION["error2"];unset($_SESSION["error2"]);}?></span>

    <input type="text" class="text4" name="nickname" value ="<?php if(isset($_SESSION["nickname"])){echo $_SESSION["nickname"];} ?>">

    <label class="label3">メールアドレス<span>*</span></label>

    <span><?php if(isset($_SESSION["error3"])){echo $_SESSION["error3"];unset($_SESSION["error3"]);}?></span>
    <span><?php if(isset($_SESSION["error4"])){echo $_SESSION["error4"];unset($_SESSION["error4"]);}?></span>
    <span><?php if(isset($_SESSION["error7"])){echo $_SESSION["error7"];unset($_SESSION["error7"]);}?></span>

    <input type="email" class="text5" name="email" value ="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];} ?>">

    <label class="label4">パスワード<span>*</span></label>

    <span><?php if(isset($_SESSION["error5"])){echo $_SESSION["error5"];unset($_SESSION["error5"]);}?></span>

    <input type="password" class="text6" name="password" value ="<?php if(isset($_SESSION["password"])){echo $_SESSION["password"];} ?>">

    <label class="label5">アイコン<span>*</span></label>

    <span><?php if(isset($_SESSION["error6"])){echo $_SESSION["error6"];unset($_SESSION["error6"]);}?></span>

    <input type="file" class="image" name="image">

    <div class="form3">

    <input type="button" onclick=history.back() class="button6" value="戻 る">

    <input type="submit" class="button5" value="入力内容を確認">

    </div>

    </div>

    </div>

  </form>

</body>
