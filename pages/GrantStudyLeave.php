<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/Users.php";
include "../php/db/accessUtility/personalInfo.php";
include "../php/session/session.php";
include "../php/db/accessUtility/process.php";
include "../php/db/accessUtility/nocApplication.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
} else {
    // if (isset($_GET['submit']) && $_GET['submit'] == 'Approve') {
    //     $inputData[$_SESSION['Department']] = 4; // Approved in processstatus;
    //     // edit needed
    //     //print_r($_GET);
    //     echo "<br><br>";
    //     ///print_r($inputData);
    //     $NocData = getnocApplicationsByNocID($_GET['NocID'], $conn);
    //     foreach ($NocData as $key => $value) {
    //         echo "<br>'$value'<br>";
    //     }
    //     $processID = $NocData['ProcessIDref'];
    //     echo "<br><br>";
    //     if (updateProcess($processID, $inputData, $conn)) {
    //         $_SESSION['success'] = 'Approved';
    //         header('Location: office_home.php');
    //     }
    // }

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
        <div class="container rounded mt-5 mb-2 " style="background-color:  rgb(232, 241, 241);">
            <div class="stdofficenoti" style="display: flex;flex-direction:row;justify-content:space-between;">
                <div style="padding-top: 20px;display: flex;">
                    <div class="logo">
                        <img src="../assets/image/culogolightblue_lite.png" alt="logo" style="height: 90%;">
                    </div>
                    <div class="main-title" style="padding-top: 12px;">
                        <h3><b>রেজিস্ট্রার অফিস</b></h3>
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

            <div style="margin-left:50px">
            <b>
                Memo. No.AS-2421/&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;/Ganl. &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Dated: 04-09-2014
                <br>
                <br>Mr. Rudra Pratap Deb Nath
                <br>Lecturer
                <br>Department of Computer Science & Engineering
                <br>Chittagong University
                <br>Chittagong, Bangladesh.
            </b>
            </div>

            <div id="notification" style=" text-align:center">
                <br>
                <h3><u>Sub: Grant of Study Leave & Release Order.</u></h3>
                <br>
            </div>
            <div style="margin-left:50px">
                <div>
                    <p>Dear Sir, <br>
                        &emsp;&emsp;&emsp;With reference to your application dated 13-08-2014 on the above mentioned subject. I am directed to inform you that In partial modification of this Office Letter No AS-2141/5545/Genl. dated 13 * 98 - 201 you have been granted Study Leave on full average pay for (one) year, with effect from 5-09*201. instead of 13-08-2014 for your study towards Ph.D Programme at the Aalborg University, Denmark, and that you have been released from this University for the purpose.
                    </p>

                    <p>
                        &emsp;&emsp;&emsp;Further, I am directed to inform you that in pursuance of the authority delegated from the Office of the Hon'ble Prime Minister. Government of the People's Republic of Bangladesh, vide Memo.No. 03.069.025.06.00.003.2011-144(500) dated 19-06-2011 (copy enclosed), the Vice-Chancellor has been pleased to allow you to proceed to USA for the purpose.
                    </p>

                    <p>
                        &emsp;&emsp;&emsp;Further, I am directed to inform you that 10(ten) percent of your Monthly Basic Pay to be drawn by you during the period of your Study Leave for the above mentioned purpose will be deposited University Account and that the total amount, so deposited, will be refunded to you according to the terms & conditions of the Service Bond executed by you with this University.
                    </p>

                    <p>
                        &emsp;&emsp;&emsp;The University of Chittagong or the Govt. of Bangladesh will have no financial responsibilities for your proposed study in Denmark.
                    </p>

                    <p>
                        &emsp;&emsp;&emsp;In this regard, I would request you to apply 3(three) months before expiry of the above leave, in case you need extension of your leave, that will depend upon Satisfactory Progress Report from your Course Supervisor, Opinion of the Departmental (CU) Planning Committee and consents of the Surety Holders who signed in the Surety Bond at the time of your going on Study Leave OR to return from abroad and join your duties at this University, within 14-09-2015. You should also take prior permission from this University for any change of Course Field of Study or Institution, along with proper documents.
                    </p>

                    <p>
                        &emsp;&emsp;&emsp;Thanking you,
                    </p>

                    <div class="sign" style="display:flex; flex-direction:row-reverse;">
                        <div class="sign" style="text-align: center;">
                            <br>Yours sincerely
                            <br><b>Sd/-
                                <br>(Engr. Md. Alamgir Chowdhury)
                                <br>Registrar</b>
                            <br><sub>(In-charge)</sub>
                            <br>University of Chittagong.
                            <br> <b> Dated: 04-09-2014 </b>
                        </div>
                    </div>

                </div>
            </div>

            <div style="margin-left:50px">
                <p>
                    <b> Memo. No.AS-2141/...../Ganl. </b>
                    <br> Copy forwarded for information & necessary action to: -
                    <br> 1. &emsp;&emsp;&nbsp;The Chairman, Department of Computer Science& Engineering, C.U.
                    <br> 2. &emsp;&emsp;&nbsp;he Inspector of College(I/C), C.U.
                    <br> 3. &emsp;&emsp;&nbsp;The controller of Accounts (I/C), C.U. with a request to deposit in the Chittagong University Account, 10% of Monthly Basic Pay of Mr. Rudra Pratap Deb Nath, Lecturer,
                    <br>&emsp;&emsp;&emsp;&nbsp;Department of Computer Science & Engineering, C.U. to be drawn during the period of his Study Leave.
                    <br> 4. &emsp;&emsp;&nbsp;The Librarian (I/C), C.U.
                    <br> 5. &emsp;&emsp;&nbsp;The Controller of Examination (I/C), C.U.
                    <br> 6. &emsp;&emsp;&nbsp;The Chief Medical Officer, C.U.
                    <br> 7. &emsp;&emsp;&nbsp;The Chief Engineer, C.U.
                    <br> 8. &emsp;&emsp;&nbsp;The Director, p&D, C.U.
                    <br> 9. &emsp;&emsp;&nbsp;The Deputy Registrar, Election Cell, Registrar's Office, C.U.
                    <br> 10. &emsp;&nbsp;&nbsp;&nbsp;Officer in Charge, General Leave Section, Registrar's Office, C.U.
                    <br> 11. &emsp;&nbsp;&nbsp;&nbsp;The Deputy Registrar, Teacher's Cell, Registrar's Office, C.U.
                    <br> 12. &emsp;&nbsp;&nbsp;&nbsp;The Deupty Registrar, Confidential Cell, Registrar's Office, C.U.
                    <br> 13. &emsp;&nbsp;&nbsp;&nbsp;The Deputy Registrar (Computer), VC Office, C.U.
                    <br> 14. &emsp;&nbsp;&nbsp;&nbsp;The Secretary, Ministry of Education, Govt of the People's Republic of Bangladesh, Bangladesh Secretariat, Dhaka.
                    <br> 15. &emsp;&nbsp;&nbsp;&nbsp;The Secretary, Ministry of Public Adminstration, Govt. of the People's Republic of Bangladesh, Bangladesh Secretariat, Dhaka.
                    <br> <br>
                </p>
            </div>
        </div>


        <br>
        <br>

    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>