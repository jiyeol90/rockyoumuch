<?php
   session_start();
   ?>
<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="../css/common.css">
      <link rel="stylesheet" type="text/css" href="../css/greet.css">
      <link rel="stylesheet" type="text/css" href="../css/pagination.css">
   </head>
   <?php
      //require_once("../lib/MYDB.php");
      //require_once("../../MYDB.php"); //경로가 노출될 위험이 있기때문에 root 경로 (/usr/local/apache2.4/htdocs//webproject) 밖으로 빼준다. (/usr/local/apache2.4/htdocs//MYDB.php)
      require_once("../../../MYDB.php");//경로 : /usr/local/apache2.4/MYDB.php
      $pdo = db_connect();
      
      //page값을 받아온다. 없으면 1로 설정
      if(isset($_GET['page'])) {
        $page = $_GET['page'];
      } else {
        $page = 1;
      }
      
      if(isset($_REQUEST["mode"]))
         $mode=$_REQUEST["mode"];
      else 
         $mode="";
      if(isset($_REQUEST["search"]))   // search 쿼리스트링 값 할당 체크
        $search=$_REQUEST["search"];
      else 
        $search="";
      
      if(isset($_REQUEST["find"]))
        $find=$_REQUEST["find"];
      else
        $find="";
      
      if($mode=="search"){
        if(!$search){
      ?>
   <script>
      alert('검색할 단어를 입력해 주세요!');
      history.back();
   </script>
   <?php
      }
      /*
      * 페이지에서 고려할 요소
      * 1. 총 레코드 수 (데이터) : 게시판에 노출 될 총 데이터 수
      * 2. 한 페이지 당 리스트 수 : 한 페이지에 몇개의 데이터를 보여줄 것인지 
      * 3. 한 블록 당 페이지 수 : [1] [2] [3] ... [5] 와 같이 표시되는 페이지 번호들의 모임을 블록이라 한다.
      */ 
      
      $sql="select * from phptest.greet where visible = 'y' and $find like '%$search%' order by num desc";
      } else {
      $sql="select * from phptest.greet where visible = 'y' order by num desc"; //게시판의 목록은 visible의 값이 y인 목록을 보여준다.
      }
      try{  
      $stmh = $pdo->query($sql); 
      $count= $stmh->rowCount(); //게시판 총 레코드 수
      $list = 8; //한 페이지에 보여줄 개수
      $block_cnt = 5; //한 블록당 보여줄 페이지 개수

      //하나이상의 페이지가 있는 리스트에서 마지막 페이지의 리스트가 하나만 있을경우 해당 리스트를 삭제하게되면 자동으로 이전 페이지를 보여주어야 한다.
      //*** 삭제했을 경우에만 해당한다. 단순 리스트 검색일 경우에는 해당하지 않는다.
      // 1번째 페이지 : 8개 , 2번째 페이지 : 1개 -> 2번째 페이지의 리스트를 삭제 -> 1번째 페이지를 보여준다. 
      if($page != 1 && $list*($page - 1) == $count ) {//&& $query == "delete" -> 이 부분은 필요없다. 
         $page -= 1;
      }  
      $countNum = $count - (($page - 1) * $list) ; // 게시판에 나타낼 목록 번호 (페이지 목록 중간이 삭제가 되어도 번호는 순서대로 정렬되어야 한다.)
                                                   // 1 ~ 5 번 까지의 글목록중 3번이 삭제되면 글목록에는 1, 2, 3, 4 가 표시되어야한다. 
                                                   // 키값을 사용할 경우 1, 2, 4, 5 로 표시가 된다. 

      $block_num = ceil($page/$block_cnt); // 현재 페이지 블록 구하기
      $block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작번호
      $block_end = $block_start + $block_cnt - 1; //블록의 마지막 번호
      
      $total_page = ceil($count / $list); //전체 페이지 수 구하기
      if($block_end > $total_page) $block_end = $total_page; //블록의 마지막 번호가 페이지 수보다 많다면 마지막 번호는 페이지 수 (총 페이지 수가 블록당 보여줄 페이지 수보다 적을 경우)
      $total_block = ceil($total_page / $block_cnt); //총 블럭 개수
      $start_num = ($page-1) * $list;
      if(!$search){//검색을 하지 않았을 경우
        $sql = "select * from phptest.greet where visible = 'y' order by num desc limit $start_num , $list ";
      } else {//검색을 했을경우
        $sql="select * from phptest.greet where visible = 'y' and $find like '%$search%' order by num desc limit $start_num , $list ";
      }
      $stmh = $pdo->query($sql);  
      
      ?>
   <body>
      <div id="wrap">
         <div id="header">
            <div class="header-container">
             <?php include "../lib/top_login2.php"; ?>
            </div>
         </div>
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
            <div id="col2">
               <div id="title"><img src="../img/title_greet.gif"></div>
               <form name="board_form" method="post" action="list.php?mode=search">
                  <div id="list_search">
                     <div id="list_search1">▶ 총 <?= $count ?> 개의 게시물이 있습니다.</div>
                     <div id="list_search2"><img src="../img/select_search.gif"></div>
                     <div id="list_search3">
                        <select name="find">
                           <option value='subject'>제목</option>
                           <option value='content'>내용</option>
                           <option value='nick'>닉네임</option>
                           <option value='name'>이름</option>
                        </select>
                     </div>
                     <!-- end of list_search3 -->
                     <div id="list_search4"><input type="text" value = "<?=$search ?>" name="search"></div>
                     <div id="list_search5"><input type="image" src="../img/list_search_button.gif"></div>
                  </div>
                  <!-- end of list_search -->
               </form>
               <div class="clear"></div>
               </br>
               <div id="list_top_title">
                  <ul>
                     <li id="list_title1"><img src="../img/list_title1.gif"></li>
                     <li id="list_title2"><img src="../img/list_title2.gif"></li>
                     <li id="list_title3"><img src="../img/list_title3.gif"></li>
                     <li id="list_title4"><img src="../img/list_title4.gif"></li>
                     <li id="list_title5"><img src="../img/list_title5.gif"></li>
                  </ul>
               </div>
               <!-- end of list_top_title -->
               <div id="list_content">
                  <?php  // 글 목록 출력
                     while($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
                       $item_num=$row["num"];
                       $item_id=$row["id"];
                       $item_name=$row["name"];
                       $item_nick=$row["nick"];
                       $item_hit=$row["hit"];
                       $item_date=$row["register_day"];
                       $item_date=substr($item_date, 0, 10);
                       $item_subject=str_replace(" ", "&nbsp;", $row["subject"]); //html에서는 공백문자를 인식하지 못하기때문에 &nbsp로 치환한다.
                     ?>
                  <div id="list_item">
                     <div id="list_item1"><?= $countNum-- ?></div> <!--기존의 $item_num 의 키값을 출력하는 것을 수정하였다. 글목록 순서는 순차적으로 나타내기 위해서(위의 $countNum 주석 참고) -->
                     <?php 
                     if(!isset($_REQUEST["search"])) {
                     ?>
                     <div id="list_item2"><a href="view.php?num=<?=$item_num?>&page=<?=$page?>"><?= $item_subject ?></a></div>
                     <?php 
                     } else {
                     ?>
                     <div id="list_item2"><a href="view.php?num=<?=$item_num?>&page=<?=$page?>&mode=search&find=<?=$find?>&search=<?=$search?>"><?= " [ ".$item_num." ]  " , $item_subject ?></a></div>
                     <?php
                     }
                     ?>
                     <div id="list_item3"><?= $item_nick ?></div>
                     <div id="list_item4"><?= $item_date ?></div>
                     <div id="list_item5"><?= $item_hit ?></div>
                  </div>
                  <!-- end of list_item -->
                  <?php
                     }
                     } catch (PDOException $Exception) {
                      print "오류: ".$Exception->getMessage();
                     }  
                     ?>
                  <!---페이징 넘버 --->
                  <div id="page_num">
                     <ul>
                        <?php
                           if(!isset($_REQUEST["search"])) {
                           if($page <= 1)
                           { //만약 page가 첫 페이지라면
                             echo "<li class='fo_re'>처음</li>"; //처음이라는 글자에 빨간색 표시 -> 강조해주는 효과
                           }else{
                             echo "<li><a href='?page=1'>처음</a></li>"; //첫페이지가 아니라면 처음글자에 1번페이지로 갈 수있게 링크
                           }
                           if($page <= 1)
                           { //만약 page가 첫 페이지라면 이전페이지 이동이 필요없기 때문에 빈 값으로 둔다.
                           }else{
                           $pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                             echo "<li><a href='?page=$pre'>이전</a></li>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
                           }
                           for($i=$block_start; $i<=$block_end; $i++){ 
                             //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지막 블록보다 작거나 같을 때까지 $i를 반복시킨다
                             if($page == $i){ //만약 page가 $i와 같다면 
                               echo "<li class='fo_re'>[$i]</li>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                             }else{
                               echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 $i
                             }
                           }
                           if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
                           }else{
                             $next = $page + 1; //next변수에 page + 1을 해준다.
                             echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
                           }
                           if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
                             echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
                           }else{
                             echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
                           }
                        } else { //isset($_REQUEST["search"] 
                           if($page <= 1)
                           { //만약 page가 첫 페이지라면
                             echo "<li class='fo_re'>처음</li>"; //처음이라는 글자에 빨간색 표시 -> 강조해주는 효과
                           }else{
                             echo "<li><a href='?page=1&mode=search&find=$find&search=$search'>처음</a></li>"; //첫페이지가 아니라면 처음글자에 1번페이지로 갈 수있게 링크
                           }
                           if($page <= 1)
                           { //만약 page가 첫 페이지라면 이전페이지 이동이 필요없기 때문에 빈 값으로 둔다.
                           }else{
                           $pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                             echo "<li><a href='?page=$pre&mode=search&find=$find&search=$search'>이전</a></li>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
                           }
                           for($i=$block_start; $i<=$block_end; $i++){ 
                             //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지막 블록보다 작거나 같을 때까지 $i를 반복시킨다
                             if($page == $i){ //만약 page가 $i와 같다면 
                               echo "<li class='fo_re'>[$i]</li>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                             }else{
                               echo "<li><a href='?page=$i&mode=search&find=$find&search=$search'>[$i]</a></li>"; //아니라면 $i
                             }
                           }
                           if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
                           }else{
                             $next = $page + 1; //next변수에 page + 1을 해준다.
                             echo "<li><a href='?page=$next&mode=search&find=$find&search=$search'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
                           }
                           if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
                             echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
                           }else{
                             echo "<li><a href='?page=$total_page&mode=search&find=$find&search=$search'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
                           }
                        }
                           ?>
                     </ul>
                  </div>
                  <!--end of page_num -->
                  <!---페이징 넘버 --->
                  <div id="write_button">
                     <a href="list.php"><img src="../img/list.png"></a>&nbsp;
                     <?php
                        if(isset($_SESSION["userid"]))
                        {
                        ?>
                     <a href="write_form.php"><img src="../img/write.png"></a>
                     <?php
                        }
                        ?>
                  </div>
               </div>
            </div>
            <!-- end of col2 -->
         </div>
         <!-- end of content -->
      </div>
      <!-- end of wrap -->
      <div id="footer">
            <?php include "../lib/footer.php"; ?>
         </div> <!-- end of footer -->
   </body>
</html>