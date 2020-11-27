<?php
// Local JSON 파일 읽어오기

session_start();

$url ='data.json'; //크롤링한 json 파일

if(!file_exists($url)) {
    echo '파일이 없습니다.';
    exit;
}
$json_string = file_get_contents($url);
$R = json_decode($json_string, true);
// json_decode : JSON 문자열을 PHP 배열로 바꾼다
// json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
// $R : array data

//echo '<pre>';
//print_r($R);
//echo '</pre>';

// 자료 파싱처리

// foreach ($R as $key => $value) {
//     if (!is_array($value)) {
//         echo $key . '=>' . $value . '<br/>';
//     } else {
//         foreach ($value as $key => $val) {
//             if($key === 'title') {
//             echo $key . '=>' . $val . '<br/>';
//         } else if($key === 'url'){
//             echo '<a href='. $val .'>';
//         }
           
//         }
//         echo '<br />';
//     }
// }
$num = 1;  

?>
<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="../css/common.css" >
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
                  <?php include "../lib/left_menu.php";?>
               </div>
            </div>
             <!-- end of col1 -->
            <div id="col2" style="overflow-x:hidden;overflow-y:scroll;height:600px;">
            <table style="width:100%">
                     <tr style="height:33px; background-color:gray; color:white; text-align:center">
                        <td>
                           No.
                        </td>
                        <td>
                           앨범커버
                        </td>
                        <td>
                           앨범 타이틀
                        </td>
                        <td>
                           밴드명
                        </td>
                     </tr>

<?php
foreach ($R as $row) {
    $title= $row['title'];
    $band = $row['band'];
    $url = $row['url'];
    $img_url = $row['img_url'];
    $img_alt = $row['img_alt'];
    
    // echo $num++.'.  <a href=http://www.hottracks.co.kr'. $url .'>'.$title.'</a></br>';
    // echo '<img src='.$img_url.' alt='.$img_alt.'></br>';
?>
  <tr style="height:33px; text-align:center">
                        <td>
                            <?=$num++?>
                        </td>   
                        <td>
                           <img src=<?=$img_url ?> alt=<?=$img_alt ?> width="100" height="100">
                        </td>
                        <td>
                           <a href=http://www.hottracks.co.kr<?=$url?> style="text-decoration:none"><?=$band?></a>
                        </td>
                        <td>
                        <a href=http://www.hottracks.co.kr<?=$url?> style="text-decoration:none"><?=$title?></a>
                        </td>                     
    </tr>

<?php
}
?>
</table>

            <!-- end of col2 -->
         </div>
         <!-- end of content -->
      </div>
      <!-- end of wrap -->
     
     <div id="footer">
         <?php include "../lib/footer.php"; ?>
      </div>
      <!-- end of footer -->
   </body>
</html>