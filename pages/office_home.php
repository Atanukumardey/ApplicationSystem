<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/nocApplication.php";
include "../php/db/accessUtility/studyleaveapplication.php";
include "../php/db/accessUtility/process.php";
include "../php/session/session.php";
include "../php/util/pageutil.php";
include "../php/util/backendutil.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])|| $_SESSION['Role'] == 'Applicant') {
    header('Location: ../index.php');
}

else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
        <link href="../css/floatingnavbar.css" rel="stylesheet">
        <link href="../css/mfb.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/user_home_style.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">


        <script src="../js/sweetalert2.min.js"></script>
        <script src="../js/modernizr.touch.js"></script>
        <script src="../js/dragable.js"></script>
        <title>Home</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">


    </head>

    <body style="overflow-x: hidden;">
        <?php
        // print_r($_SESSION);
        if (isset($_SESSION['error'])) {
            //echo "<br>"."error"."<br>";
            popupMessage('error', $_SESSION['error'], 'Ok');
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            popupMessage('success', $_SESSION['success'], 'Continue');;
            unset($_SESSION['success']);
        }
        ?>
        <div style="padding-left: 5px;">
            <?php
            include("../html/pageNavbar.php");
            if (!isset($_SESSION['logedIN'])) {
                loginSuccess();
                $_SESSION['logedIN'] = true;
            }
            ?>
        </div>

        <?php
        /**
         * NavbarData
         *      -- row
         *          -- link
         *          -- text 
         *          -- icon
         */
        $NavbarData = array();
        $linkArrayIndex = 0;
        if ($_SESSION['Role'] == "Registrar") {
            $NavbarData[$linkArrayIndex++] = array('link' => 'office_home.php?application=nocpassport', 'text' => 'NOC', 'icon' => 'fa fa-passport');
        }
        $NavbarData[$linkArrayIndex++] = array('link' => 'office_home.php?application=studyleave', 'text' => 'Study Leave', 'icon' => 'fa fa-graduation-cap');
        if ($_SESSION['Role'] == "Registrar" || $_SESSION['Role'] == "DepartmentChairman") {
            $NavbarData[$linkArrayIndex++] = array('link' => 'office_home.php?application=leaveofabsence', 'text' => 'Leave Of Absence', 'icon' => 'fa fa-location-arrow');
        }
        $NavbarData[$linkArrayIndex++] = array('link' => '../userManagement/logout.php', 'text' => 'LogOut', 'icon' => 'fa fa-sign-out-alt');

        createFloatNavbar($NavbarData);
        ?>
        <div class="c_container" style="margin-left:20px">
            <?php
            if (isset($_GET['application'])) {
                if ($_GET['application'] == 'nocpassport') {
                    createNOCsection($conn);
                } else if ($_GET['application'] == 'studyleave') {
                    createStudyLeavesection($conn);
                }
                unset($_GET['application']);
            } else {
                if ($_SESSION['Role'] == "Registrar") {
                    createNOCsection($conn);
                } else {
                    createStudyLeavesection($conn);
                }
            }
            ?>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>


<?php

function createApplicationSection($Application, $applicationdata)
{ ?>
    <h3 style="padding-left: 20px; padding-top: 20px;"><?= $Application['status'] ?></h3>
    <div class="applicationformsupdate">
        <?php
        if ($applicationdata != null) {
            foreach ($applicationdata as $row) {
                $row['ApplicationName'] = $Application['Name'];
                //$row['ApplicationName'] = "Study Leave";
                //return;
                createApplicationUpdateTile($row, $Application);
            }
        } else {
            echo "Not Available.";
        }
        ?>
    </div>
<?php }

function createApplicationUpdateTile($Applicationdata, $Application)
{
?>
    <div class="applicationupdatecard">
        <div class="card-body" style="display: flex; flex-direction:row; justify-content:space-between">
            <div class="row">
                <i class="<?= $Application['icon'] ?>" style="color:rgb(29, 70, 158)"></i>
            </div>
            <h4 class="card-text" style="width: max-content;"><?= $Applicationdata['ApplicationName'] ?></h4>
            <p style="width: max-content;"> Application Date: <?= $Applicationdata['ApplicationDate']; ?> </p>
            <div>
                <form action="<?= $Application['location'] ?>" method="get" class="col" style="height: inherit;">
                    <button type="submit" name=<?= json_encode($Application['IDName']) ?> value="<?= $Applicationdata[$Application['IDName']]; ?>" class=" btn-primary btn-sm" style="padding-right: 20px; width:inherit; height:auto;" method="get" ">Details</button>
                    <input type = 'hidden' name='ApplicantID' value=" <?= $Applicationdata['UserIDref']; ?>">
                </form>
            </div>
        </div>
    </div>

<?php
}


