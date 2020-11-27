<?php session_start(); ?>
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
  $sql = " SELECT rs_id AS caID, '예약됨' AS title, rs_date AS start, rs_date AS end ";
  $sql.= "FROM phptest.studio_reservation WHERE studio_id= ? ";
  $stmh = $pdo->prepare($sql); 
  $stmh->bindValue(1, $_GET["houseid"], PDO::PARAM_STR);  
  $stmh->execute(); 
	} catch (PDOException $Exception) {
	print "오류: ".$Exception->getMessage();
  }          
  $ret_arr = array(); 
  foreach($stmh as $row)
  {
	  $row_array['id'] = urlencode($row["caID"]);
	  $row_array['title'] = urlencode($row["title"]);
	  $row_array['start'] = urlencode($row["start"]);
	  $row_array['end'] = urlencode($row["end"]);
	  array_push($ret_arr, $row_array);
  }

 	 echo urldecode(json_encode($ret_arr));	
?>
