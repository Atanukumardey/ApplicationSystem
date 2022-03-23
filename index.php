<?php
include "php/session/session.php";
sessionStart(0, '/', 'localhost', true, true);
$_SESSION['Role'] = 'Applicant';
header('Location:userManagement/login.php');
?>