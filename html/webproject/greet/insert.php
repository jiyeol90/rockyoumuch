  <?php 
    session_start(); 
    $page=$_REQUEST["page"]; // insert를 해줄때는 최신순으로 추가하므로 page값을 넘겨받을 필요가 없다.
  ?>
  <meta charset="utf-8">
  <?php
     if(!isset($_SESSION["userid"])) {
  ?>
    <script>
        alert('로그인 후 이용해 주세요.');
 	 history.back();
     </script>
  <?php
    }
  if(isset($_REQUEST["mode"]))  //modify_form에서 호출할 경우
     $mode=$_REQUEST["mode"];
  else 
     $mode="";

  if(isset($_REQUEST["query"]))  //modify_form에서 호출할 경우
     $query=$_REQUEST["query"];
  else 
     $query="";
  
  if(isset($_REQUEST["num"]))
    $num=$_REQUEST["num"];
  else 
    $num="";

  if(isset($_REQUEST["search"]))   // search 쿼리스트링 값 할당 체크
    $search=$_REQUEST["search"];
  else 
    $search="";
  
  if(isset($_REQUEST["find"]))
    $find=$_REQUEST["find"];
  else
    $find="";

  if(isset($_REQUEST["html_ok"]))  //checkbox는 체크해야 변수명 전달됨.
    $html_ok=$_REQUEST["html_ok"];
  else
    $html_ok="";
 
  $subject=$_REQUEST["subject"];
  $content=$_REQUEST["content"];

  include "../filtering/filter.php";

  $count = count($swear_words); //비속어 사전 배열의 총 단어 개수
  $isClear = true;  // 게시판 내용에 비속어가 없을 경우 true , 하나라도 포함할 경우 false

  for($i = 0; $i < $count; $i++) {
      if(strpos($content, $swear_words[$i]) !== false)  {
        $isClear = false;
  ?>
    <script>
        history.back();
        alert("금지단어포함:  '<?=$swear_words[$i]?>'");
 	     
     </script>
  <?php
          }
  }

  if($isClear) { //비속어가 없는 경우에만 DB작업을 한다.
    
  require_once("../../../MYDB.php");//경로 : /usr/local/apache2.4/MYDB.php
  $pdo = db_connect();
 
  if ($query=="modify"){
 	
  try{//modify를 할 경우
    $pdo->beginTransaction();   
    $sql = "update phptest.greet set subject=?, content=?, is_html=? where num=?";
    $stmh = $pdo->prepare($sql); 
    $stmh->bindValue(1, $subject, PDO::PARAM_STR);  
    $stmh->bindValue(2, $content, PDO::PARAM_STR); 
    $stmh->bindValue(3, $html_ok, PDO::PARAM_STR);     
    $stmh->bindValue(4, $num, PDO::PARAM_STR);   
    $stmh->execute();
    $pdo->commit(); 

    if (!isset($_REQUEST["search"])) 
      header("Location:./list.php?page={$page}");  
    else 
      header("Location:./list.php?page={$page}&mode=search&find={$find}&search={$search}");  
     } catch (PDOException $Exception) {
       $pdo->rollBack();
       print "오류: ".$Exception->getMessage();
     }                         
                
  } else	{
     if ($html_ok =="y"){
 	$is_html = "y";
     }else {
	$is_html = "";
       $content = htmlspecialchars($content);
     }
    try{//새로 insert를 할 경우
     $pdo->beginTransaction();   
     $sql = "insert into phptest.greet(id,name,nick,subject,content,register_day,hit,is_html) ";
     $sql .= "values(?, ?, ?, ?, ?, now(), 0, ?)";
     $stmh = $pdo->prepare($sql); 
     $stmh->bindValue(1, $_SESSION["userid"], PDO::PARAM_STR);  
     $stmh->bindValue(2, $_SESSION["name"], PDO::PARAM_STR);  
     $stmh->bindValue(3, $_SESSION["nick"], PDO::PARAM_STR);   
     $stmh->bindValue(4, $subject, PDO::PARAM_STR);  
     $stmh->bindValue(5, $content, PDO::PARAM_STR);  
     $stmh->bindValue(6, $is_html, PDO::PARAM_STR);      
     $stmh->execute();
     $pdo->commit(); 
     header("Location:./list.php");
     } catch (PDOException $Exception) {
          $pdo->rollBack();
       print "오류: ".$Exception->getMessage();
     }   
   }
  }
 ?>