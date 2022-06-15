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


if(!empty($_POST)){

  if(isset($_POST['message'])){
    $sql = "INSERT INTO posts SET member_id=?, message=?, reply_post_id=?, created=NOW()";
    $statement =$dbh->prepare($sql);
    $statement ->execute(array($member['id'], $_POST['message'], $_POST['reply_post_id']));

    header('Location: member_index.php');
    exit();
  }
}


if(isset($_REQUEST['page'])){
$page = $_REQUEST['page'];
}else{
  $page = 1;
}

$start = ($page -1) * 5;

$page = max($page, 1);

$counts = $dbh->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxpage = ceil($cnt['cnt'] / 5);
$page = min($page, $maxpage);



$posts = $dbh->prepare("SELECT m.nickname, m.picture, p.* FROM members m, posts p WHERE m.id = p.member_id ORDER BY p.created DESC LIMIT ?, 5");
$posts ->bindParam(1, $start, PDO::PARAM_INT);
$posts ->execute();


if(isset($_REQUEST['res'])){
  $response = $dbh->prepare("SELECT m.nickname, p.* FROM members m, posts p WHERE m.id = p.member_id AND p.id=? ORDER BY p.created DESC");
  $response ->execute(array($_REQUEST['res']));

  $table = $response->fetch();
  $message = '>@' . $table['nickname'];
}


$sql2 = "SELECT * FROM members WHERE 1";
$statement2 =$dbh->prepare($sql2);
$statement2 ->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>投稿画面_会員画面</title>
  <link rel="stylesheet" type="text/css" href="manager_index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  <script>

  </script>
</head>

<body>


<div class="wrapper">

<div class="sidearea">

<div class="user">

<img src="member_picture/<?PHP echo $manager['picture'] ?>" alt="画像" class="img1">

<div class="user2">

<P class="name"><?PHP echo $manager['name'] ?></p>

<p class="logout"><a href="logout.php">ログアウト</a></p>

</div>

</div>

</div>


<div class="mainarea">


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

  <p class="time"><?PHP echo $post['created'] ?>

    [<a href="delete.php?id=<?php echo $post['id']; ?>" style="color:#F33;">削除</a>]

  </p>

  </div>


  </div>

  </div>

  <?PHP endforeach; ?>

</div>

<div class="paging">
  <?PHP
  if($page > 1){
  ?>
  <p><a href="manager_index.php?page=<?PHP print($page - 1); ?>">前のページへ</a></p>
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
  <p><a href="manager_index.php?page=<?PHP print($page + 1); ?>">次のページへ</a></p>
  <?php
  }else{
  ?>
  <p>次のページへ</p>
  <?php
  }
  ?>
</div>


<p>アカウントリスト</p>

<table class ="table">

<tr>
  <th>id</th>
  <th>氏名</th>
  <th>ニックネーム</th>
  <th>メールアドレス</th>
  <th></th>
  <th></th>
<tr>

<?php
while($member2 = $statement2->fetch()){
 ?>

<tr>
  <td><?php echo $member2["id"]?></td>
  <td><?php echo $member2["name"]?></td>
  <td><?php echo $member2["nickname"]?></td>
  <td><?php echo $member2["email"]?></td>
  <td>
    <form action="./manager_update.php" method="post">
    <input type=submit value=編集>
    <input type="hidden" name="id" value= <?php echo $member2["id"]?>>
    </form>
  </td>
  <td>
    <form action="./manager_out.php" method="post">
    <input type=submit class=button30 value=削除>
    <input type="hidden" name="id" value= <?php echo $member2["id"]?>>
    </form>
  </td>
</tr>

<?php
}
 ?>


</table>


</body>
