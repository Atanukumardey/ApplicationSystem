<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/process.php";
include "db/accessUtility/studyleaveapplication.php";
include "util/backendutil.php";
include "db/accessUtility/comments.php";

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
}

global $ApplicationData, $ApplicationID;
$ApplicationID = $_GET['ApplicationID'];
$ApplicationData = getStudyLeaveApplicationByApplicationID($ApplicationID, $conn);

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

if (isset($_GET['submit']) && $_GET['submit'] == 'Approve') {
    DeptApproval($conn);
}


// $_SESSION['success'] = 'Approved';
// header('Location: office_home.php');
