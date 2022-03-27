<?php
include "../php/session/session.php";
sessionStart(0, '/', 'localhost', true, true);
$_SESSION['Role'] = 'Verifier';
header('Location:../userManagement/login.php');

?>