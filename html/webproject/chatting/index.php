<?php 
      session_start(); 
      $userid = $_SESSION["userid"];

      if(!isset($_SESSION["userid"])) {
?>
        <script>
             alert('로그인 후 이용해 주세요.');
      history.back();
         </script>
<?php
      } else {
?>
<script>
   var user = "<?= $userid ?>";
</script>
<?php
      }
?>
<!DOCTYPE html> 
<html lang="ko">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" type="text/css" href="../css/common.css">
      <link rel="stylesheet" href="./src/css/index.css">
      <title>chat-app</title>
   </head>
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
      <!-- end of menu --> 
      <div id="content">
         <div id="col1">
            <div id="left_menu">
               <?php include "../lib/left_menu.php";?>
            </div>
            <!-- end of left_menu -->
         </div>
         <!-- end of col1 -->
         <div id="col2">
         <div class="app__wrap">
         <div id="info" class="app__info"></div>
         <div id="chatWindow" class="app__window"></div>
         <div class="app__input__wrap"> <input id="chatInput" type="text" class="app__input" autofocus placeholder="대화를 입력해주세요."> <button id="chatMessageSendBtn" class="app__button">전송</button> </div>
      </div>
         </div>
         <!-- end of col2 -->
      </div>
      <!-- end of content -->
   </div>
   <!-- end of wrap -->
   <div id="footer">
      <?php include "../lib/footer.php"; ?>
   </div>
   <!-- end of footer -->
   <!-- 임베디드 방식으로 nodejs 삽입 -->
   <script src="./node_modules/socket.io-client/dist/socket.io.js"></script>
   <script src="./src/js/index.js"></script> 
   </body>
</html>