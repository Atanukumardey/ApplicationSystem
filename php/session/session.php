<?php 

function sessionStart($lifetime, $path, $domain, $secure, $httponly){
    session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
    session_start();
}