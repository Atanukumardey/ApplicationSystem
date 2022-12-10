<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/personalInfo.php";
include "../php/session/session.php";
include "../php/db/accessUtility/attachment.php";
include "../php/db/accessUtility/studyleaveapplication.php";
include "../php/db/accessUtility/Users.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    header('Location: ../userManagement/logout.php');
}
$validAccesspersons = array("DepartmentChairman", "ViceChancellor", "Registrar", "DRHigherStudyBranchRO");

$trueval = false;
for ($i = 0; $i < 4; $i++) {
    if ($_SESSION['Role'] == $validAccesspersons[$i]) {
        $trueval = true;
        break;
    }
}
if ($trueval = false) {
    header('Location: ../userManagement/logout.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Study Leave Application</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
        <link rel=" stylesheet" href="../css/Applicant/profile.css">
        <link rel="stylesheet" href="../css/user_home_style.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">
    </head>

    <body>
        <?php
        include("../html/pageNavbar.php");
        // will get user id and study leave id by get method

        $applicationID = $_GET['ApplicationID']; // ;
        $applicationData =  getStudyLeaveApplicationByApplicationID($applicationID, $conn);

        //print_r($applicationData);
        $attachmentData = getAttachments($conn, $applicationData['ProcessIDref']);
        //print_r($attachmentData);

        $ApplicantsPersonalData = getPersonalInfo($applicationData['UserIDref'], $conn);
        $ApplicantsUserData = getUserByUserID($applicationData['UserIDref'], $conn);

        // get applicant+aplication information by userid and studyleaveid [user join personal info join studyleave]

        ?>
        <form action="../php/officeOperationOnStudyLeave.php" method="POST" enctype="multipart/form-data" class="container rounded bg-white mt-5 mb-5" id="stdform">
            <div>
                <h3> Study Leave Application </h3>
            </div>
            <div class="row">
                <div class="col-md-7 border-end">
                    <div class="row mt-3">
                        <h5> Applicants Info</h5>
                        <div class="col-md-12">
                            <label class="labels">Applicant Name</label>
                            <input name="ApplicantName" type="name" class="form-control" placeholder="name" value="<?= $ApplicantsUserData['UserName']; ?>" readonly />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Department</label>
                            <input name="ApplicantDepartment" type="text" class="form-control" placeholder="Computer Science and Engineering" value="Computer Science and Engineering" readonly />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Designation</label>
                            <input name="Designation" type="text" class="form-control" placeholder="Professor" value="<?= $ApplicantsPersonalData['Designation'] ?>" readonly />
                        </div>
                    </div>
                    <hr />
                    <div class="row mt-3">
                        <h5> Program Info</h5>
                        <div class="col-md-12">
                            <label class="labels">Name Of Program</label>
                            <input name="NameOfProgram" id="name_of_program" type="text" class="form-control" placeholder="Phd" value="<?= $applicationData['NameOfProgram'] ?>" readonly />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Destination University/Organization Name</label>
                            <input name="University" type="text" class="form-control" placeholder="University Of Chittagong" value="<?= $applicationData['University'] ?>" readonly />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Department</label>
                            <input name="Department" type="text" class="form-control" placeholder=" Computer Science and Engineering " value="<?= $applicationData['Department'] ?>" readonly />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Financila Source</label>
                            <input name="FinancialSource" type="text" class="form-control" placeholder="Erasmus Mundus Category-A fellowship for Doctoral Program" value="<?= $applicationData['FinancialSource'] ?>" />
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Program Start Date</label>
                            <input name="ProgramStartDate" type="date" class="form-control" value="<?= $applicationData['StartsFrom'] ?>" readonly />
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Program Duration(Years)</label>
                            <input name="ProgramDuration" type="number" class="form-control" value="<?= $applicationData['ProgramDuration'] ?>" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Expected Date To Start The Leave</label>
                            <input name="LeaveStartDate" type="date" class="form-control" value="<?= $applicationData['LeaveStartDate'] ?>" readonly />
                        </div>
                    </div>
                </div>
                <div class="col-md-5 border-end">
                    <br>
                    <div class="row-mt-3">
                        <h5 style="color: red;">Available attachments regarding this application</h5>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <label for="attachments" class="form-label">Attachments</label>
                            </div>
                            <div class="custom-file" id="previousattachments" style="margin-top: 5px;">
                                <?php
                                $numofFile = 1;
                                if ($attachmentData != null) {
                                    foreach ($attachmentData as $attachment) { ?>
                                        <div class='row border-bottom'>
                                            <div class='col-md-12'>
                                                <b> <?= $numofFile++ ?>. </b>
                                                <a href="../php/fileDownload.php?file=<?= $attachment['Directory'] ?>&type=<?= $attachment['Type'] ?>" target="_blank" rel="noopener noreferrer" download="<?= $file ?>"><?= $attachment['Directory'] ?></a>
                                                <br>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                            <br>
                            <hr />
                            <hr />
                            <div class="row-mt-3">
                                <h5>In this section please provide any necessary documents related to the application.
                                    Documents should be in <i style="color:orangered">PDF</i> format and less than <i style="color:orangered">5MB</i> in size. </h5>
                            </div>
                            <br>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="custom-file">
                                        <label for="chooseFile" class="form-label">Attachments</label>
                                        <input class="form-control" name="FileUpload[]" type="file" id="chooseFile" multiple>
                                    </div>
                                    <div class="custom-file" id="inputfiles" style="margin-top: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container rounded mt-4 mb-0 " style="background-color:  rgb(232, 241, 241);">
                <div class="row" style="font-size:large;">
                    <b>
                        Please leave any necessary comments accroding to your action(proceed/reject) in this box. Respective personals will be informed with this given information.
                    </b>
                </div>
                <div class="row">
                    <textarea rows="5" cols="60" name="comments" style="width:45vw" form="stdform">
                    </textarea>
                </div>
            </div>

            <div class="container rounded mt-1 mb-5 ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Proceed</button></div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="reset" id="resetBtn">Reject</button></div>
                    </div>
                </div>
            </div>
            <input name="ApplicationID" type="hidden" value="<?= $applicationID ?>" />
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var len = input.files.length;
                    var inputFilesInfo = "<div>";
                    for (let i = 0; i < len; i++) {
                        inputFilesInfo += "<div class= 'row border-bottom'> <div class = 'col-md-12'><b>Filename:</b> <i>" +
                            input.files[i]['name'] + "</i></br><b>Size:</b> " +
                            parseInt((input.files[i]['size'] / 1024) + 1) + "KB</div></div>";
                    }
                    inputFilesInfo += "</div>"
                    reader.onload = function(e) {
                        document.getElementById("inputfiles").innerHTML = inputFilesInfo;
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            function resetBtnFunction() {
                document.getElementById("inputfiles").innerHTML = "";
            }
            $("#chooseFile").change(function() {
                readURL(this);
            });
            document.getElementById("resetBtn").onclick = function() {
                resetBtnFunction();
            };
        </script>
    </body>
    <?php include('../html/footer.html');
    ?>

    </html>
<?php } ?>