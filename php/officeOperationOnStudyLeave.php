<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/process.php";
include "db/accessUtility/studyleaveapplication.php";
include "util/backendutil.php";
include "db/accessUtility/attachment.php";
include "db/accessUtility/comments.php";
include "file_upload.php";


if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
}

global $ApplicationID;
$ApplicationID = $_POST['ApplicationID'];

global $Comment;
$Comment = $_POST['comments'] . "";
if (strlen($Comment) < 1) {
    $Comment = "";
}

global $ApplicationData;
$ApplicationData = getStudyLeaveApplicationByApplicationID($ApplicationID, $conn);

global $processIDref;
$processIDref = $ApplicationData['ProcessIDref'];

// check if the same person has any previous comments

function handleComments(&$conn)
{
    global $Comment;
    global $processIDref;

    if (strlen($Comment) < 2) {
    } else if (getComment($conn, $_SESSION['UserID'], $processIDref) != null) {
        if (!updateComment($conn, $_SESSION['UserID'], $processIDref, $Comment)) {
            $_SESSION['error'] = "comment update problem OfficeOperationOnStudyLeave_MainTask";
            return false;
        }
    } else if (!createNewComment($conn, $Comment, $_SESSION['UserID'], $processIDref)) {
        $_SESSION['error'] = "comment create problem OfficeOperationOnStudyLeave_MainTask";
        return false;
    }
    return true;
}

function uploadFiles(&$conn, $processIDref)
{
    if (empty($_FILES)) {
        return true;
    }
    if (!file_exists($_FILES['FileUpload']['tmp_name'][0]) || !is_uploaded_file($_FILES['FileUpload']['tmp_name'][0])) {
        return true;
    }
    if(!checkinputFiles()){
        $_SESSION['error'] = "invalid file type";
        return false;
    }
    $uploadDir = "../SiteData/Uploads/";
    foreach ($_FILES['FileUpload']['name'] as $key => $name) {
        // if (!($_FILES['FileUpload']['error'] === UPLOAD_ERR_OK)'') {
        //     // process upload
        //     $_SESSION['error'] = "HTML FILE upload error in officeOperationOnStudyLeave php code";
        //     return false;
        // }
        $fileName = time() . basename($_FILES['FileUpload']["name"][$key]);
        $fileSaveDir = $uploadDir . $fileName;
        $fileSaveDir = str_replace(' ', '', $fileSaveDir);
        if (upload_file("FileUpload", $key, $fileSaveDir)) {
            $inputData['ProcessIDref'] = $processIDref;
            $inputData['Directory'] = $fileName;
            $inputData['Type'] = 'pdf';
            if (!createAttachment($conn, $inputData)) {
                $_SESSION['error'] = "Create Attachment Error in officeOperationOnStudyLeave php code";
                return false;
            }
        } else {
            $_SESSION['error'] = "File Upload Error in officeOperationOnStudyLeave php code";
            return false;
        }
    }
    return true;
}


function handleHigherStudyBranchCase(&$conn)
{
    global $progressStateType;
    global $ApplicationData;
    $processIDref = $ApplicationData['ProcessIDref'];
    global $ApplicationID;
    if (!handleComments($conn)) {
        $_SESSION['error'] = "comment handle error in handleHigherStudyBranchCase";
        return false;
    }
    if (!uploadFiles($conn, $ApplicationData['ProcessIDref'])) {
        $_SESSION['error'] = "uploadFiles error in handleRegDeptVC";
        return false;
    }
    if ($ApplicationData['ProgressState'] == $progressStateType["RegToHigherStd"]) {

        header("Location:../pages/office_task_assign.php?processID=$processIDref&ApplicationID=$ApplicationID");
    } else if ($ApplicationData['ProgressState'] == $progressStateType["Assigned"]) {
        //AllDeptApproved
        header("Location:../pages/office_task_assign.php?processID=$processIDref&ApplicationID=$ApplicationID&showstatus=1");
    } else if ($ApplicationData['ProgressState'] == $progressStateType["RegToHigherStd2"]) {
        // Approval Page Sabbir's work
    }
    return true;
}

function handleRegDeptVC(&$conn)
{
    global $progressStateType;
    global $ApplicationData;
    $statetrack = null;

    if ($_SESSION['Role'] == 'DepartmentChairman') {   // if it is from dept chairman send it to registrar
        $statetrack = $progressStateType['ChairToReg'];
    } else if ($_SESSION['Role'] == 'ViceChancellor') { // from VC to Registrar
        $statetrack = $progressStateType['VCTOReg'];
    } else if ($_SESSION['Role'] == 'Registrar') {
        $currentState = $ApplicationData['ProgressState'];
        if ($currentState == $progressStateType['ChairToReg']) {    // registrar received it from chairman sending it to higherstudy
            $statetrack = $progressStateType['RegToHigherStd'];
        } else if ($currentState == $progressStateType['VCToReg']) {    // registrar received it from VC sending it to higherstudy
            $statetrack = $progressStateType['RegToHigherStd2'];
        } else if ($currentState == $progressStateType['HigherStdToReg']) { // registrar received it from HigherSTD sending it to VC
            $statetrack = $progressStateType['VCTOReg'];
        }
    }

    if ($statetrack == null) {
        return false;
    }

    global $ApplicationID;
    $inputData['ProgressState'] = $statetrack;
    if (!handleComments($conn)) {
        $_SESSION['error'] = "comment handle error in handleRegDeptVC";
        return false;
    }
    if (!uploadFiles($conn, $ApplicationData['ProcessIDref'])) {
        $_SESSION['error'] = "uploadFiles error in handleRegDeptVC";
        return false;
    }
    if (!updateStudyLeaveApplicationByApplicationID($ApplicationID, $inputData, $conn)) {
        $_SESSION['error'] = "update StudyLeave Application By ApplicationID error in handleRegDeptVC";
        return false;
    }
    return true;
}
function OfficeOperationOnStudyLeave_MainTask(&$conn)
{
    if ($_SESSION['Role'] == 'DRHigherStudyBranchRO') {
        // echo "here";
        return handleHigherStudyBranchCase($conn);
    }
    return handleRegDeptVC($conn);
}
$_SESSION['error'] = "none";
if (OfficeOperationOnStudyLeave_MainTask($conn)) {
    $_SESSION['success'] = "Succcessfully Submitted";
    //header('Location: ../pages/Office_home.php');
} else {
    echo $_SESSION['error'];
}
