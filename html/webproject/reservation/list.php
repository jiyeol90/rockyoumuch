<?php 
      session_start(); 

      if(!isset($_SESSION["userid"])) {
?>
        <script>
             alert('로그인 후 이용해 주세요.');
      history.back();
         </script>
<?php 
      }
      require_once("../../../MYDB.php");
      $pdo = db_connect();
      
      try{
        $sql = "SELECT A.studio_id, max(A.studio_name) as studio_name, max(A.studio_address) as studio_address, max(A.contents) as contents, count(B.rs_id) as rsCount
                   FROM phptest.studio A left outer join phptest.studio_reservation B
                   on A.studio_id = B.studio_id
                   group by A.studio_id
                   ORDER BY A.studio_id asc";
                   //등록 되어있는 스튜디오를 검색한다. 스튜디오 테이블과 예약 테이블을 조인하여 예약한 인원이 없어도 등록되어있는 스튜디오는 검색결과에 반영되기 위해 left outer join 을 사용하였다.
                   //달력(full calendar)을 적용하기 전 총 에약인원을 보여주기위해 count(B.rs_id) 집계함수를 사용하였다. -> 달력 적용후 스튜디오의 테이블만 조회하여 출력해도 무방함. 
        $stmh = $pdo->query($sql);       
      } catch (PDOException $Exception) {
        print "오류: ".$Exception->getMessage();
      }          
