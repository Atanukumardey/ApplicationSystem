<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * @param array $inputData an associative array should contains
 *`ProcessIDref`,
  `Directory`,
  `Type`
 *
 */
function createAttachment(&$conn, $inputData)
{
    $sql = "INSERT INTO `attachment`(
            `ProcessIDref`,
            `Type`,
            `Directory`
            )
            VALUES(?,?,?);";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sss",
            $inputData['ProcessIDref'],
            $inputData['Type'],
            $inputData['Directory']
        );
        if (!$stmt->execute()) {
            echo "<br>problem in attachment data input<br>";
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

/**
 * @return array an array of rows array->array(AttachmentID,Type,Directory);
 * @return null if there is no data
 */
function getAttachments(&$conn, $processIDref)
{
    $sql = "SELECT
            `AttachmentID`,
            `Type`,
            `Directory`
        FROM
            `attachment`
        WHERE
            `ProcessIDref` = '$processIDref'
        ORDER BY 
            `AttachmentID` ASC;";
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
