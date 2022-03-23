<?php

//include ("../dbAccessUtility.php");//php\db\dbAccessUtility.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getprogressID($progressName)
{
    $progressArray = array('1' => 'Assigned', '2' => 'InProgress', '3' => 'Problem', '4' => 'Approved', '5' => 'Rejected', '6' => 'NotAssigned');
    foreach ($progressArray as $key => $value) {
        if ($value == $progressName)
            return $key;
    }
    return '0';
}

function getlLatestNocVersion($UserIDref, &$conn)
{
    $sql = "SELECT NocVersion FROM NocApplication WHERE UserIDref='$UserIDref' ORDER BY NocVersion DESC LIMIT 1;";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        $result =  mysqli_fetch_assoc($result);
        return $result['NocVersion'];
    }
    return 0;
}


function getnocApplicationsByUserID($UserIDref, &$conn)
{
    $sql = "SELECT
                *
            FROM
                `nocapplication`
            WHERE
                UserIDref = '$UserIDref'
            ORDER BY
                NocVersion
            DESC
            ;";
    //echo "<br>".$sql."<br>";
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

function getnocApplicationsByNocID($NocID, &$conn)
{
    $sql = "SELECT
    *
FROM
    `nocapplication` 
WHERE
    NocID = '$NocID';";
    //echo "<br>".$sql."<br>";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}

/**
 * @param string $progressState excludes results of that state
 */
function getnocApplicationsByProgreState(&$conn, $progressState)
{
    $progressState = getprogressID($progressState);
    $sql = "SELECT
            *
            FROM
                `nocapplication`
            WHERE
                `ProgressState` = '$progressState'
            ORDER BY
                nocApplication.ApplicationDate
            DESC
    ;";
    //echo "<br>".$sql."<br>";
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


function createnocApplication($UserIDref, $inputData, &$conn)
{
    // secureInputArray($inputData, $conn);
    $sql = "INSERT INTO NocApplication(NocVersion,ApplicationDate,ApprovalDate,UserIDref,ProgressState) VALUES(?,?,?,?,?);";
    //print_r($inputData);
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssss",
            $inputData['NocVersion'],
            $inputData['ApplicationDate'],
            $inputData['ApprovalDate'],
            $UserIDref,
            $inputData['ProgressState']
        );
        if (!$stmt->execute()) {
            echo "<br>problem<br>";
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

function updatenocApplicationByNocID($NocID, $inputData, &$conn)
{

    $sql = "UPDATE NocApplication SET";

    if (isset($inputData['NocVersion'])) {
        $nocVersion = $inputData['NocVersion'];
        $sql = $sql . " NocVersion = '$nocVersion',";
    }
    if (isset($inputData['ApplicationDate'])) {
        $applicationDate =  $inputData['ApplicationDate'];
        $sql = $sql . " ApplicationDate = '$applicationDate',";
    }
    if (isset($inputData['ApprovalDate'])) {
        $approvalDate =  $inputData['ApprovalDate'];
        $sql = $sql . " ApprovalDate = '$approvalDate',";
    }
    if (isset($inputData['ProgressState'])) {
        $progressState =  $inputData['ProgressState'];
        $sql = $sql . " ProgressState ='$progressState'";
    }
    if (isset($inputData['ProcessIDref'])) {
        $processIDref =  $inputData['ProcessIDref'];
        $sql = $sql . " ProcessIDref ='$processIDref'";
    }

    $sql = rtrim($sql, ',');

    $sql  = $sql . " WHERE NocID = '$NocID';";
    //echo "<br><br>" . $sql . "<br><br>";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false; //echo "Error updating record: " . mysqli_error($conn);
    }

    return false;
}
