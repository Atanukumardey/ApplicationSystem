<?php
include "../php/session/session.php";
sessionStart(0, '/', 'localhost', true, true);
$_SESSION['Role'] = 'internal office';
header('Location:../userManagement/login.php');
?>