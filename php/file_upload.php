<?php
// Database connection
include("db/database_connect.php");
include("session/session.php");

sessionStart(0, '/', 'localhost', true, true);


/**
 * @param array $files takes array of file input
 * @param array $allowedFileType like array("pdf","png","jpg",...)
 */

function fileValidityCheck($filesInstanceName, $allowedFileType)
{

    if (!file_exists($_FILES[$filesInstanceName]["tmp_name"][0])) {
        $_SESSION['error'] = "No file";
        return null;
    }
    foreach ($_FILES[$filesInstanceName]['name'] as $key => $name) {
        if (!$_FILES[$filesInstanceName]['error'][$key] === 0) {
            $_SESSION['error'] = "File Upload Error";
            return false;
        }
        $Ext = strtolower(pathinfo($_FILES[$filesInstanceName]['name'][$key], PATHINFO_EXTENSION));
        if (!in_array($Ext, $allowedFileType)) {
            $_SESSION['error'] = "File format not supported";
        } else if ($_FILES[$filesInstanceName]["size"][$key] > 5243000) {
            $_SESSION['error'] = "File is too large. File size should be less than 5 megabytes.";
            return false;
        }
    }
    return true;
}

/**
 * For uploading a single file
 * @param string $fileInstanceName name of the instance which is used to upload file 
 * @param int $index index of the target file in the instance array
 * @param string $uploadeDir desired directory to upload file
 */
function upload_file($fileInstanceName, $index, $uploadDir)
{
    //print_r($_FILES["filesInstanceName"]);
    // Get file path
    $target_file = $uploadDir;
   // echo "<br>". $_FILES[$fileInstanceName]["tmp_name"][$index]."<br>";
    // echo "<br>". $target_file."<br>";
    if (move_uploaded_file($_FILES[$fileInstanceName]["tmp_name"][$index], $target_file)) {
        return true;
    } else {
        $_SESSION['error'] = "File could not be uploaded";
    }
    return false;
}
