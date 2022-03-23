<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/Users.php";
include "../php/db/accessUtility/personalInfo.php";
include "../php/session/session.php";
include "../php/db/accessUtility/process.php";
include "../php/db/accessUtility/nocApplication.php";

sessionStart(0, '/', 'localhost', true, true);



if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
} else {
    if (isset($_GET['submit']) && $_GET['submit'] == 'Approve') {
        $inputData[$_SESSION['Department']] = 4; // Approved in processstatus;
        // edit needed
        //print_r($_GET);
        echo "<br><br>";
        ///print_r($inputData);
        $NocData = getnocApplicationsByNocID($_GET['NocID'], $conn);
        foreach ($NocData as $key => $value) {
            echo "<br>'$value'<br>";
        }
        $processID = $NocData['ProcessIDref'];
        echo "<br><br>";
        if (updateProcess($processID, $inputData, $conn)) {
            $_SESSION['success'] = 'Approved';
            header('Location: office_home.php');
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Application</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
        <link rel="stylesheet" href="../css/nocform_style.css">
        <link rel="stylesheet" href="../css/user_home_style.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">
    </head>

    <body>
        <?php
        include("../html/pageNavbar.php");
        $ApplicantspersonalData = getPersonalInfo($_GET['ApplicantID'], $conn);
        $ApplicantUserData = getUserByUserID($_GET['ApplicantID'], $conn);
        $ApplicantspersonalData = array_merge($ApplicantspersonalData, $ApplicantUserData);
        if ($ApplicantspersonalData == null) {
            $ApplicantspersonalData['UserName'] = "";
            $ApplicantspersonalData['Designation'] = "";
            $ApplicantspersonalData['WorkingUnit'] = "";
            $ApplicantspersonalData['Permanent'] = "";
            $ApplicantspersonalData['NationalID'] = "";
            $ApplicantspersonalData['ReferenceName'] = "";
            $ApplicantspersonalData['Relation'] = "";
            $ApplicantspersonalData['Child1Name'] = "";
            $ApplicantspersonalData['Child2Name'] = "";
            $ApplicantspersonalData['Child1Gender'] = "";
            $ApplicantspersonalData['Child2Gender'] = "";
            $ApplicantspersonalData['Child1Age'] = "";
            $ApplicantspersonalData['Child2Age'] = "";
            $ApplicantspersonalData['RetirementDate'] = "";
        }
        //print_r($ApplicantspersonalData);

        $formActionDestination = "";
        if ($_SESSION['Department'] == 'Registrar') {
            $formActionDestination = "registrar_task_assign.php";
        } else {
            $formActionDestination = ""; //../php/office_form_operations.php
        }

        ?>
        <div id='container'>
            <form id="job-form" action='<?php echo  $formActionDestination; ?>' method="GET" style="width:800px; margin:0 auto;">
                <section>
                    <h2 class="form-section-title">Applicants Information</h2>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Full Name</label>
                            <input name="Name" id="full-name" type="text" value="<?= $ApplicantspersonalData['UserName']; ?>" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">NID Number</label>
                            <input name="NationalID" type="number" value="<?= $ApplicantspersonalData['NationalID']; ?>" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label">Working Unit</label>
                            <input name="workingunit" id="workingunit" type="text" value="<?= $ApplicantspersonalData['WorkingUnit']; ?>" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Designation</label>
                            <input name="Designation" type="text" value="<?= $ApplicantspersonalData['Designation']; ?>" readonly />
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-3">
                            <label for="" class="form-label">Designation</label>
                            <select name="designation" id="designation" readonly>
                                <option value="" selected hidden>Select</option>
                                <option value="1">Professor</option>
                                <option value="2">Associate Prof.</option>
                                <option value="3">Assistant Prof.</option>
                                <option value="4">Lecturer</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="row">
                        <label class="form-label">Address</label>
                        <div class="col-6 ">
                            <input name="Address" type="text" placeholder="House,Village or locality,Police Station or Upazila,District" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input name="PostCode" type="number" placeholder="Post Code" readonly />
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Work State</label>
                            <input name="Permanent" type="radio" value="yes" <?php if ($ApplicantspersonalData['Permanent'] == "yes") echo 'checked'; ?> readonly /><span class="radio-selection">Permanent</span>
                            <input name="Permanent" type="radio" value="no" <?php if ($ApplicantspersonalData['Permanent'] == "no") echo 'checked'; ?> /><span class="radio-selection"> NonPermanent</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Retirement Date</label>
                            <input name="RetirementDate" type="date" value="<?= $ApplicantspersonalData['RetirementDate']; ?>" readonly />
                        </div>
                    </div>
                </section>

                <section>
                    <section class="form-field-section">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Father/Husbands Name</label>
                                <input name="ReferenceName" type="text" value="<?= $ApplicantspersonalData['ReferenceName']; ?>" readonly />
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-6">
                                <label class="form-label">Relation</label>
                                <input name="Relation" type="radio" value="Father" <?php if ($ApplicantspersonalData['Relation'] == "Father") echo 'checked'; ?> readonly /><span class="radio-selection">Father</span>
                                <input name="Relation" type="radio" value="Husband" <?php if ($ApplicantspersonalData['Relation'] == "Husband") echo 'checked'; ?> /><span class="radio-selection"> Husband</span>
                            </div>
                        </div>
                    </section>

                    <section class="form-field-section">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Child 1</label>
                                <input name="Child1Name" type="text" value="<?= $ApplicantspersonalData['Child1Name']; ?>" placeholder=" Name" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input name="Child1Age" type="number" value="<?= $ApplicantspersonalData['Child1Age']; ?>" placeholder=" Age" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Gender: </label>
                                <input name="Child1Gender" type="radio" value="male" <?php if ($ApplicantspersonalData['Child1Gender'] == "male") echo 'checked'; ?> readonly /><span class="radio-selection">Male</span>
                                <input name="Child1Gender" type="radio" value="female" <?php if ($ApplicantspersonalData['Child1Gender'] == "female") echo 'checked'; ?> /><span class="radio-selection"> Female</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Child 2</label>
                                <input name="Child2Name" type="text" value="<?= $ApplicantspersonalData['Child2Name']; ?>" placeholder=" Name" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input name="Child2Age" type="number" value="<?= $ApplicantspersonalData['Child2Age']; ?>" placeholder=" Age" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Gender: </label>
                                <input name="Child2Gender" type="radio" value="male" <?php if ($ApplicantspersonalData['Child2Gender'] == "male") echo 'checked'; ?> readonly /><span class="radio-selection">Male</span>
                                <input name="Child2Gender" type="radio" value="female" <?php if ($ApplicantspersonalData['Child2Gender'] == "female") echo 'checked'; ?> /><span class="radio-selection"> Female</span>
                            </div>
                        </div>
                    </section>
                    <input type="hidden" name="NocID" value='<?= $_GET['NocID'] ?>'>
                    <div class="row-6" style="display:flex; flex-direction:row; justify-content:space-evenly; padding-block:30px">
                        <?php $submitText = $_SESSION['Department'] == 'Registrar' ? 'Proceed' : 'Approve'; ?>
                        <input type="submit" class="submit" name="submit" id="submit" value=<?= json_encode($submitText) ?> />
                        <input type="reset" class="reset" name="reset" id="reset" value="Problem" />
                        <input type="hidden" name="NocID" value=<?= $_GET['NocID'] ?>>
                        <input type="hidden" name="ApplicantID" value=<?= $_GET['ApplicantID'] ?>>
                    </div>
            </form>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>