function createNOCsection(&$conn)
{
?>
    <h2 style="padding-left: 10px; padding-top: 20px;">NOC Applications</h2>
    <?php
    $Application['status'] = "New Applications";
    $Application['Name'] = "No Objection Certificate";
    $Application['IDName'] = "NocID";
    $Application['icon'] = "fa fa-passport fa-3x";
    $Application['location'] = "nocapplication_check_office.php";

    if ($_SESSION['Role'] == 'Registrar') {
        $applicationData = getnocApplicationsByProgressState($conn, 'NotAssigned');
        createApplicationSection($Application, $applicationData);
        $Application['status'] = "InProgress Applications";
        $applicationData = getnocApplicationsByProgressState($conn, 'InProgress');
        createApplicationSection($Application, $applicationData);
    }
    // } else {
    //     $applicationData = getnocProcessByDepartment($conn, "Assigned", $_SESSION['Department']);
    //     createApplicationSection($Application, $applicationData);
    //     $Application['status'] = "Inprogress Applications";
    //     $applicationData = getnocProcessByDepartment($conn, "Inprogress", $_SESSION['Department']);
    //     createApplicationSection($Application, $applicationData);
    // }
}


function createStudyLeavesection(&$conn)
{
    ?>
    <h2 style="padding-left: 10px; padding-top: 20px;">Study Leave Applications</h2>
<?php
    global $progressStateType;
    $Application['status'] = "New Applications";
    $Application['Name'] = "Study Leave Applications";
    $Application['IDName'] = "ApplicationID";
    $Application['icon'] = "fa fa-graduation-cap fa-3x";
    $Application['location'] = "officeCheckStudyLeave.php";
    $progressState = array();
    $stateStatus = array();
    /**
     * Registrar has three state for this application
     */
    if ($_SESSION['Role'] == 'Registrar') {

        $progressState[0] = $progressStateType['ChairToReg'];
        $stateStatus[0] = "From Department Chairman";

        $progressState[1] = $progressStateType['HigherStdToReg'];
        $stateStatus[1] = "From Higher Study Department";

        $progressState[2] = $progressStateType['VCToReg'];
        $stateStatus[2] = "From Vice Chancellor";

        for ($i = 0; $i < 3; $i++) {
            $applicationData = getStudyLeaveApplicationByProgressState($progressState[$i], $conn);
            if ($applicationData != null) {
                $Application['status'] = $stateStatus[$i];
                createApplicationSection($Application, $applicationData);
            }
        }
    } else if ($_SESSION['Role'] == 'DepartmentChairman') { // first one to get a new application
        $progressState = $progressStateType['NotAssigned'];
        $applicationData = getStudyLeaveApplicationByProgressState($progressState, $conn);
        if ($applicationData != null) {
            $Application['status'] = "New Applications";
            createApplicationSection($Application, $applicationData);
        }
    } else if ($_SESSION['Role'] == 'ViceChancellor') {
        $progressState = $progressStateType['RegToVC'];
        $applicationData = getStudyLeaveApplicationByProgressState($progressState, $conn);
        if ($applicationData != null) {
            $Application['status'] = "New Applications";
            createApplicationSection($Application, $applicationData);
        }
    } else if ($_SESSION['Role'] == "DRHigherStudyBranchRO") {
        $progressState[0] = $progressStateType['RegToHigherStd2'];
        $stateStatus[0] = "From Registrar(Final Approval)";
        $progressState[1] = $progressStateType['AllDeptApproved'];
        $stateStatus[1] = "All Department Approved";
        $progressState[2] = $progressStateType['RegToHigherStd'];
        $stateStatus[2] = "From Registrar(Initial State)";
        $progressState[3] = $progressStateType['HigherStdToDept']; // HSTD has assigned the application to other departments for approvaln
        $stateStatus[3] = "Assigned To Departments";
       // echo $progressState[3];
        for ($i = 0; $i < 4; $i++) {
            $applicationData = getStudyLeaveApplicationByProgressState($progressState[$i], $conn);
            if ($applicationData != null) {
                $Application['status'] = $stateStatus[$i];
                createApplicationSection($Application, $applicationData);
            }
        }
    } else {
        $Application['location'] = "officeStudyLeaveNotification.php";
        $Application['status'] = "New Applications";
        //echo $_SESSION['Role'];
        $applicationData = getstudyleaveProcessByDepartment($conn, "Assigned", $_SESSION['Role']);
        createApplicationSection($Application, $applicationData);
        $Application['status'] = "Inprogress Applications";
        $applicationData = getstudyleaveProcessByDepartment($conn, "InProgress", $_SESSION['Role']);
        createApplicationSection($Application, $applicationData);
    }
}
?>