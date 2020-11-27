<?php 
      session_start(); 

      if(!isset($_SESSION["userid"])) {
?>
        <script>
             alert('로그인 후 이용해 주세요.');
      history.back();
         </script>
      <?php
            } else {
                $user_id = $_SESSION["userid"];
            }
   
      require_once("../../../MYDB.php");
      $pdo = db_connect();
      
      try{
        $sql = "select * from phptest.member";
        $stmh = $pdo->query($sql);        
      } catch (PDOException $Exception) {
        print "오류: ".$Exception->getMessage();
      }          
?>
<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <title>예매 정보</title>
      <link rel="stylesheet" type="text/css" href="../css/common.css" >
      <link rel="stylesheet" type="text/css" href="../css/memo.css">
      
   </head>
   <body>
      <div id="wrap">
         <div id="header">
            <div class="header-container">
               <?php include "../lib/top_login2.php"; ?>
            </div>
            <!-- end of header-container -->
         </div>
         <!-- end of header -->
         <div id="menu">
            <?php include "../lib/top_menu2.php"; ?>
         </div>
         <div id="content">
            <div id="col1">
               <div id="left_menu">
                  <?php include "../lib/left_menu.php"; ?>
               </div>
            </div>
            <!-- end of col1 -->
            <div id="col2" style="overflow-y:scroll;height:600px;">
               <div style="width:700px; margin:0px auto; background-color:white; margin-top:30px">
               <div>[ 사용자 계정 ]</div></br>
                  <table style="width:100%">
                     <tr style="height:33px; background-color:gray; color:white; text-align:center">
                        <td>
                           아이디
                        </td>
                        <td>
                           이름 
                        </td>
                        <td>
                           닉네임
                        </td>
                        <td>
                           휴대폰
                        </td>
                        <td>
                            이메일
                        </td>
                        <td>
                            등록 날짜
                        </td>
                        <td>
                            계정 상태
                        </td>
                     </tr>
                     <?php
                        $idx = 1;
                        while($row = $stmh->fetch(PDO::FETCH_ASSOC))
                        {
                            $id             = $row["id"];
                            $name           = $row["name"];
                            $nick           = $row["nick"];
                            $hp             = $row["hp"];
                            $email          = $row["email"];
                            $register_day   = $row["register_day"];
                            $status         = $row["status"];
                                      
                        ?>
                     <tr style="height:50px;text-align:center">
                        <td>
                           &nbsp;&nbsp;<?=$id?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$name?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$nick ?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$hp?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$email?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$register_day?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=strtoupper($status)?> 
                        
                        <a href='admin_status.php?id=<?=$id?>&status=<?=$status?>'> [전환]</a>                       
                        </td>
                     </tr>
                     <tr style="height:0px; text-align:center">
                        <td colspan=7 style="border-bottom:1px solid #dddddd"></td>
                     </tr>
                     
                     <?php
                        $idx++;
                        }
                    ?>		
                  </table>
               </div>
                    </br>
               <div style="text-align:right; margin-right:50px">[ Y : 활성화 | N : 비활성화 ]</div>
            </div>
            <!-- end of col2 -->
         </div>
         <!-- end of content -->
      </div>
      <!-- end of wrap -->
      <div>&nbsp&nbsp&nbsp</div>
      <div id="footer">
         <?php include "../lib/footer.php"; ?>
      </div>
      <!-- end of footer -->
   </body>
</html>