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
$reservation_id = $_REQUEST["rs_id"];

require_once("../../../MYDB.php");
$pdo = db_connect();
  try{
  $pdo->beginTransaction();   
  $sql = " delete from phptest.studio_reservation where rs_id = ?"; //추후에 update 문으로 수정할것. 서버에서 delete는 사용하지 않는다.
  $stmh = $pdo->prepare($sql); 
  $stmh->bindValue(1, $reservation_id, PDO::PARAM_INT);  
  $stmh->execute();
  $pdo->commit(); 
 
  header("Location:./list.php");
  } catch (PDOException $Exception) {
       $pdo->rollBack();
     print "오류: ".$Exception->getMessage();
  }
?>
