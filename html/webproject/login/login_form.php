<?php
   session_start();

if(isset($_COOKIE["id"]))
    $cookie_id = $_COOKIE["id"];
else
   $cookie_id = "";
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="../css/common.css">
      <link rel="stylesheet" type="text/css" href="../css/member.css">
   </head>
   <body>
   <div id="wrap">
    <div id="header">
      <div class="header-container">
        <?php include "../lib/top_login2.php"; ?>
      </div><!-- end of header-container -->
    </div> <!-- end of header -->
    <div id="menu">
      <?php include "../lib/top_menu2.php"; ?>
    </div> <!-- end of menu --> 

    <div id="content">
    <div id="col1">
      <div id="left_menu">
           <?php include "../lib/left_menu.php";?>
      </div><!-- end of left_menu -->
    </div><!-- end of col1 -->

    <div id="col2">
      <form name="login_form" method="post" action="login_result.php">
      <div id="title">
        <img src="../img/title_login.gif">
      </div><!-- end of title -->
        <div id="login_form">
            <img id="login_msg" src="../img/login_msg.gif">
            <div class="clear"></div>

            <div id="login1">
                <img src="../img/login_key.gif">
            </div><!-- end of login1 -->
            <div id="login2">
            <div id="id_input_button">
            <div id="id_pw_title">
                <ul>
                <li><img src="../img/id_title.gif"></li>
                <li><img src="../img/pw_title.gif"></li>
                </ul>
            </div><!-- end of id_pw_title -->
            <div id="id_pw_input">
            <ul>
            <li><input type="text" name="id" value="<?=$cookie_id?>" class="login_input" required></li>
            <li><input type="password" name="pass" class="login_input" required></li>
            </ul>
            </div><!-- end of id_pw_input -->
            <div id="login_button">
                <input type="image" src="../img/login_button.gif" onclick="document.member_form.submit()">
            </div><!-- end of login_button -->
            </div><!-- end of id_input_button -->
           
           
            <div class="clear"></div>
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="id_check"> ID 저장 
           <a href="../member/insertForm.php">&nbsp;&nbsp;&nbsp;&nbsp;회원가입</a>
            <div id="login_line"></div>  
            <div id="join_button">
            <img src="../img/no_join.gif">&nbsp;&nbsp;&nbsp;&nbsp;<a href="../member/insertForm.php"><img src>
            </div>
            </div><!-- end of login2 -->
            </div><!-- end of form_login -->
            </form>
    </div><!-- end of col2 -->
    </div> <!-- end of content -->
 </div> <!-- end of wrap -->
 <div id="footer">
      <?php include "../lib/footer.php"; ?>
    </div> <!-- end of footer -->
   </body>
   </html>