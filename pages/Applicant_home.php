<?php
//phpinfo();
include "../php/db/database_connect.php";
include "../php/db/accessUtility/nocApplication.php";
include "../php/session/session.php";
include "../php/util/pageutil.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
}
if ($_SESSION['Role'] != 'Applicant') {
    header('Location: ../index.php');
} else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="../css/user_home_style.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">
        <script src="../js/sweetalert2.min.js"></script>
        <title>Home</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">
    </head>

    <body style="overflow-x: hidden;">

        <?php
        if (isset($_SESSION['error'])) {
            popupMessage('error', $_SESSION['error'], 'Ok');
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            popupMessage('success', $_SESSION['success'], 'Continue');;
            unset($_SESSION['success']);
        }
        if (!isset($_SESSION['logedIN'])) {
            loginSuccess();
            $_SESSION['logedIN'] = true;
        }
        ?>
        <div style="padding-left: 5px;">
            <?php
            include("../html/pageNavbar.php");
            ?>
        </div>
        <div class="c_container" style="margin-left: 10px;">
            <h3 style="padding-left: 20px; padding-top: 20px;">Application Forms</h3>
            <br><br>
            <div class="applicationforms">
                <?php
                createApplicationTile("noc_application_form.php", "No Objection Certificate", "fa fa-passport fa-4x");
                createApplicationTile("studyleave.php", "For  Abroad  Study", "fa fa-graduation-cap fa-4x");
                createApplicationTile("noc_application_form.php", "Leave Of Absence", "fa fa-location-arrow fa-4x");
                createApplicationTile("noc_application_form.php", "For Research Grant", "fa fa-search fa-4x");
                createApplicationTile("noc_application_form.php", "Demo", "fa fa-passport fa-4x");
                createApplicationTile("noc_application_form.php", "Demo", "fa fa-passport fa-4x");
                ?>
            </div>
            <br><br>
            <h3 style="padding-left: 20px; padding-top: 20px;">Application updates</h3>
            <br>
            <div class="applicationformsupdate">
                <?php
                $row = getnocApplicationsByUserID($_SESSION['UserID'], $conn);
                if ($row != null) {
                    foreach ($row as $applicationdata) {
                        createApplicationUpdateTile($applicationdata, "fa fa-passport fa-3x");
                    }
                } else {
                    echo "Not Available.";
                }
                ?>
            </div>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>

<?php
function createApplicationTile($link, $ApplicationType, $icon)
{
?>
    <div class="applicationcard">
        <div class="card-body">
            <div class="col">
                <!-- <img src="../assets/image/form.png" alt="form" class="dept-icon"> -->
                <i class="<?= $icon ?>" style="color:rgb(29, 70, 158)"></i>
            </div>
            <div class=" col">
                <h5 class="card-title"><?= $ApplicationType ?></h5>
            </div>
            <div class="card-text">
                <a href="<?= $link; ?>" class="card-link">Apply</a>
            </div>
        </div>
    </div>
<?php } ?>

<?php
function createApplicationUpdateTile($Applicationdata, $icon)
{
?>
    <div class="applicationupdatecard">
        <div class="card-body" style="display: flex; flex-direction:row; justify-content:space-between; overflow:hidden;">
            <div class="row">
                <i class="<?= $icon ?>" style="color:rgb(29, 70, 158)"></i>
            </div>
            <h4 class="card-text" style="width: max-content;"> No objection Certificate</h4>
            <p style="width: max-content;"> Application Date: <?= $Applicationdata['ApplicationDate']; ?> </p>
            <div>
                <form action="users_application_update.php" method="post" class="col" style="height: inherit;">
                    <button type="submit" name="NocID" value="<?= $Applicationdata['NocID']; ?>" class=" btn-primary btn-sm" style="padding-right: 20px; width:inherit; height:auto;" method="get" ">Check Progress</button>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
 