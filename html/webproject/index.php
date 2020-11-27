<?php
 session_start();
?>
 <!DOCTYPE html>
 <html>
 <head> 
 <meta charset="UTF-8">
 <!--google SEO -->
 <meta name="google-site-verification" content="zoAk8PADy3ZANzyenv8xmBidjntpY90kb00VWM0-YLc" />
 <!--Naver SEO -->
 <meta name="naver-site-verification" content="1c3ccf126e2073624bdad901e529c4a60f93da9f" />
 <title>RockYouMuch | 락 뮤직 대표 정보공유 사이트</title>
 <meta name="description" content="다양한 Rock 밴드들의 음악과 정보를 공유합니다."/>
 <meta name="keywords" content="rockyoumuch, 락유머치, 락밴드, rockband, heavymetal, deathmetal, hardcore, 헤미메탈, 데스메탈, 하드코어">
 <meta property="og:type" content="website"> 
 <meta property="og:title" content="RockYouMuch">
 <meta property="og:description" content="다양한 Rock 밴드들의 음악과 정보를 공유합니다.">
 <meta property="og:image" content="https://www.rockyoumuch.tk/img/logo_main.png">
 <meta property="og:url" content="https://www.rockyoumuch.tk">

 <link rel="shortcut icon" href="https://www.rockyoumuch.tk/favicon.ico">
 <link rel="stylesheet" type="text/css" href="./css/common.css">
 <link rel="stylesheet" type="text/css" href="./slick/slick.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="./slick/slick.min.js"></script>
 <!--firebase 애널리틱스 적용 -->
 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyAxaStFy77tolt5qFjvtG2oE94gv0zeLCs",
    authDomain: "rockyoumuch.firebaseapp.com",
    databaseURL: "https://rockyoumuch.firebaseio.com",
    projectId: "rockyoumuch",
    storageBucket: "rockyoumuch.appspot.com",
    messagingSenderId: "575812725821",
    appId: "1:575812725821:web:e860549c814b0a79b80e54",
    measurementId: "G-7MTX1FE9D2"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
 </head>
 <body>
  <div id="wrap">
    <div id="header">
      <div class="header-container">
      <?php include "./lib/top_login1.php"; ?>
      </div><!-- end of header-container -->
    </div> <!-- end of header -->
    <div id="menu">
      <?php include "./lib/top_menu1.php"; ?>
    </div> <!-- end of menu --> 
    <div id="content">
      <div id="main_img"><img src="./img/main_image.jpg"></div>
     <div class="ban">
      <div><a href="#"><img src="./img/albumCover1.jpg" alt="앨범1"></a></div>
      <div><a href="#"><img src="./img/albumCover2.jpg" alt="앨범2"></a></div>
      <div><a href="#"><img src="./img/albumCover3.jpg" alt="앨범3"></a></div>
      <div><a href="#"><img src="./img/albumCover4.jpg" alt="앨범4"></a></div>
      <div><a href="#"><img src="./img/albumCover5.jpg" alt="앨범5"></a></div>
      <div><a href="#"><img src="./img/albumCover6.jpg" alt="앨범6"></a></div>
      <div><a href="#"><img src="./img/albumCover7.jpg" alt="앨범7"></a></div>
      <div><a href="#"><img src="./img/albumCover8.jpg" alt="앨범8"></a></div>
      <div><a href="#"><img src="./img/albumCover9.jpg" alt="앨범9"></a></div>
      </div>
      <!--오디오 꺼두기 -->
      <!-- <audio src="./bgm/rockbgm.mp3" autoplay controls style="margin-left: 350px;margin-top:10px;">  -->
    </div> <!-- end of content -->
  </div>
  <div id="footer">
      <?php include "./lib/footer.php"; ?>
    </div> <!-- end of footer -->
 </div> <!-- end of wrap -->
<script type="text/javascript">
$('.ban').slick({
  infinite: true,
  arrows : false,
  slidesToShow: 3,
  slidesToScroll: 3,
  autoplay : true,
  autoplaySpeed : 3500
  });
</script>
 </body>
 </html>

