<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// function getprogressID($progressName)
// {
//     $progressArray = array('1' => 'Assigned', '2' => 'InProgress', '3' => 'Problem', '4' => 'Approved', '5' => 'Rejected', '6' => 'NotAssigned');
//     foreach ($progressArray as $key => $value) {
//         if ($value == $progressName)
//             return $key;
//     }
//     return '0';
// }

function getProcessProgressByNocID($NocID, &$conn)
{
    $sql = "SELECT
            `ApplicationDate`,
            `ApprovalDate`,
            `DepartmentChairman`,
            `AccountsController`,
            `CollegeInspector`,
            `Librarian`,
            `ExamController`,
            `ChiefEngineer`,
            `ChiefMedicalOfficer`,
            `DirectorDPD`,
            `DRTeacherCellRO`,
            `DRAcademicCellRO`,
            `DRHomeLoanBranchRO`,
            `DRConfidentialBranchRO`
        FROM
            Process
        INNER JOIN NocApplication ON NocApplication.ProcessIDref = Process.ProcessID
        WHERE
            NocApplication.NocID = '$NocID';
            ";
    //echo "<br>".$sql."<br>";
    $result = mysqli_query($conn, $sql);

    if (empty($result) || mysqli_num_rows($result) != 1) {
        mysqli_free_result($result);
        return null;
    }
    return mysqli_fetch_assoc($result);
}


function getProcessProgressByStudyLeaveID($ApplicationID, &$conn)
{
    $sql = "SELECT
            `ApplicationDate`,
            `ApprovalDate`,
            `DepartmentChairman`,
            `AccountsController`,
            `CollegeInspector`,
            `Librarian`,
            `ExamController`,
            `ChiefEngineer`,
            `ChiefMedicalOfficer`,
            `DirectorDPD`,
            `DRTeacherCellRO`,
            `DRAcademicCellRO`,
            `DRHomeLoanBranchRO`,
            `DRConfidentialBranchRO`
        FROM
            Process
        INNER JOIN StudyLeaveApplication ON StudyLeaveApplication.ProcessIDref = Process.ProcessID
        WHERE
            StudyLeaveApplication.ApplicationID = '$ApplicationID';
            ";
    // echo "<br>".$sql."<br>";
    $result = mysqli_query($conn, $sql);

    if (empty($result) || mysqli_num_rows($result) != 1) {
        mysqli_free_result($result);
        return null;
    }
    return mysqli_fetch_assoc($result);
}



/**
 * @param string $progressState excludes results of that state
 */
function getnocProcessByDepartment(&$conn, $progressState, $department)
{
    $progressState = getprogressID($progressState);
    $sql = "SELECT
            nocapplication.NocID,
            nocapplication.ApplicationDate,
            nocapplication.UserIDref
            FROM
                `nocapplication`
            INNER JOIN Process ON Process.ProcessID = NocApplication.ProcessIDref
            WHERE
                Process.$department = '$progressState'
            ORDER BY
                nocApplication.ApplicationDate
            DESC
    ;";
    echo "<br>".$sql."<br>";
    return;
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


function getstudyleaveProcessByDepartment(&$conn, $progressState, $department){
    $progressState = getprogressID($progressState);
    $sql = "SELECT
            studyleaveapplication.ApplicationID,
            studyleaveapplication.ApplicationDate,
            studyleaveapplication.UserIDref
            FROM
                `studyleaveapplication`
            INNER JOIN Process ON Process.ProcessID = studyleaveapplication.ProcessIDref
            WHERE
                Process.$department = '$progressState'
            ORDER BY
                studyleaveapplication.ApplicationDate
            DESC
    ;";
    //echo "<br>".$sql."<br>";
    //return;
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

function getlastProcessID(&$conn)
{
    $sql = "SELECT ProcessID FROM Process ORDER BY ProcessID DESC LIMIT 1;";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        $result =  mysqli_fetch_assoc($result);
        return $result['ProcessID'];
    }
    mysqli_free_result($result);
    return 0;
}



function getProcess($processID, &$conn)
{
    $sql = "SELECT * FROM Process WHERE ProcessID = '$processID';";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        $result =  mysqli_fetch_assoc($result);
        return $result;
    }
    mysqli_free_result($result);
    return 0;
}

function createEmptyProcess(&$conn)
{
    $sql = "INSERT INTO `process`()
            VALUES();";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        //echo "<br>'$error'<br>";
    }
    return false;
}

