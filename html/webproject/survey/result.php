<?php
   require_once("../../../MYDB.php");//경로 : /var/www/MYDB.php
   $pdo = db_connect();
   
   try{
       $sql = "select * from phptest.survey";
       $result = $pdo->query($sql);
   
       $row = $result->fetch(PDO::FETCH_ASSOC);
   
       $total = $row["selection1"] + $row["selection2"] + $row["selection3"] + $row["selection4"];
       
       $selection1_percent = $row["selection1"]/$total * 100;
       $selection2_percent = $row["selection2"]/$total * 100;
       $selection3_percent = $row["selection3"]/$total * 100;
       $selection4_percent = $row["selection4"]/$total * 100;
   
       $selection1_percent = floor($selection1_percent);
       $selection2_percent = floor($selection2_percent);
       $selection3_percent = floor($selection3_percent);
       $selection4_percent = floor($selection4_percent);
   ?>
<html>
   <head>
      <title>설문조사</title>
      <link rel="stylesheet" type="text/css" href="../css/survey.css">
      <meta charset="utf-8">
   </head>
   <body>
      <table width="250" height=250 border=0 cellspacing=0 cellpadding=0>
         <tr>
            <td width=180 height=1 colspan=5 bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td width=1 height=35 bgcolor=#ffffff></td>
            <td width=9 bgcolor=#ffffff></td>
            <td width=150 align=center bgcolor=#ffffff>
               <b>총 투표수 : <?php print $total ?> &nbsp;명 </b>
            </td>
            <td width=9 bgcolor=#ffffff></td>
            <td width=1 bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=29 bgcolor=#ffffff></td>
            <td></td>
            <td valign=middle><b>가장 좋아하는 밴드 는?</b></td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=20 bgcolor=#ffffff></td>
            <td></td>
            <td>Lambs of God (<b><?php print $selection1_percent ?></b> %)
               <font color=purple><b><?php print $row["selection1"] ?></b></font> 명
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=3 bgcolor=#ffffff></td>
            <td></td>
            <td>
               <table  width=100 border=0 height=3 cellspacing=0 cellpadding=0>
                  <tr>
                     <?php
                        $rest = 100 - $selection1_percent;
                        print "
                         <td width='$selection1_percent%' bgcolor=purple></td>
                         <td width='$rest%' bgcolor=#dddddd height=5></td>
                        ";
                        ?>
                  </tr>
               </table>
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=20 bgcolor=#ffffff></td>
            <td></td>
            <td>Nothing but Theives (<b><?php print $selection2_percent ?></b> %)
               <font color=blue><b><?php print $row["selection2"] ?></b></font> 명
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=3 bgcolor=#ffffff></td>
            <td></td>
            <td>
               <table width=100 border=0 height=3 cellspacing=0 cellpadding=0>
                  <tr>
                     <?php
                        $rest = 100 - $selection2_percent;
                        print "
                         <td width='$selection2_percent%' bgcolor=blue></td>
                         <td width='$rest%' bgcolor=#dddddd height=5></td>
                        ";
                        ?>
                  </tr>
               </table>
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=20 bgcolor=#ffffff></td>
            <td></td>
            <td>Tool (<b><?php print $selection3_percent ?></b> %)
               <font color=green><b><?php print $row["selection3"] ?></b></font> 명
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=3 bgcolor=#ffffff></td>
            <td></td>
            <td>
               <table width=100 border=0 height=3 cellspacing=0 cellpadding=0>
                  <tr>
                     <?php
                        $rest = 100 - $selection3_percent;
                        print "
                         <td width='$selection3_percent%' bgcolor=green></td>
                         <td width='$rest%' bgcolor=#dddddd height=5></td>
                        ";
                        ?>
                  </tr>
               </table>
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=20 bgcolor=#ffffff></td>
            <td></td>
            <td>Under Oath (<b><?php print $selection4_percent ?></b> %)
               <font color=purple><b><?php print $row["selection4"] ?></b></font> 명
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=3 bgcolor=#ffffff></td>
            <td></td>
            <td>
               <table width=100 border=0 height=3 cellspacing=0 cellpadding=0>
                  <tr>
                     <?php
                        $rest = 100 - $selection4_percent;
                        print "
                         <td width='$selection4_percent%' bgcolor=skyblue></td>
                         <td width='$rest%' bgcolor=#dddddd height=5></td>
                        ";
                        ?>
                  </tr>
               </table>
            </td>
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=40 bgcolor=#ffffff></td>
            <td></td>
            <td align=center valign=middle>
               <input type=image style="cursor:hand" src="../img/close.gif" border=0  onfocus=this.blur() onclick="window.close()">
            <td></td>
            <td bgcolor=#ffffff></td>
         </tr>
         <tr>
            <td height=1 colspan=5 bgcolor=#ffffff></td>
         </tr>
      </table>
      <?php
         } catch (PDOException $Exception) {
             print "오류: ".$Exception->getMessage();
         }
         ?>
   </body>
</html>