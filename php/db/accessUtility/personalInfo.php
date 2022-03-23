<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


function getPersonalInfo($UserIDref, &$conn)
{
    //echo "<br>From personalINFO => ".$UserIDref. "<br>";
    if (mysqli_connect_error()) {
        die("Error" . mysqli_error($conn));
        return false;
    }
    $sql = "SELECT * FROM PersonalInfo WHERE UserIDref='$UserIDref' LIMIT 1;";
    //echo $sql."<br";

    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function createPersonalInfo($UserIDref, $inputData, &$conn)
{
    if (mysqli_connect_error()) {
        die("Error" . mysqli_error($conn));
        return false;
    }

    //secureInputArray($inputData, $conn);

    $sql  = "INSERT INTO PersonalInfo(UserIDref, Designation, WorkingUnit, Permanent, NationalID, ReferenceName, Relation, 
                Child1Name, Child2Name, Child1Gender, Child2Gender, Child1Age, Child2Age, RetirementDate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssssssss",
            $UserIDref,
            $inputData['Designation'],
            $inputData['WorkingUnit'],
            $inputData['Permanent'],
            $inputData['NationalID'],
            $inputData['ReferenceName'],
            $inputData['Relation'],
            $inputData['Child1Name'],
            $inputData['Child2Name'],
            $inputData['Child1Gender'],
            $inputData['Child2Gender'],
            $inputData['Child1Age'],
            $inputData['Child2Age'],
            $inputData['RetirementDate']
        );
        $stmt->execute();
        // any additional code you need would go here.
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        //echo $error;
        return false;
    }
    return true;
}

function updatePersonalInfo($UserIDref, $inputData, &$conn)
{
    secureInputArray($inputData, $conn);

    $designation = json_encode($inputData['Designation']);
    $workingUnit =  json_encode($inputData['WorkingUnit']);
    $permanent =  json_encode($inputData['Permanent']);
    $nationalID = json_encode($inputData['NationalID']);
    $referenceName =  json_encode($inputData['ReferenceName']);
    $relation = json_encode($inputData['Relation']);
    $child1name = json_encode($inputData['Child1Name']);
    $child2name = json_encode($inputData['Child2Name']);
    $child1Gender = json_encode($inputData['Child1Gender']);
    $child2Gender = json_encode($inputData['Child2Gender']);
    $child1Age = json_encode($inputData['Child1Age']);
    $child2age = json_encode($inputData['Child2Age']);
    $retirementDate = json_encode($inputData['RetirementDate']);
    $UserIDref = json_encode($UserIDref);

    $sql  = "UPDATE PersonalInfo SET Designation =$designation,
            WorkingUnit = $workingUnit,
            Permanent = $permanent,
            NationalID = $nationalID,
            ReferenceName =$referenceName,
            Relation =$relation,
            Child1Name=$child1name,
            Child2Name=$child2name,
            Child1Gender = $child1Gender,
            Child2Gender = $child2Gender,
            Child1Age = $child1Age,
            Child2Age = $child2age,
            RetirementDate = $retirementDate Where UserIDref = $UserIDref;";
   // echo "<br><br>".$sql. "<br><br>";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false; //echo "Error updating record: " . mysqli_error($conn);
    }

    return false;
}


function deletePersonalInfo($UserIDref, &$conn)
{
    $sql = "DELETE FROM PersonalInfo WHERE UserIDref='$UserIDref'";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false; //echo "Error updating record: " . mysqli_error($conn);
    }

    return false;
}
