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


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>投稿画面_会員画面</title>
  <link rel="stylesheet" type="text/css" href="member_index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>

  $(function(){

   $(".send").on("click", function(event){
     let $_parent = $( this ).closest( '.send' );
     $.ajax({
       type: "POST",
       url: "ajax.php",
       data: { "p_id" : $_parent.find("input[name=p_id]").val(),
               "m_id" : $_parent.find("input[name=m_id]").val() }
     }).done(function(data){

       $(".send").toggleClass("non");
       $(".send").toggleClass("active");
       window.location.reload("time");

     }).fail(function(XMLHttpRequest, status, e){
       alert(e);
       });
     });
 });

  </script>
</head>

<body>


<div class="wrapper">

<div class="sidearea">

<div class="user">

<img src="member_picture/<?PHP echo $member['picture'] ?>" alt="画像" class="img1">

<div class="user2">

<P class="nickname"><?PHP echo $member['nickname'] ?></p>

<p class="change"><a href="member_update.php">ユーザー情報変更</a></p>

<p class="logout"><a href="logout.php">ログアウト</a></p>

<p class="out"><a href="out.php">退会</a></p>

</div>

</div>

</div>


<div class="mainarea">

  <form action="" method="post" name="form">

    <div class="form1">

    <div class="form2">

    <h2>メッセージを入力して下さい</h2>

    <textarea class="text2" name="message" ><?php if(isset($message)){ echo $message; } ?></textarea>
    <input type="hidden" name="reply_post_id" value=<?php if(isset($_REQUEST['res'])){ echo $_REQUEST['res']; unset($_REQUEST['res']); } ?>>

    <div class="form3">

    <input type="submit" class="button1" value="投稿">

    </div>

    </div>

    </div>

  </form>

<?php foreach($posts as $post): ?>

<div class="message1">

  <div class="message2">

  <img src="member_picture/<?PHP echo $post['picture'] ?>" alt="画像" class="img2">

  <div class="message3">

  <div class="message4">

  <P class="nickname2"><?PHP echo $post['nickname'] ?></p>

    <?php if($_SESSION['id'] !== $post['member_id']): ?>

  <p class="reply">[<a href="member_index.php?res=<?php echo $post['id']; ?>" style="color:#0c4da2;">Re</a>]</p>


  <button class="send
  <?php
  $sql = "SELECT * FROM good WHERE post_id=? AND member_id =? ";
  $statement =$dbh->prepare($sql);
  $statement ->execute(array($post['id'], $_SESSION['id']));
  $good = $statement->fetch();

  if(!empty($good)){ echo "active";}else{ echo "non";}

  ?>
  ">
  <input type="hidden" name="p_id" value="<?PHP echo $post['id'] ?>" />
  <input type="hidden" name="m_id" value="<?PHP echo $_SESSION['id'] ?>" />
  いいね！</button>


    <?php endif; ?>



  </div>


  <P class="message"><?PHP echo $post['message'] ?></p>

  <div class="message5">

  <p1 class="time"><?PHP echo $post['created'] ?>
  <?php if($_SESSION['id'] == $post['member_id']): ?>
    [<a href="delete.php?id=<?php echo $post['id']; ?>" style="color:#F33;">削除</a>]
  <?php endif; ?>
  </p1>

  </div>


  </div>

  </div>

  <?PHP endforeach; ?>

</div>

<div class="paging">
  <?PHP
  if($page > 1){
  ?>
  <p><a href="member_index.php?page=<?PHP print($page - 1); ?>">前のページへ</a></p>
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
  <p><a href="member_index.php?page=<?PHP print($page + 1); ?>">次のページへ</a></p>
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


</html>
