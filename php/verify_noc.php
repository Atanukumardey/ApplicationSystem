<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
header('Location: ../index.php');
}