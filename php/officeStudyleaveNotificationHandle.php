<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db/database_connect.php";
include "session/session.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/process.php";
include "db/accessUtility/studyleaveapplication.php";
include "util/backendutil.php";
include "db/accessUtility/comments.php";

sessionStart(0, '/', 'localhost', true, true);


if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
}

global $ApplicationData, $ApplicationID;
$ApplicationID = $_POST['ApplicationID'];
$ApplicationData = getStudyLeaveApplicationByApplicationID($ApplicationID, $conn);

global $Comment;
$Comment = $_POST['comments'] . "";

// print_r($_POST);

unset($_SESSION['error']);
unset($_SESSION['success']);

function handleComments(&$conn)
{
    global $Comment;
    global $processIDref;

    if (strlen($Comment) < 2) {
        $_SESSION['error'] = "Please make a comment";
        return false;
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


function DeptApproval(&$conn)
{
    global $progressStateType, $ApplicationData, $ApplicationID;
    $inputData[$_SESSION['Role']] = $progressStateType['Approved']; // Approved in processstatus;
    if (!updateProcess($ApplicationData['ProcessIDref'], $inputData, $conn)) {
        return false;
    }

    $processData = getProcess($ApplicationData['ProcessIDref'], $conn);
    $allapproved = true;

    foreach ($processData as $key => $value) {
        if (
            $value == $progressStateType['InProgress'] ||
            $value == $progressStateType['Assigned'] ||
            $value == $progressStateType['Problem'] ||
            $value == $progressStateType['Rejected']
        ) {
            $allapproved = false;
        }
    }
    if ($allapproved) {
        $inputData["ProgressState"] = $progressStateType['AllDeptApproved'];
        if (!updateStudyLeaveApplicationByApplicationID($ApplicationID, $inputData, $conn)) {
            $_SESSION['error'] = "Study leave Update Error";
            return false;
        }
    }
    return true;
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Approve') {
    //echo "here";
    if(handleComments($conn)){
        if(DeptApproval($conn)){
            $_SESSION['success'] = "Operation Successfull";
        }
    }
    header('Location: ../pages/Office_home.php');
}


// $_SESSION['success'] = 'Approved';
// header('Location: office_home.php');
