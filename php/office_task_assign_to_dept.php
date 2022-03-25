<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../php/session/session.php";
sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
}


include "db/database_connect.php";
include "db/accessUtility/process.php";
include "db/accessUtility/studyleaveapplication.php";
include "util/backendutil.php";


$ApplicationID = $_POST['ApplicationID'];
global $ApplicationData, $progressStateType;
$ApplicationData = getStudyLeaveApplicationByApplicationID($ApplicationID, $conn);

function checkValidInputData()
{
    foreach ($GLOBALS['deptArray'] as $key) {
        if (isset($_POST[$key])) {
            return true;
        }
    }
    return false;
}


function mainTask(&$conn)
{
    global $ApplicationData;
    global $progressStateType;
    global $ApplicationID;
    foreach ($GLOBALS['deptArray'] as $key) { // deptArray from  util/backendutil.php
        if (isset($_POST[$key])) {
            $dataArray[$key] = $progressStateType['Assigned']; // Assigned
        } else {
            $dataArray[$key] = $progressStateType['NotAssigned'];; // NotAssigned
        }
        //echo "<br>".$key."=>" . $dataArray[$key];
    }

    if (!updateProcess($ApplicationData['ProcessIDref'], $dataArray, $conn)) {
        $_SESSION['error'] = "Update Process ERROR in office task assign to dept";
        return false;
    }
    // need update in studyLeaveApplication table progress to Assigned
    $inputdata = array('ProgressState' => $progressStateType['Assigned']);
    if (!updateStudyLeaveApplicationByApplicationID($ApplicationID, $inputdata, $conn)) {
        $_SESSION['error'] = "Update Process ERROR in office task assign to dept";
        return false;
    }

    return true;
}

//print_r($_POST);

if (checkValidInputData()) {
    if (mainTask($conn)) {
        sendReport("Successfuly Assigned", "success");
    } else {
        sendReport("ERROR", "error");
    }
}


function sendReport($state, $errorstate)
{
    $_SESSION[$errorstate] = $state;
    header('Location:../pages/office_home.php');
}
