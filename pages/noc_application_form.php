<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/personalInfo.php";
include "../php/session/session.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../index.php');
}
if ($_SESSION['Role'] != 'Applicant') {
    header('Location: ../index.php');
}  else {
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
        // foreach ($personalData as $key => $value) {
        //     echo $key . " -> " . $value . "<br>";
        // }
        ?>
        <div id='container'>
            <form id="job-form" action="../php/createNewApplication.php" method="POST" style="width:800px; margin:0 auto;">
                <section>
                    <h2 class="form-section-title">Personal Information</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Full Name</label>
                            <input name="Name" id="full-name" type="text" value="<?= $_SESSION['UserName']; ?>" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">NID Number</label>
                            <input name="NationalID" type="number" value="<?= $personalData['NationalID']; ?>" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="form-label">Working Unit</label>
                            <select name="WorkingUnit" id="WorkingUnit" value="<?= $personalData['WorkingUnit']; ?>" required>
                                <option value="" <?php if ($personalData['WorkingUnit'] == "") echo "selected"; ?>hidden>Select</option>
                                <option value="Department" <?php if ($personalData['WorkingUnit'] == "Department") echo "selected"; ?>>Department</option>
                                <option value="institute" <?php if ($personalData['WorkingUnit'] == "institute") echo "selected"; ?>>institute</option>
                                <option value="Office" <?php if ($personalData['WorkingUnit'] == "Office") echo "selected"; ?>>Office</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <input name="Designation" type="text" value="<?= $personalData['Designation']; ?>" required />
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-3">
                            <label for="" class="form-label">Designation</label>
                            <select name="designation" id="designation" required>
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
                        <div class="col-md-12 ">
                            <input name="Address" type="text" placeholder="House,Village or locality,Police Station or Upazila,District" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input name="PostCode" type="number" placeholder="Post Code" required />
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Work State</label>
                            <input name="Permanent" type="radio" value="yes" <?php if ($personalData['Permanent'] == "yes") echo 'checked'; ?> required /><span class="radio-selection">Permanent</span>
                            <input name="Permanent" type="radio" value="no" <?php if ($personalData['Permanent'] == "no") echo 'checked'; ?> /><span class="radio-selection"> NonPermanent</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Retirement Date</label>
                            <input name="RetirementDate" type="date" value="<?= $personalData['RetirementDate']; ?>" required />
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class=" form-section-title">Family</h2>
                    <section class="form-field-section">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Father/Husbands Name</label>
                                <input name="ReferenceName" type="text" value="<?= $personalData['ReferenceName']; ?>" required />
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-md-6">
                                <label class="form-label">Relation</label>
                                <input name="Relation" type="radio" value="Father" <?php if ($personalData['Relation'] == "Father") echo 'checked'; ?> required /><span class="radio-selection">Father</span>
                                <input name="Relation" type="radio" value="Husband" <?php if ($personalData['Relation'] == "Husband") echo 'checked'; ?> /><span class="radio-selection"> Husband</span>
                            </div>
                        </div>
                    </section>

                    <section class="form-field-section">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Child 1</label>
                                <input name="Child1Name" type="text" value="<?= $personalData['Child1Name']; ?>" placeholder=" Name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input name="Child1Age" type="number" value="<?= $personalData['Child1Age']; ?>" placeholder=" Age"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Gender: </label>
                                <input name="Child1Gender" type="radio" value="male" <?php if ($personalData['Child1Gender'] == "male") echo 'checked'; ?> /><span class="radio-selection">Male</span>
                                <input name="Child1Gender" type="radio" value="female" <?php if ($personalData['Child1Gender'] == "female") echo 'checked'; ?> /><span class="radio-selection"> Female</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Child 2</label>
                                <input name="Child2Name" type="text" value="<?= $personalData['Child2Name']; ?>" placeholder=" Name"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input name="Child2Age" type="number" value="<?= $personalData['Child2Age']; ?>" placeholder=" Age" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Gender: </label>
                                <input name="Child2Gender" type="radio" value="male" <?php if ($personalData['Child2Gender'] == "male") echo 'checked'; ?>  /><span class="radio-selection">Male</span>
                                <input name="Child2Gender" type="radio" value="female" <?php if ($personalData['Child2Gender'] == "female") echo 'checked'; ?> /><span class="radio-selection"> Female</span>
                            </div>
                        </div>
                    </section>
                    <div class="row-6" style="display:flex; flex-direction:row; justify-content:space-evenly; padding-block:30px">
                        <input type="submit" class="submit" name="submit" id="submit" value="Submit" />
                        <input type="reset" class="reset" name="reset" id="reset" value="Reset" />
                    </div>
            </form>
        </div>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>