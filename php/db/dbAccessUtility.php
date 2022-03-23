<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database_connect.php';


function secureInput(&$data, &$conn)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

function secureInputArray($dataarray, &$conn)
{
    foreach ($dataarray as $name => $value) {
        $age[$name] = secureInput($value, $conn);
    }
}


function isUniqueEmail(&$conn, $email)
{
    $select = "SELECT UserID FROM Users WHERE Email=? LIMIT 1;";
    $stmt = $conn->prepare($select);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;
    $stmt->close();
    if ($rnum > 0) {
        return false;
    }
    return true;
}


function getRoleID(&$conn, $role)
{
    secureInput($role, $conn);
    $role = json_encode($role);
    $sql = "SELECT * FROM UserRole WHERE RoleName= $role;";
   // echo "<br>".$sql."<br>";
    $sql = (string) $sql;
    $result = mysqli_query($conn, $sql);
    $ans = 1;

    if (!empty($result) && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $ans = $row['RoleId'];
    }
    mysqli_free_result($result);
    return $ans; // as general user
}
?>