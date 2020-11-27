<?php
if($id == "admin" && $pw = "#upD#A@UwDV2"){
    $_SESSION["userid"] = "admin";
    $_SESSION["name"] = "관리자";
    $_SESSION["nick"] = "관리자";
    $_SESSION["level"] = "1";

    header("Location:../index.php");
    exit;
  }
?>