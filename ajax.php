<?php

$db = "mysql:dbname=bbs;host=localhost";
$user = "root";
$password2 = "knm06978";

try{
  $dbh = new PDO($db, $user, $password2);
}catch (PDOEXception $e){
  echo "接続エラー".$e->getmessage();
}



if(isset($_POST)){
  $p_id = $_POST['p_id'];
  $m_id = $_POST['m_id'];


  $sql = "SELECT * FROM good WHERE post_id=? AND member_id=? ";
  $statement =$dbh->prepare($sql);
  $statement ->execute(array($p_id, $m_id));
  $result = $statement->rowCount();

  if(!empty($result)){
    $sql = "DELETE FROM good WHERE post_id=? AND member_id=? ";
    $statement =$dbh->prepare($sql);
    $statement ->execute(array($p_id, $m_id));
  }else{
    $sql = "INSERT INTO good SET post_id=?, member_id=?, created_date=NOW()";
    $statement =$dbh->prepare($sql);
    $statement ->execute(array($p_id, $m_id));
  }
}

  ?>
