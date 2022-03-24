<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/process.php";
include "db/accessUtility/studyleaveapplication.php";
include "util/backendutil.php";
include "db/accessUtility/attachment.php";
include "file_upload.php";

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] != 'Applicant') {
    header('Location: ../index.php');
}


//print_r($_POST);

/**
 * 1. Check for files Validity
 * 2. Create a empty process
 * 3. Create study leave
 * 4. Upload files
 * 5. Create attachments
 */

function checkinputFiles()
{
    $allowedFileType = array("pdf");
    $status = fileValidityCheck("FileUpload", $allowedFileType);
    if ($status == false) {
        return false;
    }
    return true;
}
function createANewSLA($processIDref, &$conn)
{
    $inputData['ApplicationDate'] = date("Y-m-d");
    $inputData['NameOfProgram'] = $_POST['NameOfProgram'];
    $inputData['University'] = $_POST['University'];
    $inputData['Department'] = $_POST['Department'];
    $inputData['FinincialSource'] = $_POST['FinancialSource'];
    $inputData['StartsFrom'] = $_POST['ProgramStartDate'];
    $inputData['ProgramDuration'] = $_POST['ProgramDuration'];
    $inputData['LeaveStartDate'] = $_POST['LeaveStartDate'];
    $inputData['ProgressState'] = 6;        // 'NotAssigned'
    $inputData['ProcessIDref'] = $processIDref;

    return createNewStudyLeaveApplicaiton($conn, $inputData, $_SESSION['UserID']);
}

function uploadFiles(&$conn, $processIDref)
{
    if (empty($_FILES)) {
        return true;
    }
    if (!file_exists($_FILES['myfile']['tmp_name']) || !is_uploaded_file($_FILES['myfile']['tmp_name'])) {
        return true;
    }
    $uploadDir = "../SiteData/Uploads/";
    foreach ($_FILES['FileUpload']['name'] as $key => $name) {
        $fileName = time() . basename($_FILES['FileUpload']["name"][$key]);
        $fileSaveDir = $uploadDir . $fileName;
        $fileSaveDir = str_replace(' ', '', $fileSaveDir);
        if (upload_file("FileUpload", $key, $fileSaveDir)) {
            $inputData['ProcessIDref'] = $processIDref;
            $inputData['Directory'] = $fileName;
            $inputData['Type'] = 'pdf';
            if (!createAttachment($conn, $inputData)) {
                $_SESSION['error'] = "Create Attachment Error in Create Study Leave Application php code";
                return false;
            }
        } else {
            $_SESSION['error'] = "File Upload Error in Create Study Leave Application php code";
            return false;
        }
        return true;
    }
}

function createANewSLAMainTask(&$conn)
{
    if (createEmptyProcess($conn)) {
        //echo "<br>process created<br>";
        $processIDref = getlastProcessID($conn);
        if (createANewSLA($processIDref, $conn)) {
            return uploadFiles($conn, $processIDref);
        }
        return true;
    } else {
        $_SESSION['error'] = "createanewSLA Error in Create Study Leave Application php code";
    }
    return false;
}


if (createANewSLAMainTask($conn)) {
    $_SESSION['success'] = "Succcessfully Submitted";
    header('Location: ../pages/Applicant_home.php');
} else {
    echo $_SESSION['error'];
}
