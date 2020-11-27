<?php 
  session_start();

  $id = $_REQUEST["id"];
  $status = $_REQUEST["status"];

  if($status == 'y') {
    $status = 'n';
  } else {
    $status = 'y';
  }
  
  echo "id : ".$id. " status : ". $status;
  require_once("../../../MYDB.php");//경로 : /usr/local/apache2.4/MYDB.php
  $pdo = db_connect();

  try {
    $pdo->beginTransaction();
    $sql = "update phptest.member set status = ? where id = ?";
    $stmh = $pdo -> prepare($sql);
    $stmh->bindValue(1,$status,PDO::PARAM_STR);
    $stmh->bindValue(2,$id,PDO::PARAM_STR);
    $stmh->execute();
    $pdo->commit();
      
  }catch (PDOException $Exception) {
    print "오류: ".$Exception->getMessage();
  }

    header("Location:admin.php");
    exit;

?>