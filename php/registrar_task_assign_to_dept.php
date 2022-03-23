<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../php/session/session.php";
sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
}


include "db/database_connect.php";
include "db/accessUtility/process.php";
include "db/accessUtility/nocApplication.php";
include "util/backendutil.php";

function checkValidInputData()
{
    foreach ($GLOBALS['deptArray'] as $key) {
        if (isset($_POST[$key])) {
            return true;
        }
    }
    return false;
}

function createANewNocProcess(&$conn)
{
    $dataArray['NocIDref'] = $_POST['NocID'];
    foreach ($GLOBALS['deptArray'] as $key) { // deptArray from  util/backendutil.php
        if (isset($_POST[$key])) {
            $dataArray[$key] = 1; // Assigned
        } else {
            $dataArray[$key] = 6; // NotAssigned
        }
    }

    if (createProcess($conn, $dataArray)) {
        //echo "<br>process created<br>";
        $inputData['ProcessIDref'] = getlastProcessID($conn);
        if (updatenocApplicationByNocID($_POST['NocID'], $inputData, $conn)) {
            return true;
        }
    }
    return false;
}

function mainTask(&$conn)
{
    //echo "<br>".$_POST['NocID']."<br>";
    //return;
    if (getProcessProgressByNocID($_POST['NocID'], $conn) == null) { // need to create a new process
        //echo "<br>first<br>";

        if (createANewNocProcess($conn)) {
            $inputData['ProgressState'] = 2; // inprogress
            //echo "<br>second<br>";
            if (updatenocApplicationByNocID($_POST['NocID'], $inputData, $conn)) {
               // echo "<br>third<br>";
                return true;
            }
        }
    }
    return false;
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
    header('Location:../pages/registrar_home.php');
}