function createProcess($conn, $inputData)
{
    $sql = "INSERT INTO `process`(
    `DepartmentChairman`,
    `AccountsController`,
    `CollegeInspector`,
    `Librarian`,
    `ExamController`,
    `ChiefEngineer`,
    `ChiefMedicalOfficer`,
    `DirectorDPD`,
    `DRTeacherCellRO`,
    `DRAcademicCellRO`,
    `DRHomeLoanBranchRO`,
    `DRConfidentialBranchRO`,
    `DRHigherStudyBranchRO`
)
VALUES(
    ?,?,?,?,?,?,?,?,?,?,?,?,?
)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssssssssssss",
            $inputData['DepartmentChairman'],
            $inputData['AccountsController'],
            $inputData['CollegeInspector'],
            $inputData['Librarian'],
            $inputData['ExamController'],
            $inputData['ChiefEngineer'],
            $inputData['ChiefMedicalOfficer'],
            $inputData['DirectorDPD'],
            $inputData['DRTeacherCellRO'],
            $inputData['DRAcademicCellRO'],
            $inputData['DRHomeLoanBranchRO'],
            $inputData['DRConfidentialBranchRO'],
            $inputData['DRHigherStudyBranchRO']
        );
        $stmt->execute();
        // any additional code you need would go here.
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        // echo "<br>'$error'<br>";
        return false;
    }
    return true;
}

function updateProcess($ProcessID, $inputData, &$conn)
{
    $ProcessID = json_encode($ProcessID);
    $sql = "UPDATE
            `process`
        SET";
    if (isset($inputData['DepartmentChairman'])) {
        $status = json_encode($inputData['DepartmentChairman']);
        $sql = $sql . " `DepartmentChairman` = $status,";
    }
    if (isset($inputData['AccountsController'])) {
        $status = json_encode($inputData['AccountsController']);
        $sql = $sql . " `AccountsController` = $status,";
    }
    if (isset($inputData['CollegeInspector'])) {
        $status = json_encode($inputData['CollegeInspector']);
        $sql = $sql . " `CollegeInspector` = $status,";
    }
    if (isset($inputData['Librarian'])) {
        $status = json_encode($inputData['Librarian']);
        $sql = $sql . " `Librarian` = $status,";
    }
    if (isset($inputData['ExamController'])) {
        $status = json_encode($inputData['ExamController']);
        $sql = $sql . " `ExamController` = $status,";
    }
    if (isset($inputData['ChiefEngineer'])) {
        $status = json_encode($inputData['ChiefEngineer']);
        $sql = $sql . " `ChiefEngineer` = $status,";
    }
    if (isset($inputData['ChiefMedicalOfficer'])) {
        $status = json_encode($inputData['ChiefMedicalOfficer']);
        $sql = $sql . " `ChiefMedicalOfficer` = $status,";
    }
    if (isset($inputData['DirectorDPD'])) {
        $status = json_encode($inputData['DirectorDPD']);
        $sql = $sql . " `DirectorDPD` = $status,";
    }
    if (isset($inputData['DRTeacherCellRO'])) {
        $status = json_encode($inputData['DRTeacherCellRO']);
        $sql = $sql . " `DRTeacherCellRO` = $status,";
    }
    if (isset($inputData['DRAcademicCellRO'])) {
        $status = json_encode($inputData['DRAcademicCellRO']);
        $sql = $sql . " `DRAcademicCellRO` = $status,";
    }
    if (isset($inputData['DRHomeLoanBranchRO'])) {
        $status = json_encode($inputData['DRHomeLoanBranchRO']);
        $sql = $sql . " `DRHomeLoanBranchRO` = $status,";
    }
    if (isset($inputData['DRConfidentialBranchRO'])) {
        $status = json_encode($inputData['DRConfidentialBranchRO']);
        $sql = $sql . " `DRConfidentialBranchRO` = $status,";
    }
    if (isset($inputData['DRHigherStudyBranchRO'])) {
        $status = json_encode($inputData['DRHigherStudyBranchRO']);
        $sql = $sql . " `DRHigherStudyBranchRO` = $status,";
    }


    $sql = rtrim($sql, ',');

    $sql  = $sql . " WHERE ProcessID = $ProcessID;";
    //echo "<br><br>" . $sql . "<br><br>";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false; //echo "Error updating record: " . mysqli_error($conn);
    }
    return false;
}
