<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/personalInfo.php";
include "../php/session/session.php";

sessionStart(0, '/', 'localhost', true, true);

if (1 != 1) { //!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])
    header('Location: ../index.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel=" stylesheet" href="../css/Applicant/profile.css">
        <link rel="stylesheet" href="../css/user_home_style.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">
        <!-- <link rel="stylesheet" href="../css/nocform_style.css">
      -->
    </head>

    <body>
        <div style="max-width: 70vw;">
            <?php
            include("../html/pageNavbar.php");
            ?>
        </div>
        <?php
        $personalData = getPersonalInfo($_SESSION['UserID'], $conn);
        if ($personalData == null) {
            $personalData['Designation'] = "";
            $personalData['WorkingUnit'] = "";
            $personalData['Permanent'] = "";
            $personalData['NationalID'] = "";
            $personalData['ReferenceName'] = "";
            $personalData['Relation'] = "";
            $personalData['Child1Name'] = "";
            $personalData['Child2Name'] = "";
            $personalData['Child1Gender'] = "";
            $personalData['Child2Gender'] = "";
            $personalData['Child1Age'] = "";
            $personalData['Child2Age'] = "";
            $personalData['RetirementDate'] = "";
            $personalData['ProfileIMGDirectory '] = "";
        }
        ?>
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="mt-5" style="border-radius: 10%;" src="../assets/image/user-default.png" width="250" height="250">
                        <span class="font-weight-bold"><?= $_SESSION['UserName']; ?></span><span class="text-black-50"><?= $_SESSION['Email']; ?></span><span> </span>
                    </div>
                </div>
                <div class="col-md-8 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Full Name</label>
                                <input name="Name" id="full-name" type="text" class="form-control" value="<?= $_SESSION['UserName']; ?>" required />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input name="UserEmail" type="text" class="form-control" placeholder="enter email id" value="<?= $_SESSION['Email']; ?>" required />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Phone Number</label>
                                <input name="UserPhone" type="text" class="form-control" placeholder="enter phone number" value="<?= $_SESSION['Mobile']; ?>" required />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">NID Number</label>
                                <input name="NationalID" type="number" class="form-control" value="<?= $personalData['NationalID']; ?>" required />
                            </div>
                            <div class="col-md-12">
                                <label for="" class="labels">Working Unit</label>
                                <select name="WorkingUnit" id="WorkingUnit" class="form-control" value="<?= $personalData['WorkingUnit']; ?>" required>
                                    <option value="" <?php if ($personalData['WorkingUnit'] == "") echo "selected"; ?>hidden>Select</option>
                                    <option value="Department" <?php if ($personalData['WorkingUnit'] == "Department") echo "selected"; ?>>Department</option>
                                    <option value="institute" <?php if ($personalData['WorkingUnit'] == "institute") echo "selected"; ?>>institute</option>
                                    <option value="Office" <?php if ($personalData['WorkingUnit'] == "Office") echo "selected"; ?>>Office</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Designation</label>
                                <input name="Designation" type="text" class="form-control" value="<?= $personalData['Designation']; ?>" required />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Work State</label>
                                <br>
                                <input name="Permanent" type="radio" value="yes" <?php if ($personalData['Permanent'] == "yes") echo 'checked'; ?> required />
                                <span class="radio-selection">Permanent</span>
                                <input name="Permanent" type="radio" value="no" <?php if ($personalData['Permanent'] == "no") echo 'checked'; ?> />
                                <span class="radio-selection"> NonPermanent</span>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Retirement Date</label>
                                <input name="RetirementDate" type="date" class="form-control" value="<?= $personalData['RetirementDate']; ?>" required />
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Family Information</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Father/Husbands Name</label>
                                <input name="ReferenceName" type="text" class="form-control" value="<?= $personalData['ReferenceName']; ?>" required />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Relation</label>
                                <br>
                                <input name="Relation" type="radio" value="Father" <?php if ($personalData['Relation'] == "Father") echo 'checked'; ?> required /><span class="radio-selection">Father</span>
                                <input name="Relation" type="radio" value="Husband" <?php if ($personalData['Relation'] == "Husband") echo 'checked'; ?> /><span class="radio-selection"> Husband</span>
                            </div>
                        </div>
                        <br>
                        <h7 class="text-right"><b>Child 1 Information(If Applicable)</b></h7>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Name</label>
                                <input name="Child1Name" type="text" class="form-control" value="<?= $personalData['Child1Name']; ?>" placeholder=" Name" />
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Age</label>
                                <input name="Child1Age" type="number" class="form-control" value="<?= $personalData['Child1Age']; ?>" placeholder=" Age" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Gender: </label>
                                <br>
                                <input name="Child1Gender" type="radio" value="male" <?php if ($personalData['Child1Gender'] == "male") echo 'checked'; ?> /><span class="radio-selection">Male</span>
                                <input name="Child1Gender" type="radio" value="female" <?php if ($personalData['Child1Gender'] == "female") echo 'checked'; ?> /><span class="radio-selection"> Female</span>
                            </div>
                        </div>
                        <br>
                        <h7 class="text-right"><b>Child 2 Information(If Applicable)</b></h7>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Name</label>
                                <input name="Child2Name" type="text" class="form-control" value="<?= $personalData['Child2Name']; ?>" placeholder=" Name" />
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Age</label>
                                <input name="Child2Age" type="number" class="form-control" value="<?= $personalData['Child2Age']; ?>" placeholder=" Age" />
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Gender: </label>
                                <br>
                                <input name="Child2Gender" type="radio" value="male" <?php if ($personalData['Child2Gender'] == "male") echo 'checked'; ?> /><span class="radio-selection">Male</span>
                                <input name="Child2Gender" type="radio" value="female" <?php if ($personalData['Child2Gender'] == "female") echo 'checked'; ?> /><span class="radio-selection"> Female</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>