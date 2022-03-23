<?php
function sendEmail($email,$subject,$body)
{
    $sender = "University Of Chittagong";
    if (mail($email, $subject, $body, $sender)) {
        return true;
    }
    return false;
}