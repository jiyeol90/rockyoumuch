<?php
   session_start(); 
          
   $num = $_REQUEST["num"];
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
      $sql = "select * from phptest.greet where num = ? ";
      $stmh = $pdo->prepare($sql); 
      $stmh->bindValue(1,$num,PDO::PARAM_STR); 
      $stmh->execute(); 
      $count = $stmh->rowCount();              
       
   if($count<1){  
      print "검색결과가 없습니다.<br>";
   }else{
        
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
   $item_subject = $row["subject"];
   $item_content = $row["content"];
   ?>
<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <link  rel="stylesheet" type="text/css" href="../css/common.css">
      <link  rel="stylesheet" type="text/css" href="../css/greet.css">
   </head>
   <body>
      <div id="wrap">
         <div id="header">
            <div class="header-container">
               <?php include "../lib/top_login2.php"; ?> 
            </div>
         </div>
         <div id="menu"><?php include "../lib/top_menu2.php"; ?></div>
         <div id="content">
            <div id="col1">
               <div id="left_menu"><?php include "../lib/left_menu.php";?></div>
            </div>
            <div id="col2">
               <div id="title"><img src="../img/title_greet.gif"></div>
               <div class="clear"></div>
               <div id="write_form_title"><img src="../img/write_form_title.gif"></div>
               <div class="clear"></div>
               <?php 
                  if(!isset($_REQUEST["find"])) { //검색 하지 않은 전체 리스트를 선택하였을 경우
               ?>
               <form  name="board_form" method="post" action="insert.php?query=modify&num=<?=$num?>&page=<?=$page?>">
               <?php
                  } else { //검색한 결과 리스트를 선택하였을 경우
               ?>
               <form  name="board_form" method="post" action="insert.php?query=modify&num=<?=$num?>&page=<?=$page?>&mode=search&find=<?=$find?>&search=<?=$search?>">
                <?php
                  }
               ?>
                  <div id="write_form">
                     <div class="write_line"></div>
                     <div id="write_row1">
                        <div class="col1"> 닉네임 </div>
                        <div class="col2"><?=$_SESSION["nick"]?></div>
                        <div class="col3">
                           <input type="checkbox" name="html_ok" value="y">HTML 쓰기
                        </div>
                     </div>
                     <div class="write_line"></div>
                     <div id="write_row2">
                        <div class="col1"> 제목   </div>
                        <div class="col2"><input type="text" name="subject" value="<?=$item_subject?>" required></div>
                     </div>
                     <div class="write_line"></div>
                     <div id="write_row3">
                        <div class="col1"> 내용   </div>
                        <div class="col2"><textarea rows="15" cols="79" name="content" required><?=$item_content?></textarea></div>
                     </div>
                     <div class="write_line"></div>
                  </div>
                  <div id="write_button"><input type="image" src="../img/ok.png">&nbsp;
                  <?php 
                  if(!isset($_REQUEST["find"])) { //검색 하지 않은 전체 리스트를 선택하였을 경우
                  ?>
                     <a href="list.php?page=<?=$page?>"><img src="../img/list.png"></a>
                  <?php
                  } else { //검색한 결과 리스트를 선택하였을 경우
                  ?>
                     <a href="list.php?page=<?=$page?>&mode=search&find=<?=$find?>&search=<?=$search?>"><img src="../img/list.png"></a>
                  <?php
                  }
                  ?>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <?php
         }
         }
         } catch (PDOException $Exception) {
         print "오류: ".$Exception->getMessage();
         }
         ?>
         <div id="footer">
            <?php include "../lib/footer.php"; ?>
          </div> <!-- end of footer -->
   </body>
</html>