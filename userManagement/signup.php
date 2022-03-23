<?php
include "../php/user_type.php";
include "../php/session/session.php";
include "../php/util/pageutil.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Role'])) {
    header('Location: ../index.php');
}
if (isset($_SESSION['Email']) && isset($_SESSION['RoleID'])) {
    header('Location: logout.php');
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
                    <h5>Application System</h5>
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
                                    <h5 style="text-align: center;">Sign-Up</h5>
                                    <hr style="margin-bottom: 0px; padding-bottom: 0px;">
                                    <div class="row" style="padding: 15px;">
                                        <form style="width: 100%;" id="login_form" method="post" action="../php/store_user_signup_data.php">
                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label for="user_name">* First Name</label>
                                                <input class="form-control" id="user_name" type="text" name="user_first_name" required>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label for="user_name"> Middle Name</label>
                                                <input class="form-control" id="user_name" type="text" name="user_middle_name">
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label for="user_name">* Last Name</label>
                                                <input class="form-control" id="user_name" type="text" name="user_last_name" required>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label>* Email Address
                                                    <?php if ($_SESSION['Role'] === "Applicant") echo "(We will use this email for any future communication with you.)"; ?>
                                                </label>
                                                <input class="form-control" id="user_email" type="email" name="user_email" placeholder="name@gmail.com" required>
                                            </div>

                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label>* Contact Number
                                                    <?php if ($_SESSION['Role'] === "Applicant") echo "(We will use this number for any future communication with you.)"; ?>
                                                </label>
                                                <input class="form-control" id="contact_number" type="text" name="contact_number" palceholder="+88" required>
                                            </div>

                                            <?php if (isset($_SESSION['Role']) && checkUser($_SESSION['Role'])) { ?>
                                                <div class="col-12 col-sm-12 col-md-12 form-group">
                                                    <?php include('../html/office_login_list.html'); ?>
                                                </div>
                                            <?php } else { ?>
                                                <input id="role" type="hidden" name="role" value='<?php echo $_SESSION['Role'] ?>' class="form-control">
                                            <?php } ?>

                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label>* Password</label>
                                                <input class="form-control" id="password" type="password" name="password" required>
                                            </div>

                                            <div class="col-12 col-sm-12 col-md-12 form-group">
                                                <label>* Confrim Password</label>
                                                <input class="form-control" id="cpassword" type="password" name="cpassword" required>
                                            </div>

                                            <div class="" style="text-align:center">
                                                <button type="submit" class="btn btn-primary">Signup</button>
                                            </div>
                                            <div class="" style="text-align:center">
                                                <div class="forgot login-footer">
                                                    <span>Already have an account?<a href='login.php'">Login</a></button></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-0 col-sm-1 col-md-2 col-lg-3">
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