?>
<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <title>스튜디오 예약</title>
      <link rel="stylesheet" type="text/css" href="../css/common.css" >
      <link rel="stylesheet" type="text/css" href="../css/memo.css">
      <link href='fullcalendar.min.css' rel='stylesheet' />
      <link href='fullcalendar.print.min.css' rel='stylesheet' media='print' />
      <script src="jquery.min.js"></script>
      <script src="jquery-ui.min.js"></script>
      <script src='moment.min.js'></script>
      <script src='fullcalendar.min.js'></script>
      <script src='fullcalendar_ko.js'></script>
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
                  <?php include "../lib/left_menu.php"; ?>
               </div>
            </div>
            <!-- end of col1 -->
            <div id="col2" style="overflow-x:scroll;overflow-y:scroll;height:600px;">
               <div style="width:700px; margin:0px auto; background-color:white; margin-top:30px">
                  <table style="width:100%">
                     <tr style="height:33px; background-color:gray; color:white; text-align:center">
                        <td>
                           No.
                        </td>
                        <td>
                           스튜디오 이름 
                        </td>
                        <td>
                           주소
                        </td>
                        <td>
                           설명
                        </td>
                     </tr>
                     <?php
                        $idx = 1;
                        while($row = $stmh->fetch(PDO::FETCH_ASSOC))
                        {
                            $studio_id        = $row["studio_id"];
                            $studio_name      = $row["studio_name"];
                            $studio_address   = $row["studio_address"];
                            $contents         = $row["contents"];
                                      
                        ?>
                     <tr style="height:33px; text-align:center" class="classPensionGroup" selectpension="" 
                     onclick="javascript:clickPension(this, '<?=$idx?>', '<?=$studio_id?>', '<?=$studio_name?>');" 
                     onmouseover="javascript:selectPension(this);" onmouseout="javascript:unSelectPension(this);">
                        <td>
                           <?=$idx?>
                        </td>
                        <td>
                           <?=$studio_name?>
                        </td>
                        <td>
                           <?=$studio_address ?>
                        </td>
                        <td>
                           <?=$contents?>
                        </td>
                     </tr>
                     <tr style="height:0px; text-align:center">
                        <td colspan=4 style="border-bottom:1px solid #dddddd"></td>
                     </tr>
                     <tr id="trCalendar<?=$idx?>" style="display:none">
                        <td colspan=4>
                           <div style="padding-left:45px; margin-top:5px; margin-bottom:5px">예약하실 날짜를 선택해주세요</div>
                           <div id='calendar<?=$idx?>' style="max-width:900px; margin: 0 auto;">
                           </div>
                        </td>
                     </tr>
                     <?php
                        $idx++;
                        }
                    ?>		
                  </table>
               </div>
               <div class="box box-success" style="width:500px; display:none; background-color:white; padding-top:15px; padding-bottom:15px" id="winReservation">
		<form name=frm method="post" action="reservation_ok.php">		
		<input type="hidden" name="insert_houseid" id="insert_houseid" value="">
		<div style="width:100%; height:33px; margin-left:20px">
			<div style="width:30%;float:left">
				펜션이름:
			</div>
			<div style="width:70%;float:left" id="divHouseName">
			</div>
		</div>
		<div style="width:100%; height:33px; margin-left:20px">
			<div style="width:30%;float:left">
				예약날짜:
			</div>
			<div style="width:70%;float:left">
				<input type="text" name="reservation_date" id="reservation_date" style="width:80px">
			</div>
		</div>
		<div style="width:100%; height:33px; margin-left:20px">
			<div style="width:30%;float:left">
				숙박인원:
			</div>
			<div style="width:70%;float:left">
				<input type="text" name="total_man" id="total_man" style="width:50px">명
			</div>
		</div>
		</form>
		<div style="width:100%; height:33px; margin-top:30px; text-align:center">
			<button style="background-color:gray; color:white; border:1px solid #222222" onclick="javascript:saveReservation();">예약하기</button>
		</div>
	</div><!-- /.box -->
            </div>
            <!-- end of col2 -->
         </div>
         <!-- end of content -->
      </div>
      <!-- end of wrap -->
      <div>&nbsp&nbsp&nbsp</div>
      <div id="footer">
         <?php include "../lib/footer.php"; ?>
      </div>
      <!-- end of footer -->
   </body>
   <script src="./jquery.bpopup2.min.js" type="text/javascript"></script>
   <script>

      function execReservation(houseID, houseName, selectedDate)
      {
      	$("#insert_houseid").val(houseID);
      	$("#divHouseName").html(houseName);
      	$("#reservation_date").val(selectedDate);
      
      	$('#winReservation').bPopup();
      }
      
      var selectedPension = "";
      var selectedPensionDetail = "";
      //목록에 있는 스튜디오 선택
      function clickPension(objThis, idx, houseID, houseName)
      {

      	if(selectedPension)
      	{
      		$(selectedPension).attr("selectpension","");
      		unSelectPension(selectedPension);
      		if(selectedPensionDetail)
      		{
      			selectedPensionDetail.hide();
      		}
      	}
      
      	selectedPension = objThis;
      	selectedPensionDetail = $("#trCalendar"+idx);
      	$(objThis).attr("selectpension","ok");
      
      	showPensionDetail(objThis, idx, houseID, houseName);
      }
      
      function selectPension(objThis)
      {
      	$(objThis).css('background-color','#aaaaaa'); 
      	$(objThis).css('color','white')
      }
      
      function unSelectPension(objThis)
      {
      	if($(objThis).attr("selectpension") != "ok")
      	{
      		$(objThis).css('background-color','white'); 
      		$(objThis).css('color','black')
      	}
      }
      
      function showPensionDetail(objThis, idx, houseID, houseName)
      {
      	selectedPensionDetail.show();
      
         //full calendar doc 참조 : https://fullcalendar.io/docs/v3/events-json-feed
      	$('#calendar'+idx).fullCalendar({
      	  editable: true,
      	  navLinks: true,
      	  eventLimit: true,
      	  locale : "ko", //한글 적용
      	  events:{
			url: 'getStudioReservation.php?houseid='+houseID 
		  },
			dayClick: function(date, jsEvent, view) {
				var selectedDate = date.format();  //yyyy-mm-dd
				execReservation(houseID, houseName, selectedDate);
			}
		});
      }
      
      function saveReservation()
      {
      	if(!$.trim($("#reservation_date").val()))
      	{
      		alert("예약날짜를 입력해주십시오");
      		return false;
      	}
      	if(!$.trim($("#total_man").val()))
      	{
      		alert("예약인원을 입력해주십시오");
      		return false;
      	}
      	if(isNaN($("#total_man").val()))
      	{
      		alert("예약인원을 숫자로 입력해주십시오");
      		return false;
      	}
      	document.frm.submit();
      }
   </script>
</html>