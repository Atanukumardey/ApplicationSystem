<?php
include "../php/session/session.php";
include "../php/util/pageutil.php";
sessionStart(0, '/', 'localhost', true, true);
$ROLE = $_SESSION['Role'];
session_unset();
session_destroy();
sessionStart(0, '/', 'localhost', true, true);
$_SESSION['Role']= $ROLE;

header("Location: login.php");
