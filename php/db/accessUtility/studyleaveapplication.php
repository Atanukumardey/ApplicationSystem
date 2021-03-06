<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * @param array $inputData an associative array should contain
 * `ApplicationDate`,
`NameOfProgram`,
`University`,
`Department`,
`FinancialSource`,
`StartsFrom`,
`ProgramDuration`,
`LeaveStartDate`,
`ProgressState`,
`ProcessIDref`
 *
 */
function createNewStudyLeaveApplicaiton(&$conn, $inputData, $UserIDref)
{
    $sql = "INSERT INTO `studyleaveapplication`(
            `ApplicationDate`,
            `NameOfProgram`,
            `University`,
            `Department`,
            `FinancialSource`,
            `StartsFrom`,
            `ProgramDuration`,
            `UserIDref`,
            `ProgressState`,
            `LeaveStartDate`,
            `ProcessIDref`
            )
            VALUES(
            ?,?,?,?,?,?,?,?,?,?,?
            );";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssssssssss",
            $inputData['ApplicationDate'],
            $inputData['NameOfProgram'],
            $inputData['University'],
            $inputData['Department'],
            $inputData['FinancialSource'],
            $inputData['StartsFrom'],
            $inputData['ProgramDuration'],
            $UserIDref,
            $inputData['ProgressState'],
            $inputData['LeaveStartDate'],
            $inputData['ProcessIDref']
        );
        if (!$stmt->execute()) {
            echo "<br>problem in study leave data input<br>";
            return false;
        }
        // any additional code you need would go here.
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
        return false;
    }
    return true;
}


function updateStudyLeaveApplicationByApplicationID($ApplicationID, $inputData, &$conn)
{

    $sql = "UPDATE `studyleaveapplication` SET";

    if (isset($inputData['ApplicationDate'])) {
        $applicationDate = $inputData['ApplicationDate'];
        $sql = $sql . " ApplicationDate = '$applicationDate',";
    }
    if (isset($inputData['ApprovalDate'])) {
        $approvalDate = $inputData['ApprovalDate'];
        $sql = $sql . " ApprovalDate = '$approvalDate',";
    }
    if (isset($inputData['University'])) {
        $University = $inputData['University'];
        $sql = $sql . " University = '$University',";
    }
    if (isset($inputData['Department'])) {
        $Department = $inputData['Department'];
        $sql = $sql . " Department = '$Department',";
    }
    if (isset($inputData['FinancialSource'])) {
        $FinancialSource = $inputData['FinancialSource'];
        $sql = $sql . " FinancialSource = '$FinancialSource',";
    }
    if (isset($inputData['StartsFrom'])) {
        $StartsFrom = $inputData['StartsFrom'];
        $sql = $sql . " StartsFrom = '$StartsFrom',";
    }
    if (isset($inputData['ProgramDuration'])) {
        $ProgramDuration = $inputData['ProgramDuration'];
        $sql = $sql . " ProgramDuration = '$ProgramDuration',";
    }
    if (isset($inputData['NameOfProgram'])) {
        $NameOfProgram = $inputData['NameOfProgram'];
        $sql = $sql . " NameOfProgram = '$NameOfProgram',";
    }
    if (isset($inputData['ProgressState'])) {
        $progressState = $inputData['ProgressState'];
        $sql = $sql . " ProgressState ='$progressState'";
    }
    if (isset($inputData['ProcessIDref'])) {
        $processIDref = $inputData['ProcessIDref'];
        $sql = $sql . " ProcessIDref ='$processIDref'";
    }

    $sql = rtrim($sql, ',');

    $sql = $sql . " WHERE ApplicationID = '$ApplicationID';";
    //echo "<br><br>" . $sql . "<br><br>";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "<br><br> Problem in Studyleave Db accessutility::=>  <br>" . $sql . "<br><br>";
        return false; //echo "Error updating record: " . mysqli_error($conn);
    }

    return false;
}

function getStudyLeaveApplicationByApplicationID($ApplicationID, &$conn)
{
    $sql = "SELECT
                *
            FROM
                `studyleaveapplication`
            WHERE
                ApplicationID = '$ApplicationID';
                ";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function getStudyLeaveApplicationByUserID($UserID, &$conn)
{
    $sql = "SELECT
                *
            FROM
                `studyleaveapplication`
            WHERE
                UserIDref = '$UserID'
            ORDER BY
                ApplicationID
            DESC;
                ";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.
    $returnArray = array();

    if (!empty($result) && mysqli_num_rows($result) >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($returnArray, $row);
        }
        mysqli_free_result($result);
        return $returnArray;
    }
    return null;
}


function getStudyLeaveApplicationByProcessID($ProcessID, &$conn)
{
    $sql = "SELECT
                *
            FROM
                `studyleaveapplication`
            WHERE
                ProcessIDref = '$ProcessID';
                ";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function getStudyLeaveApplicationProgressState($ApplicationID, &$conn)
{
    $sql = "SELECT
                `ProgressState`
            FROM
                `studyleaveapplication`
            WHERE
                `ApplicationID` = '$ApplicationID';
                ";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}



function getStudyLeaveApplicationByProgressState($ProgressState, &$conn)
{
    $sql = "SELECT
                *
            FROM
                `studyleaveapplication`
            WHERE
                ProgressState = '$ProgressState';
                ";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    $returnArray = array();

    if (!empty($result) && mysqli_num_rows($result) >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($returnArray, $row);
        }
        mysqli_free_result($result);
        return $returnArray;
    }

    return null;
}
