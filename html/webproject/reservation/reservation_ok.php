<?php session_start(); ?>
<meta charset="utf-8">
<?php
   if(!isset($_SESSION["userid"])) {
?>
  <script>
       alert('로그인 후 이용해 주세요.');
history.back();
   </script>
<?php
      }

require_once("../../../MYDB.php");
$pdo = db_connect();
  try{
  $pdo->beginTransaction();   
  $sql = " insert into phptest.studio_reservation(user_id, studio_id, rs_date, tot_cnt, register_date)"; 
  $sql.= "values(?, ?, ?, ?, now())"; 
  $stmh = $pdo->prepare($sql); 
  $stmh->bindValue(1, $_SESSION["userid"], PDO::PARAM_STR);  
  $stmh->bindValue(2, $_POST["insert_houseid"], PDO::PARAM_STR);   
  $stmh->bindValue(3, $_POST["reservation_date"], PDO::PARAM_STR);
  $stmh->bindValue(4, $_POST["total_man"], PDO::PARAM_STR);
  $stmh->execute();
  $pdo->commit(); 
 
  header("Location:./list.php");
  } catch (PDOException $Exception) {
       $pdo->rollBack();
     print "오류: ".$Exception->getMessage();
  }
?>
