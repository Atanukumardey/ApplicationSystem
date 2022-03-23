<?php

/**
 * user input variables 
 * email address
 * password
 * role -- this comes from different entry pages passed
 * through login page
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db/database_connect.php";
include "db/dbAccessUtility.php";
include "../php/user_type.php";

$current_state = "";

function sendReport($state)
{
    $_SESSION['error'] = $state;
    header("Location: ../userManagement/login.php");
}

if (isset($_POST['user_email']) && isset($_POST['password']) && isset($_POST['role'])) {


    $user_email = secureInput($_POST['user_email'], $conn);
    $password = secureInput($_POST['password'], $conn);
    $role = secureInput($_POST['role'], $conn);

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        sendReport("Email Invalid");
    }

    if (empty($user_email)) {
    } else if (empty($password)) {
        sendReport("Fill Up Email and Password");
    } else {
        // Hashing the password
        // $password = md5($password);
        $sql = "SELECT * FROM Users WHERE Email='$user_email' AND Password='$password';";
        $sql = (string) $sql;

        $result = mysqli_query($conn, $sql);

        $roleid = (string) getRoleID($conn, $role);  // in query output $row['RoleID'] is string;

        //echo mysqli_num_rows($result);

        if (!empty($result) && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['Password'] === $password && $row['RoleIDref'] === $roleid) {

                session_regenerate_id(true);

                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['RoleID'] = $row['RoleIDref'];
                $_SESSION['Role'] = $_POST['role'];
                if (checkDept($_POST['role'])) {
                    $_SESSION['Department'] = $DBuserconstrains[$_SESSION['RoleID']];
                }
                $_SESSION['UserName'] = $row['UserName'];
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['Mobile'] = $row['Mobile'];

                mysqli_free_result($result);
                header("Location: ../home.php");
            } else {
                mysqli_free_result($result);
                sendReport("Email Or Password Dosen't Matches");
            }
        } else {
            sendReport("Email Or Password Dosen't Matches");
        }
    }
} else {
    sendReport("ERROR");
}
