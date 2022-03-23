<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../php/session/session.php";

sessionStart(0, '/', 'localhost', true, true);

include 'db/database_connect.php';
include 'db/dbAccessUtility.php';

$current_state = "";

$user_middle_name = isset($_POST['user_middle_name']) ? ($_POST['user_middle_name']) : "";
$user_name = trim($_POST['user_first_name']) . " " . trim($user_middle_name) . " " . $_POST['user_last_name'];
$user_email = trim($_POST['user_email']);
$mobile = trim($_POST['contact_number']);
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$role = $_POST['role'];


if (!empty($user_name) && !empty($user_email) && !empty($mobile) && !empty($password) && !empty($cpassword) && !empty($role)) {

    if ($password !== $cpassword) {
        sendReport("error", "Two password dosen't match", "signup");
    }
    if (!mysqli_connect_error()) {

        $sql = "INSERT INTO users (UserName, Mobile, Email, Password, RoleIDref) VALUES(?,?,?,?,?);";

        if (isUniqueEmail($conn, $user_email)) {

            $role = (int) getRoleID($conn, $role);

            //sendReport($role, "signup");

            if ($stmt = $conn->prepare($sql)) { // assuming $mysqli is the connection
                $stmt->bind_param("sssss", $user_name, $mobile, $user_email, $password, $role);
                $stmt->execute();
                // any additional code you need would go here.
            } else {
                $error = $conn->errno . ' ' . $conn->error;
                echo $error;
            }
            $error = null;
            sendReport("success", "Sign Up Successful. Login To Continue", "login");
        } else {
            sendReport("error", "Email Already Used!", "signup");
        }
        $conn->close();
    }
} else {
    sendReport("error", "All fields are required!", "signup");
    die();
}
?>



<?php
function sendReport($state, $message, $where)
{
    if ($where == 'signup') {
        $_SESSION[$state] = $message;
        header('Location:../userManagement/signup.php');
    } else {
        $_SESSION[$state] = $message;
        header('Location:../userManagement/login.php');
    }
}
?>
