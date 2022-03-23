<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/nocApplication.php";
include "../php/db/accessUtility/process.php";
include "../php/session/session.php";
include "../php/util/pageutil.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
} else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
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
        ?>
        <div class="sidenav">
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#clients">Clients</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="c_container">
            <?php
            if (!isset($_SESSION['logedIN'])) {
                loginSuccess();
                $_SESSION['logedIN'] = true;
            }
            include("../html/pageNavbar.php");
            ?>
            <br><br>
            <?php
            printApplications($conn, "New Applications", 'Assigned');
            printApplications($conn, "Inprogress Applications", 'InProgress');
            ?>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>


<?php
function printApplications(&$conn, $state, $applicationProgressState)
{
?>
    <h3 style="padding-left: 20px; padding-top: 20px;"><?= $state ?></h3>
    <br>
    <div class="applicationformsupdate">
        <?php
        printNocApplications($conn, $applicationProgressState)
        ?>
    </div>
    <br><br>
<?php
}
?>

<?php
function printNocApplications(&$conn, $progressState)
{
    $row = getnocProcessByDepartment($conn, $progressState, $_SESSION['Department']);
    if ($row != null) {
        foreach ($row as $applicationdata) {
            $applicationdata['ApplicationName'] = " No objection Certificate";
            createApplicationUpdateTile($applicationdata);
        }
        return true;
    }
}
?>

<?php
function createApplicationUpdateTile($Applicationdata)
{
?>
    <div class="applicationupdatecard">
        <div class="card-body" style="display: flex; flex-direction:row; justify-content:space-between">
            <div class="row">
                <img src="../assets/image/form.png" alt="form" class="dept-icon">
            </div>
            <h4 class="card-text" style="width: max-content;"><?= $Applicationdata['ApplicationName'] ?></h4>
            <p style="width: max-content;"> Application Date: <?= $Applicationdata['ApplicationDate']; ?> </p>
            <div>
                <form action="application_check_office.php" method="post" class="col" style="height: inherit;">
                    <button type='submit' name='NocID' value="<?= $Applicationdata['NocID']; ?>" class=" btn-primary btn-sm" style="padding-right: 20px; width:inherit; height:auto;" method="get" ">Details</button>
                    <input type = 'hidden' name='ApplicantID' value=" <?= $Applicationdata['UserIDref']; ?>">
                </form>
            </div>
        </div>
    </div>

<?php
}
?>