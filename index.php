<?php
include "php/session/session.php";
sessionStart(0, '/', 'localhost', true, true);
if(!isset($_SESSION['Role'])){
    $_SESSION['Role'] = 'Applicant';
}
header('Location:userManagement/login.php');
