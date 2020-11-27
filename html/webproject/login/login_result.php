 <?php 
  session_start();

  $id = $_REQUEST["id"];
  $pw = $_REQUEST["pass"];
 


  include "../../../MYADMIN.php";//관리자로 로그인하는 코드는 보안을 위해 DB접근 파일 경로와 같은 위치로 빼준다.
  
  require_once("../../../MYDB.php");//경로 : /usr/local/apache2.4/MYDB.php
  $pdo = db_connect();

  try {
    $sql = "select * from phptest.member where id = ? and status = 'y'";
    $stmh = $pdo -> prepare($sql);
    $stmh->bindValue(1,$id,PDO::PARAM_STR);
    $stmh->execute();

    $count = $stmh->rowCount();
      
  }catch (PDOException $Exception) {
    print "오류: ".$Exception->getMessage();
  }

  $row = $stmh->fetch(PDO::FETCH_ASSOC);
  
  if($count < 1) {
?>
<script>
alert("아이디가 틀립니다.");
history.back();
</script>

<?php 
  } else if($pw != $row["pass"]) {
?>

<script>
alert("비밀번호가 틀립니다.");
history.back();
</script>

<?php 
  } else {
    $_SESSION["userid"] = $row["id"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["nick"] = $row["nick"];
    $_SESSION["level"] = $row["level"];
    //아이디가 DB에 있는 회원일 경우 cookie에 ID값을 저장한다.(ID저장 체크박에 체크를 했을 경우)
    if(isset($_REQUEST["id_check"]))
        setcookie("id", $id, time() + 60 * 2); //유효시간 설정 (초단위)

    header("Location:../index.php");
    exit;
  }
?>