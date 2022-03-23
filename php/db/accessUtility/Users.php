<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


function getUserByUserID($UserID, &$conn){
    $sql = "SELECT * FROM Users WHERE UserID = '$UserID';";

    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}

function getUserByUserEmailandPhoneNumber($email, $phone, &$conn){
    $sql = "SELECT * FROM Users WHERE Email='$email' AND Mobile='$phone';";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}


function getUserAndPersonalInfoByNocID($NocID, &$conn){
    $sql = "SELECT
    *
FROM
    `nocapplication`
INNER JOIN Users ON nocapplication.UserIDref = Users.UserID
INNER JOIN personalinfo ON Users.UserID = PersonalInfo.UserIDref
WHERE
    NocID = '$NocID';";

    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}



function updateUser($UserID, $inputData, &$conn){
    //secureInputArray($inputData, $conn);

    $sql = "UPDATE Users SET";

    
    if (isset($inputData['UserName'])) {
        $UserName = $inputData['UserName'];
        $_SESSION['UserName'] = $inputData['UserName'];
        $sql = $sql . " UserName = '$UserName',";
    }
    if (isset($inputData['Mobile'])) {
        $Mobile =  $inputData['Mobile'];
        $sql = $sql . " Mobile = '$Mobile',";
    }
    if (isset($inputData['Email'])) {
        $Email =  $inputData['Email'];
        $sql = $sql . " Email = '$Email',";
    }
    if (isset($inputData['Password'])) {
        $Password =  $inputData['Password'];
        $sql = $sql . " Password ='$Password',";
    }
    if (isset($inputData['RoleIDref'])) {
        $RoleIDref =  $inputData['RoleIDref'];
        $sql = $sql . " RoleIDref ='$RoleIDref',";
    }
    if (isset($inputData['RecoveryOtp'])) {
        $Otp = $inputData['RecoveryOtp'];
        $sql = $sql . " RecoveryOtp = '$Otp',";
    }

    $sql = rtrim($sql, ',');

    $sql  = $sql." WHERE UserID = '$UserID';";
    //echo "<br><br>" . $sql . "<br><br>";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false; //echo "Error updating record: " . mysqli_error($conn);
    }

    return false;
}