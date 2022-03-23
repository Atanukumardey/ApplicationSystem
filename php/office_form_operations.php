<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "db/accessUtility/process.php";
include "../php/db/accessUtility/nocApplication.php";


session_start();
if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
}

// if ($_POST['submit'] == 'Approve') {
//     $inputData[$_SESSION['Department']] = 4; // Approved in processstatus;
//     // edit needed
//     if(updateProcess($_POST['NocID'], $inputData, $conn)){
//         //echo 'hello';
//     }
// }


