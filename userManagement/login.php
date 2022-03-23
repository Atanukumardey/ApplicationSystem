<?php
include "../php/user_type.php";
include "../php/session/session.php";
include "../php/util/pageutil.php";

sessionStart(0, '/', 'localhost', true, true);

if (isset($_SESSION['Email']) && isset($_SESSION['RoleID'])) {
  header('Location: logout.php');
}
if (!isset($_SESSION['Role'])) {
  header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>University of Chittagong</title>
  <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">

  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/log_reg_footer.css">
  <link rel="stylesheet" href="../css/login_signup.css">
  <script src="../js/sweetalert2.min.js"></script>

</head>

<body style="overflow-x: hidden;">

  <?php
  if (isset($_SESSION['error'])) {
    popupMessage('error', $_SESSION['error'], 'Try Again');
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
    popupMessage('success', $_SESSION['success'], 'Ok');;
    unset($_SESSION['success']);
  }
  ?>

  <div class="wrapper">
    <!-- Sidebar Holder -->
    <!-- Page Content Holder -->
    <div id="content">
      <div class="row" align="center">
        <div class="col-0 col-sm-3 col-md-4 col-lg-4 col-xl-4"></div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
          <a href="../index.php">
            <img style="margin-top: 10px;" src="../assets/image/culogolightblue_lite.png" width="50" />

            <h4 style="margin-top: 10px;color: black;">University of Chittagong</h4>
          </a>
          <h5>Application system</h5>
        </div>
        <div class="col-0 col-sm-3 col-md-4 col-lg-4 col-xl-4"></div>
      </div>

      <div class="pagecontent">
        <div class="row">
          <div class="col-0 col-sm-1 col-md-2 col-lg-3">
          </div>
          <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card">
              <div class="row">
                <div class="card-body" style="padding-bottom:0px;">
                  <h5 style="text-align: center;">Please Login</h5>
                  <hr style="margin-bottom: 0px; padding-bottom: 0px;">
                  <div class="row" style="padding: 15px;">
                    <form style="width: 100%;" id="login_form" method="post" action="../php/check_login.php">
                      <div class="col-12 col-sm-12 col-md-12 form-group">
                        <label>* Your Email Address</label>
                        <input id="email" type="email" name="user_email" placeholder="name@gmail.com" class="form-control" required>
                      </div>

                      <div class="col-12 col-sm-12 col-md-12 form-group">
                        <label>* Password</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                      </div>

                      <?php
                      if (isset($_SESSION['Role']) && checkUser($_SESSION['Role'])) {
                        include('../html/office_login_list.html');
                      } else {
                      ?>
                        <input type='hidden' name='role' value=<?= json_encode($_SESSION['Role']) ?>>
                      <?php
                      }
                      ?>
                      <div class="" style="text-align:center">
                        <button type="submit" class="btn btn-success">Login</button>
                      </div>
                      <div class="" style="text-align:center">
                        <div class="forgot login-footer">
                          <span>Looking to <a href='signup.php'">create an account?</a></button></span>
                        </div>
                        <div class=" forgot login-footer"><a href='recover.php'>Forgot Password?</a></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-0 col-sm-1 col-md-2 col-lg-3">
          </div>
        </div>
        <div class="row" style="margin-bottom: 15px; ">
          <div class="col-0 col-sm-1 col-md-3">
          </div>
          <div class="col-0 col-sm-1 col-md-3">
          </div>
        </div>
      </div> <!-- end of pagecontent-->
    </div>
  </div>
  <?php include('../html/footer.html'); ?>
  <!-- Footer - Start -->
</body>

</html>