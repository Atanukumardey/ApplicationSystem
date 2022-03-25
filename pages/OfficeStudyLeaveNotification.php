<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/Users.php";
include "../php/db/accessUtility/personalInfo.php";
include "../php/session/session.php";
include "../php/db/accessUtility/process.php";
include "../php/db/accessUtility/nocApplication.php";
include "../php/util/backendutil.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">
    <style>
        id {
            color: rgba(168, 197, 206, 0.945);
            color: rgba(red, green, blue, alpha);
        }
    </style>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Application</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
        <link rel=" stylesheet" href="../css/Applicant/profile.css">
        <link rel="stylesheet" href="../css/user_home_style.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">
    </head>

    <body>
        <?php
        include("../html/pageNavbar.php");
        // $ApplicantspersonalData = getPersonalInfo($_GET['ApplicantID'], $conn);
        // $ApplicantUserData = getUserByUserID($_GET['ApplicantID'], $conn);
        ?>
        <div class="container rounded mt-5 mb-2 " style="background-color:  rgb(232, 241, 241); max-width: auto;">
            <div class="stdofficenoti" style="display: flex;flex-direction:row;justify-content:space-between;">
                <div style="padding-top: 20px;display: flex;">
                    <div class="logo">
                        <img src="../assets/image/culogolightblue_lite.png" alt="logo" style="height: 90%;">
                    </div>
                    <div class="main-title" style="padding-top: 12px;">
                        <h3>REGISTRAR OFFICE</h3>
                        <h7>UNIVERSITY OF CHITTAGONG</h7>
                        <p>CHITTAGONG-4331,BANGLADESH</p>
                    </div>
                </div>
                <div style="padding-top: 20px;display: flex;">
                    <div class="main-title">
                        <h5>চট্টগ্রাম বিশ্ববিদ্যালয়,চট্টগ্রাম,বাংলাদেশ</h5>
                        <b>Phone:</b> A B X 714923
                        <br>
                        <b>Aulo:</b>716552,716558,726311-14,
                        2606001-10,<br>2601013,2601141,2601278,2601304
                        <br>
                        <b>ExIn-Off:</b>4201
                        <br>
                        <b>Fax:</b> 880-31-726310
                        <br><b>E-mail:</b> vc.cu66@yahoo.com<br>
                        registrar_cu@yahoo.com
                    </div>
                </div>
            </div>
            <hr>
            <div id="notification" style=" text-align:center">
                <br>
                <h2>ছাড়পত্র</h2>
                <br>
            </div>
            <div style="margin-left:50px">
                <div>
                    <p>জনাব,</p>
                    <p>আপনার সদয় আবগতির জন্য জানানো যাচ্ছে যে, আত্র বিশ্ববিদ্যালয়ের কম্পিউটার বিজ্ঞান ও প্রকৌশল বিভাগের (সহযোগী অধ্যাপক) (জনাব রুদ্র প্রতাপ দেবনাথ) (১৩-০৮-২০১৪ইং)
                        তারিখ হতে অধ্যয়ন ছুটি মঞ্জুরীর জন্য দরখাস্ত পেশ করেছেন।
                    </p>
                    <p>
                        উপরোক্ত অবস্থার পরিপ্রেক্ষিতে তার কাছে আপনার বিভাগের/কেন্দ্রের/দপ্তরের কোন পাওনা কিংবা দায় দায়িত্ব আছে কিনা তা জরুরী ভিত্তিতে জানানোর
                        জন্য আপনাকে অনুরোধ করা হচ্ছে।
                    </p>
                </div>
                <!-- style="display:flex;flex-direction:column;justify-content:space-around;" -->
                <div class="row">
                    <div class=" col-md-12">
                        ধন্যবাদান্তে,
                    </div>
                    <div class="col-md-12">
                        <p>
                            আপনার বিশ্বস্ত,
                            <br>
                            (নাম)
                            <br>
                            ডেপুটি রেজিস্ট্রার (উচ্চশিক্ষা)
                            <br>
                            চট্টগ্রাম বিশ্ববিদ্যালয়
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container rounded mt-5 mb-2 " style="background-color:  rgb(232, 241, 241); width: auto;">
            <div class="row" style="font-size:large;">
                <b>
                    Please leave any necessary comments accroding to your action(proceed/reject) in this box. Respective personals will be informed with this given information.
                </b>
            </div>
            <div class="row">
                <form id="deptcomment">
                    <textarea rows="5" cols="60" name="comments" style="width:45vw" form="deptcomment">
                    </textarea>
                </form>
            </div>
        </div>
        <div class="container rounded mb-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Proceed</button></div>
                </div>
                <div class="col-md-6">
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="reset" id="resetBtn">Reject</button></div>
                </div>
            </div>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>