<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("session/session.php");

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
}
if ($_SESSION['Role'] != 'Applicant') {
    header('Location: ../index.php');
}

include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/nocApplication.php";
include "db/accessUtility/personalInfo.php";
include "db/accessUtility/Users.php";



function personalInfoNeedUpdate(&$conn)
{
    //echo "from functon <br>";
    $userPersonalInfo = getPersonalInfo($_SESSION['UserID'], $conn);
    if ($userPersonalInfo == null) {
        //echo "correct";
        return null;
    }
    foreach ($userPersonalInfo as $key => $value) {
        if (!isset($_POST[$key])) {
            //print_r($_POST[$key]);
            continue;
        }
        if ($value != $_POST[$key]) {
            return true;
        }
    }
    //echo "fend";
    return false;
}

//needUpdate($conn);

function handlePersonalInfo(&$conn)
{
    $state = personalInfoNeedUpdate($conn);
    if ($state === null) {  // need to push data in database
        echo 'here';
        if (!createPersonalInfo($_SESSION['UserID'], $_POST, $conn)) {
            //echo "<br>Problem in Personal Data create <br>";
            return false;
        }
    } else if ($state == true) {  // need to update personalinfo something is changed
        if (!updatePersonalInfo($_SESSION['UserID'], $_POST, $conn)) {
            // echo "NOT SUCCESS<br>";
            return false;
        }
    } else {
        // do nothing. just proceed
    }
    return true;
}

function handleUserData(&$conn)
{
    $userdata = getUserByUserID($_SESSION['UserID'], $conn);
    //print_r($userdata);
    if ($userdata == null) {
        return false;
    } else {
        if ($userdata['UserName'] != $_POST['Name']) {
            $fixData['UserName'] = $_POST['Name'];
            if (!updateUser($_SESSION['UserID'], $fixData, $conn)) {
                return false;
            }
        }
    }
    return true;
}

function createNewApplication(&$conn, $UserIDref)
{
    if (!handlePersonalInfo($conn)) {
        //echo "<br>Problem in Personal Data <br>";
        return false;
    }
    if (!handleUserData($conn)) {
        //echo "<br>Problem in user Data <br>";
        return false;
    }

    $ApplicationData['NocVersion'] = getlLatestNocVersion($UserIDref, $conn) + 1;
    $ApplicationData['ApplicationDate'] = date("Y-m-d");
    $ApplicationData['ApprovalDate'] = null;
    $ApplicationData['ProgressState'] = 6; // NotAssigned State

    if (!createnocApplication($UserIDref, $ApplicationData, $conn)) {
        // echo "<br>Problem in create application<br>";
        return false;
    }
    return true;
}

function sendReport($current_state, $errorState){
    $_SESSION[$errorState] = $current_state;
    header('Location:../pages/Applicant_home.php');
}

if (!createNewApplication($conn, $_SESSION['UserID'])) {
    sendReport("ERROR", "error");
} else {
    sendReport("Successfuly form submitted", "success");
}


?>