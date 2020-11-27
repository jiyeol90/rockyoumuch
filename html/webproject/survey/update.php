<?php

$composer = $_REQUEST["composer"];

require_once("../../../MYDB.php");//경로 : /var/www/MYDB.php
$pdo = db_connect();


try {
    $pdo->beginTransaction();
    $sql = "update phptest.survey set $composer = $composer + 1";
    $update_survey_query = $pdo->prepare($sql);
    $update_survey_query->execute();
    $pdo->commit();

    Header("location:./result.php");
} catch(PDOExceoption $Exception) {
    $pdo->rollBack();
    print "오류".$Exception->getMessage();
}

?>