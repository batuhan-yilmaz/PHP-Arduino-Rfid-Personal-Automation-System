<?php
session_start();
if (isset($_SESSION['Admin-name'])) {
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LOGIN | OASIS CONTROL CENTER</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="js/jquery-2.2.3.min.js"></script>
    <script>
      $(window).on("load resize ", function() {
          var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
          $('.tbl-header').css({'padding-right':scrollWidth});
      }).resize();
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click', '.message', function(){
          $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
          $('h1').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
      });
    </script>
</head>
<body>
<?php include'header.php'; ?> 
<main style="color:#636363;">
  <h1 class="slideInDown animated">Lütfen yetkili hesabı ile giriş yapınız</h1>
    <h1><a href="http://localhost/rfidattendance/getdata.php?card_uid=118145116248&device_token=6bfcbce060c5d26a" target="_blank">Cart Test Link</a></h1>
  <h1 class="slideInDown animated" id="reset">Parolanızı sıfırlamak için E-mail adresinizi giriniz</h1>
<!-- Log In -->
<section>
  <div class="slideInDown animated">
    <div class="login-page">
      <div class="form">
        <?php  
          if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidEmail") {
                echo '<div class="alert alert-danger">
                         E-mail adresi geçersiz!
                      </div>';
            }
            elseif ($_GET['error'] == "sqlerror") {
                echo '<div class="alert alert-danger">
                        Database error!
                      </div>';
            }
            elseif ($_GET['error'] == "wrongpassword") {
                echo '<div class="alert alert-danger">
                       Hatalı parola!!
                      </div>';
            }
            elseif ($_GET['error'] == "nouser") {
                echo '<div class="alert alert-danger">
                        E-mail adresi mevcut değil!
                      </div>';
            }
          }
          if (isset($_GET['reset'])) {
            if ($_GET['reset'] == "success") {
                echo '<div class="alert alert-success">
                        E-mail adresinizi kontrol edin!
                      </div>';
            }
          }
          if (isset($_GET['account'])) {
            if ($_GET['account'] == "activated") {
                echo '<div class="alert alert-success">
                        Giriş yapın!
                      </div>';
            }
          }
          if (isset($_GET['active'])) {
            if ($_GET['active'] == "success") {
                echo '<div class="alert alert-success">
                        Aktivasyon gönderildi!
                      </div>';
            }
          }
        ?>
        <div class="alert1"></div>
        <form class="reset-form" action="reset_pass.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" placeholder="E-mail" required/>
          <button type="submit" name="reset_pass">Parolamı Sıfırla</button>
          <p class="message"><a href="#" style="color:#ffffff;">Sisteme Giriş</a></p>
        </form>
        <form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" id="email" placeholder="E-mail" required/>
          <input type="password" name="pwd" id="pwd" placeholder="Parola" required/>
          <button type="submit" name="login" id="login">Giriş Yap</button>
          <p class="message">Parolamı unuttum:<a href="#" style="color:#ffffff;"> &nbsp; Parolamı Sıfırla!</a></p>
        </form>
      </div>
    </div>
  </div>
</section>
</main>
</body>
</html>