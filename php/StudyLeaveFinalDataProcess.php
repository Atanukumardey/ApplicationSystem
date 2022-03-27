<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db/database_connect.php";
// include "session/session.php";
 include "db/dbAccessUtility.php";
// include "db/accessUtility/process.php";
// include "db/accessUtility/studyleaveapplication.php";
// include "db/accessUtility/comments.php";
include "util/backendutil.php";

// sessionStart(0, '/', 'localhost', true, true);


// if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
//     header('Location: ../userManagement/logout.php');
// }

function getCommentData(&$conn, $ApplicationID)
{
    $sql = "SELECT
    Comments.Comment,
    Users.UserName,
    UserRole.RoleName
FROM
    StudyLeaveApplicatiON
JOIN Process ON Process.ProcessID = StudyLeaveApplication.ProcessIDref
JOIN Comments ON Comments.ProcessIDref = Process.ProcessID
JOIN Users ON Users.UserID = Comments.CommenterID
JOIN UserRole ON UserRole.RoleID = Users.RoleIDref
WHERE
    StudyLeaveApplicatiON.ApplicationID = '$ApplicationID';";

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
