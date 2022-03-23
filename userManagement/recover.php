<?php
include "../php/user_type.php";
include "../php/session/session.php";
include "../php/util/pageutil.php";
include "../php/db/database_connect.php";
include "../php/db/accessUtility/Users.php";
include "../php/db/dbAccessUtility.php";
include "../php/email.php";

sessionStart(0, '/', 'localhost', true, true);


if (isset($_SESSION['Email']) && isset($_SESSION['RoleID'])) {
    header('Location: logout.php');
}
if (!isset($_SESSION['Role'])) {
    header('Location: ../index.php');
}

if (isset($_POST['continuebtn'])) {
    $email = $_POST['user_email'];
    $phone = $_POST['phone_number'];

    $data = getUserByUserEmailandPhoneNumber($email, $phone, $conn);
    if ($data == false) {
        $_SESSION['error'] = "Email Or Password Dosen't exists";
    } else if ($data != null) {
        $_SESSION['Email'] = $data['Email'];
        if (!handleOtpTask($data['UserID'], $conn)) {
            $_SESSION['error'] = "System Encountered Error";
        } else {
            $_SESSION['UserID'] = $data['UserID'];
            $_SESSION['Email'] = $data['Email'];
            $_SESSION['recover_Password_valid_user'] = true;
            $_SESSION['success'] = "OTP is sent to your email. Please Confrim it.";
        }
    }
}
recoverPassword($conn);


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
    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->

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
                                    <h5 style="text-align: center; margin-bottom:30px;">Recovery Password</h5>
                                    <hr style="margin-bottom: 0px; padding-bottom: 0px;">
                                    <div class="row" style="padding: 15px;">
                                        <form style="width: 100%;" id="login_form" method="post" action="#">
                                            <?php
                                            $submit_button_text = 'continuebtn';
                                            if (isset($_SESSION['recover_Password_valid_user'])) {
                                                $label['first'] = "* New Password";
                                                $name['first'] = "password";
                                                $type['first'] = "password";
                                                $type['second'] = "password";
                                                $label['second'] = "* Confrim Password";
                                                $name['second'] = "cpassword";
                                                createPageTile($label, $name, $type);
                                                $submit_button_text = 'recovery_update_btn';
                                            } else {

                                                $label['first'] = "* Your Email Address";
                                                $name['first'] = "user_email";
                                                $label['second'] = "* Your Phone Number";
                                                $name['second'] = "phone_number";
                                                $type['first'] = "email";
                                                $type['second'] = "text";
                                                createPageTile($label, $name, $type);
                                            }

                                            ?>
                                            <div class="" style="text-align:center">
                                                <button name=<?= json_encode($submit_button_text) ?> type="submit" class="btn btn-success">Continue</button>
                                            </div>
                                            <div class="" style="text-align:center">
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

<?php

function createPageTile($lable, $name, $type)
{

    if (isset($_SESSION['recover_Password_valid_user'])) {
        unset($_SESSION['recover_Password_valid_user']);
?>
        <div class="col-12 col-sm-12 col-md-12 form-group">
            <label>** Enter OTP</label>
            <input id="password" type="text" name='otp' placeholder="Enter OTP" class="form-control" required>
        </div>
    <?php
    }
    ?>
    <div class="col-12 col-sm-12 col-md-12 form-group">
        <label><?= $lable['first'] ?></label>
        <input id="email" type=<?= json_encode($type['first']) ?> name=<?= json_encode($name['first']) ?> placeholder="Enter email address" class="form-control" required>
    </div>
    <div class="col-12 col-sm-12 col-md-12 form-group">
        <label><?= $lable['second'] ?></label>
        <input id="password" type=<?= json_encode($type['second']) ?> name=<?= json_encode($name['second']) ?> placeholder="Enter phone number" class="form-control" required>
    </div>
<?php

}



function handleOtpTask($UserID, &$conn)
{
    $OTP = rand(555555, 99999999);
    $data['RecoveryOtp'] = $OTP;
    secureInput($OTP, $conn);
    if (updateUser($UserID, $data, $conn)) {
        $subject = "OTP For Password Recovery";
        $body = "Hi, there here is your OTP for password recovery-'$OTP'";
        if (sendEmail($_SESSION['Email'], $subject, $body)) {
            return true;
        }
    }
    return false;
}


function recoverPassword(&$conn)
{
    if (isset($_POST['recovery_update_btn'])) {
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $otp = $_POST['otp'];

        $userdata = getUserByUserID($_SESSION['UserID'], $conn);
        if ($userdata == null || $userdata == false) {
            $_SESSION['error'] = "System Encountered Error";
            return;
        }
        $OTP = $userdata['RecoveryOtp'];

        if ($OTP != $otp) {
            $_SESSION['error'] = "OTP Dosen't match";
            $_SESSION['recover_Password_valid_user'] = true;
        } else if ($password != $cpassword) {
            $_SESSION['error'] = "Both Password Dosen't match";
            $_SESSION['recover_Password_valid_user'] = true;
        } else {
            $data['Password'] = $password;
            if (!updateUser($_SESSION['UserID'], $data, $conn)) {
                $_SESSION['error'] = "System Encountered Error";
            } else {
                $_SESSION['success'] = "Password Reset Successful.";
                header("Location: logout.php");
            }
        }
    }
}


?>