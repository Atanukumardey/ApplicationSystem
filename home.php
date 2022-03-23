<?php
include "php/user_type.php";

session_start();

unset($_POST);
if (isset($_SESSION['Email']) && isset($_SESSION['RoleID'])) {
    if ($_SESSION['Role'] == 'Applicant') {
        header('Location: pages/Applicant_home.php');
    } else if ($_SESSION['Role'] == 'Registrar') {
        header('Location: pages/registrar_home.php');
    } else if (checkUser($_SESSION['Role'])) {
        header('Location: pages/registrar_home.php');
    } else if ($_SESSION['Role'] == 'Verifier') {
        header('Location: pages/verification_home.php');
    } else {
        header('Location: userManagement/logout.php');
    }
} else {
    header('Location: index.php');
}
