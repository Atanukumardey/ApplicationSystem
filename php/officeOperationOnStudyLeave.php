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
    header('Location: ../index.php');
}

$ApplicationID = $_POST['ApplicationID'];
global $Comment;
$Comment = $_POST['comments'];

global $ApplicationData;
$ApplicationData = getStudyLeaveApplicationByApplicationID($ApplicationID, $conn);

global $processIDref;
$processIDref = $ApplicationData['ProcessIDref'];

echo $ApplicationID . "<br>";
echo $Comment . "<br>";
echo $processIDref;

// check if the same person has any previous comments

function handleComments(&$conn)
{
    global $Comment;
    global $processIDref;
    if (getComment($conn, $_SESSION['UserID'], $processIDref) != null) {
        if (!updateComment($conn, $_SESSION['UserID'], $processIDref, $Comment)) {
            $_SESSION['error'] = "comment update problem OfficeOperationOnStudyLeave_MainTask";
            return false;
        }
    } else {
        if (!createNewComment($conn, $Comment, $_SESSION['UserID'], $processIDref)) {
            $_SESSION['error'] = "comment create problem OfficeOperationOnStudyLeave_MainTask";
            return false;
        }
    }
    return true;
}

function uploadFiles(&$conn)
{
    global $processIDref;
    $uploadDir = "../SiteData/Uploads/";
    foreach ($_FILES['FileUpload']['name'] as $key => $name) {
        if ($_FILES['ufile']['error'] != UPLOAD_ERR_OK) {
            // process upload
            $_SESSION['error'] = "HTML FILE upload error in officeOperationOnStudyLeave php code";
            return false;
        }
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
}

global $progressStateType;
$progressStateType = array(
    'Assigned' => 1,
    'InProgress' => 2,
    'Problem' => 3,
    'Approved' => 4,
    'Rejected' => 5,
    'NotAssigned' => 6,
    'ChairToReg' => 7,
    'RegToHigherStd' => 8,
    'HigherStdToDept' => 9,
    'HigherStdToReg' => 10,
    'RegToVC' => 11,
    'VCToReg' => 12,
    'RegToHigherStd2' => 13
);

function OfficeOperationOnStudyLeave_MainTask(&$conn)
{
    global $progressStateType;
    global $ApplicationData;
    if ($_SESSION['Role'] == 'DRHigherStudyBranchRO') {
    }

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

    if($statetrack==null){
        return false;
    }
    


    // if(||'||) {
    //     handleComments($conn);
    //     uploadFiles($conn);
    // }
}
