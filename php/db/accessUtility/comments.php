<?php

function createNewComment(&$conn, $comment, $commenterID, $processIDref)
{
    $sql = "INSERT INTO `comments`(
    `CommenterID`,
    `Comment`,
    `ProcessIDref`) VALUES(?,?,?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sss",
            $commenterID,
            $comment,
            $processIDref
        );
        if (!$stmt->execute()) {
            echo "<br>problem<br>";
            return false;
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
        return false;
    }
    return true;
}

function getComment(&$conn, $commenterID, $processIDref)
{
    $sql = "SELECT `Comment` FROM `comments` WHERE `commenterID` = '$commenterID' AND `ProcessIDref` = '$processIDref';";
    $result = mysqli_query($conn, $sql);  // conn dabase connection reference. see in "database_connect.php" file.

    if (!empty($result) && mysqli_num_rows($result) === 1) {
        $result =  mysqli_fetch_assoc($result);
        return $result['Comment'];
    }
    return null;
}

function updateComment(&$conn, $commenterID, $processIDref, $newComment)
{
    $sql = "UPDATE `comments` SET `comment`='$newComment' WHERE `commenterID` = '$commenterID' AND `ProcessIDref` = '$processIDref';";
    if (mysqli_query($conn, $sql)) {
        return true;
    }
    return false;
}
