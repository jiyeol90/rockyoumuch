<?php
  $num=$_REQUEST["num"];
  $page=$_REQUEST["page"];

if(isset($_REQUEST["mode"]))  //검색 결과리스트를 클릭했을 경우 mode와 find search 값을 가져온다.
  $mode=$_REQUEST["mode"];
else 
  $mode="";
if(isset($_REQUEST["search"]))   // search 쿼리스트링 값 할당 체크
 $search=$_REQUEST["search"];
else 
 $search="";

if(isset($_REQUEST["find"]))
 $find=$_REQUEST["find"];
else
 $find="";


  require_once("../../../MYDB.php");//경로 : /usr/local/apache2.4/MYDB.php
  $pdo = db_connect();
      
   try{
     $pdo->beginTransaction();
     $sql = "update phptest.greet set visible = 'n' , delete_day = now() where num = ?";   //삭제요청시 해당 게시글을 데이터베이스에서 지우는것이 아니라 보이지 않게 처리해준다.
     $stmh = $pdo->prepare($sql);
     $stmh->bindValue(1,$num,PDO::PARAM_STR);
     $stmh->execute();   
     $pdo->commit();
              
     if(!isset($_REQUEST["find"])) 
        header("Location:./list.php?page={$page}");
     else 
        header("Location:./list.php?&page={$page}&mode=search&find={$find}&search={$search}");  

     } catch (Exception $ex) {
              $pdo->rollBack();
              print "오류: ".$Exception->getMessage();
     }
?>
