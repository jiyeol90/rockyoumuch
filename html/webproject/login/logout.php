<?php
session_start(); //session변수를 사용할때 반드시 호출해야 한다.
unset($_SESSION["userid"]);
unset($_SESSION["name"]);
unset($_SESSION["nick"]);
unset($_SESSION["level"]);

header("Location:../index.php");
?>