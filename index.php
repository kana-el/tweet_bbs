<?php
session_start();

$_SESSION['flg']= "join";

$db = "mysql:dbname=bbs;host=localhost";
$user = "root";
$password2 = "knm06978";

try{
  $dbh = new PDO($db, $user, $password2);
}catch (PDOEXception $e){
  echo "接続エラー".$e->getmessage();
}


if(isset($_REQUEST['page'])){
$page = $_REQUEST['page'];
}else{
  $page = 1;
}

$start = ($page-1) * 5;

$page = max($page, 1);

$counts = $dbh->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxpage = ceil($cnt['cnt'] / 5);
$page = min($page, $maxpage);



$posts = $dbh->prepare("SELECT m.nickname, m.picture, p.* FROM members m, posts p WHERE m.id = p.member_id ORDER BY p.created DESC LIMIT ?, 5");
$posts ->bindParam(1, $start, PDO::PARAM_INT);
$posts ->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ホーム画面</title>
  <link rel="stylesheet" type="text/css" href="index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>


<div class="wrapper">

<div class="sidearea">

<div class="form1">

<form action="./login.php" method="POST" name="form">

<div class="form2">

<label class="label1">メールアドレス</label>

  <input type="email" class="email" name="email">

<label class="label2">パスワード</label>

  <input type="password" class="password" name="password">

<input type="submit" class="button1" value="ログイン">

</div>

</form>

<p class="entry"><a href="join_index.php">アカウント登録はこちら</a></p>

</div>



</div>


<div class="mainarea">

  <form action="" method="post" name="form">

    <div class="form_1">

    <div class="form_2">

    <h2>メッセージ</h2>

    </div>

    </div>

  </form>

<?php
 foreach($posts as $post):
 ?>

<div class="message1">

  <div class="message2">

  <img src="member_picture/<?PHP echo $post['picture'] ?>" alt="画像" class="img2">

  <div class="message3">

  <div class="message4">

  <P class="nickname2"><?PHP echo $post['nickname'] ?></p>

  </div>

  <P class="message"><?PHP echo $post['message'] ?></p>

  <div class="message5">

  <p class="time"><?PHP echo $post['created'] ?></p>

  </div>

  </div>

  </div>

  <?PHP endforeach; ?>

</div>

<div class="paging">
  <?PHP
  if($page > 1){
  ?>
  <p><a href="index.php?page=<?PHP print($page - 1); ?>">前のページへ</a></p>
  <?php
  }else{
  ?>
  <p>前のページへ</p>
  <?php
  }
  ?>
  <?PHP
  if($page < $maxpage){
  ?>
  <p><a href="index.php?page=<?PHP print($page + 1); ?>">次のページへ</a></p>
  <?php
  }else{
  ?>
  <p>次のページへ</p>
  <?php
  }
  ?>
</div>

</div>

</div>


</body>
