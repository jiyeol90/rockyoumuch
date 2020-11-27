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
        if($user_id == 'admin') {
            $sql = "SELECT B.rs_id, B.user_id , A.studio_name, A.studio_address, B.rs_date, B.tot_cnt
            FROM phptest.studio A join phptest.studio_reservation B
            on A.studio_id = B.studio_id
            ORDER BY user_id asc";
        } else {
        $sql = "SELECT B.rs_id, B.user_id , A.studio_name, A.studio_address, B.rs_date, B.tot_cnt
                   FROM phptest.studio A join phptest.studio_reservation B
                   on A.studio_id = B.studio_id
                   Where user_id = '$user_id'
                   ORDER BY A.studio_id asc";
        }
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
                  <table style="width:100%">
                     <tr style="height:33px; background-color:gray; color:white; text-align:center">
                        <td>
                           아이디
                        </td>
                        <td>
                           스튜디오 이름 
                        </td>
                        <td>
                           주소
                        </td>
                        <td>
                           예약 날짜
                        </td>
                        <td>
                            예약 인원
                        </td>
                     </tr>
                     <?php
                        $idx = 1;
                        while($row = $stmh->fetch(PDO::FETCH_ASSOC))
                        {
                            $rs_id          = $row["rs_id"];
                            $user_id        = $row["user_id"];
                            $studio_name      = $row["studio_name"];
                            $studio_address   = $row["studio_address"];
                            $rs_date         = $row["rs_date"];
                            $tot_cnt         = $row["tot_cnt"];
                                      
                        ?>
                     <tr style="height:33px;text-align:center">
                        <td>
                           &nbsp;&nbsp;<?=$user_id?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$studio_name?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$studio_address ?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$rs_date?>
                        </td>
                        <td>
                        &nbsp;&nbsp;<?=$tot_cnt?> 명 
                        <?php
                           if(isset($_SESSION["userid"])){
                           if($_SESSION["userid"]=="admin" || $_SESSION["userid"]==$user_id) //관리자나 해당 아이디로 접속할 경우 삭제할 수 있는 권한을 얻는다.
                           print "<a href='delete.php?rs_id=$rs_id'>[삭제]</a>"; 
                            }
                           ?>
                        </td>

                     </tr>
                     <tr style="height:0px; text-align:center">
                        <td colspan=5 style="border-bottom:1px solid #dddddd"></td>
                     </tr>
                     
                     <?php
                        $idx++;
                        }
                    ?>		
                  </table>
               </div>
               
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