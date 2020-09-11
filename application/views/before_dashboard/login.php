<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $pengaturan['nama_aplikasi']; ?> | Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- some styling -->
  <style>
    .bg-login-image {
      background: url("https://mspoweruser.com/wp-content/uploads/2018/11/windowslight.jpg") !important;
    }
  </style>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    Silahkan login terlebih dahulu untuk menggunakan <?php echo $pengaturan['nama_aplikasi']; ?><br /><br />
                    <font color="red">
                      <?php 
                        $session_login = !empty($_SESSION['res_']) ? $_SESSION['res_'] : '';

                        if ($session_login) {
                          echo $session_login.'<br /><br />';

                          unset($_SESSION['res_']);
                        }
                      ?>
                    </font>
                  </div>
                  
                  <form method="post" action="<?php echo base_url(); ?>index.php/login/send_login">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Login" class="btn btn-primary btn-user btn-block" />
                  </form>
                  <hr>

                  <p align="right">Dibuat oleh: <?php echo $pengaturan['pembuat_aplikasi']; ?></p>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

</body>

</html>
