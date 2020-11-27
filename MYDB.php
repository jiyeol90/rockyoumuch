<?php
function db_connect(){  //DB연결을 함수로 정의
    $db_user ="james";    //추가한 계정이름(사용자명)
    $db_pass ="yIJASkyPFZC$@xSxh%%R1";     //비밀번호
    $db_host ="127.0.0.1";  
    $db_port = "3306";
    $db_name ="phptest";
    $db_type ="mysql";
    $dsn ="$db_type:host=$db_host;port=$db_port;db_name=$db_name;charset=utf8";

    try{ 
        $pdo=new PDO($dsn,$db_user,$db_pass);  
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        //print "데이터베이스에 접속하였습니다.<br>";  접속할 때마다 프린트 할 이유 없기 때문에 주석처리
        
    } catch (PDOException $Exception) {  
        die('오류:'.$Exception->getMessage());
    }
    return $pdo;
}
?>