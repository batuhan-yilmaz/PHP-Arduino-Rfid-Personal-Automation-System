<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PERSONEL FİLTRELE | OASIS CONTROL CENTER</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="icon" type="image/png" href="icon/ok_check.png"> -->
    <link rel="stylesheet" type="text/css" href="css/userslog.css">

    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous">
    </script>   
    <script type="text/javascript" src="js/bootbox.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="js/user_log.js"></script>
    <script>
      $(window).on("load resize ", function() {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css({'padding-right':scrollWidth});
    }).resize();
    </script>
    <script>
      $(document).ready(function(){
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
              'select_date': 1,
          }
          }).done(function(data) {
            $('#userslog').html(data);
          });

        setInterval(function(){
          $.ajax({
            url: "user_log_up.php",
            type: 'POST',
            data: {
                'select_date': 0,
            }
            }).done(function(data) {
              $('#userslog').html(data);
            });
        },5000);
      });
    </script>
</head>
<body>
<?php include'header.php'; ?> 
<section class="container py-lg-5">
  <!--User table-->
    <h1 class="slideInDown animated">Günlük Personel Kayıtları</h1>
    <div class="form-style-5">
      <button type="button" data-toggle="modal" data-target="#Filter-export">Kayıtları Filtrele / Excele aktar</button>
    </div>
    <!-- Log filter -->
    <div class="modal fade bd-example-modal-lg" id="Filter-export" tabindex="-1" role="dialog" aria-labelledby="Filter/Export" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg animate" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">Personelleri Filtrele</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="Export_Excel.php" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6 col-sm-6">
                    <div class="panel panel-primary" style="border-color:#ffffff;">
                      <div class="panel-heading"style="border-color:#ffffff;">Tarihler arası tüm kayıtlar:</div>
                      <div class="panel-body"style="border-color:#ffffff;">
                      <label for="Start-Date"><b>Başlangıç Tarihi:</b></label>
                      <input type="date" name="date_sel_start" id="date_sel_start">
                      <label for="End -Date"><b>Bitiş Tarihi:</b></label>
                      <input type="date" name="date_sel_end" id="date_sel_end">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-6">
                    <div class="panel panel-primary" style="border-color:#ffffff;">
                      <div class="panel-heading"style="border-color:#ffffff;">
                          Filtreleme Türleri:
                        <div class="time" style="border-color:#ffffff;">
                          <input type="radio" id="radio-one" name="time_sel" class="time_sel" value="Time_in" checked/>
                          <label for="radio-one">Giriş</label>
                          <input type="radio" id="radio-two" name="time_sel" class="time_sel" value="Time_out" />
                          <label for="radio-two">Çıkış</label>
                        </div>
                      </div>
                      <div class="panel-body" style="border-color:#ffffff;">
                        <label for="Start-Time"><b>Başlangıç Saati:</b></label>
                        <input type="time" name="time_sel_start" id="time_sel_start">
                        <label for="End -Time"><b>Bitiş Saati:</b></label>
                        <input type="time" name="time_sel_end" id="time_sel_end">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4 col-sm-12">
                    <label for="Fingerprint"><b>Personeller:</b></label>
                    <select class="card_sel" name="card_sel" id="card_sel">
                      <option value="0">Tüm Personeller</option>
                      <?php
                        require'connectDB.php';
                        $sql = "SELECT * FROM users WHERE add_card=1 ORDER BY id ASC";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo '<p class="error">SQL Error</p>';
                        } 
                        else{
                            mysqli_stmt_execute($result);
                            $resultl = mysqli_stmt_get_result($result);
                            while ($row = mysqli_fetch_assoc($resultl)){
                      ?>
                              <option value="<?php echo $row['card_uid'];?>"><?php echo $row['username']; ?></option>
                      <?php
                            }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-lg-4 col-sm-12">
                    <label for="Device"><b>Departman:</b></label>
                    <select class="dev_sel" name="dev_sel" id="dev_sel">
                      <option value="0">Tüm Departmanlar</option>
                      <?php
                        require'connectDB.php';
                        $sql = "SELECT * FROM devices ORDER BY device_dep ASC";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo '<p class="error">SQL Error</p>';
                        } 
                        else{
                            mysqli_stmt_execute($result);
                            $resultl = mysqli_stmt_get_result($result);
                            while ($row = mysqli_fetch_assoc($resultl)){
                      ?>
                              <option value="<?php echo $row['device_uid'];?>"><?php echo $row['device_dep']; ?></option>
                      <?php
                            }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-lg-4 col-sm-12">
                    <label for="Fingerprint"><b>Excel aktar:</b></label>
                    <input type="submit" name="To_Excel" value="Aktar!">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" name="user_log" id="user_log" class="btn btn-success">Filtrele</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- //Log filter -->
    <div class="slideInRight animated">
      <div id="userslog"></div>
    </div>
</section>
</main>
</body>
</html>
