<div id="logo"><a href="./index.php"><img src="./img/logo_main.png"></a></div>
	<!-- <div id="moto"><img src="../img/moto.png"></div> -->
	<div id="top_login">
<?php
    if(!isset($_SESSION["userid"]))
	{
?>
		 <a href="./login/login_form.php">로그인</a> | <a href="./member/insertForm.php">회원가입</a>
<?php
	}
	else
	{       
?>
		<?=$_SESSION["nick"]?> (level:<?=$_SESSION["level"]?>) | 
        <a href="./login/logout.php">로그아웃</a> |
<?php
        if($_SESSION["userid"] === 'admin') {
?>
        <a href="./member/admin.php"><img src="./img/admin_page.gif"></a>
<?php
        }
	}
?>
	 </div>