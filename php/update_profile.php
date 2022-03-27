<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/nocApplication.php";
include "db/accessUtility/personalInfo.php";
include "db/accessUtility/Users.php";
include("session/session.php");

sessionStart(0, '/', 'localhost', true, true);


if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] != 'Applicant') {
    header('Location: ../userManagement/logout.php');
}


/*
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
} */

if (!updatePersonalInfo($_SESSION['UserID'], $_POST, $conn)) {
    $_SESSION['error'] = "Update Not Successfull";
} else {
    $_SESSION['success'] = "Update Successfull";
}
header("Location: ../pages/Applicant_home.php");

?>