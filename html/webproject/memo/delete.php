<?php
  $num=$_REQUEST["num"];
      
  require_once("../../../MYDB.php");
  $pdo = db_connect();
      
   try{
     $pdo->beginTransaction();
     $sql = "update phptest.memo set stauts = 'n', delete_day = now() where num = ?";   
     $stmh = $pdo->prepare($sql);
     $stmh->bindValue(1,$num,PDO::PARAM_STR);
     $stmh->execute();   
     $pdo->commit();

      header("Location:./memo.php");
     } catch (Exception $ex) {
              $pdo->rollBack();
              print "오류: ".$Exception->getMessage();
     }
?>