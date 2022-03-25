<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/process.php";
include "../php/session/session.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
} else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
        <link rel="stylesheet" href="../css/nocform_style.css">
        <!-- <link rel="stylesheet" href="../css/user_home_style.css"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">
        <script src="../js/sweetalert2.min.js"></script>
        <title>Application Progress</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">


        <link rel="stylesheet" href="../css/user_home_style.css">
    </head>

    <body>
        <?php
        include("../html/pageNavbar.php");
        ?>
        <div class="c_container">
            <div class="third">
                <br>
                <br>
                <h4> Select Departments For Assigning Task </h4>
                <br>
                <h3>বিভাগ/কেন্দ্র/দপ্তর</h3>
                <form action="../php/office_task_assign_to_dept.php" method="POST">
                    <input type='hidden' name='ApplicationID' value='<?= $_GET['ApplicationID'] ?>'>
                    <div class="departments">
                        <?php

                        printDepartmentSelectionTile("সভাপতি,সংশ্লিষ্ট বিভাগ, <br /> চ. বি.", 'DepartmentChairman');

                        printDepartmentSelectionTile("হিসাব নিয়ামক, <br /> চ. বি.", 'AccountsController');

                        printDepartmentSelectionTile("গ্রন্থাগারিক, <br /> চ.বি.", 'Librarian');

                        printDepartmentSelectionTile("কলেজ পরিদর্শক, <br /> চ. বি.", 'CollegeInspector');

                        printDepartmentSelectionTile("পরীক্ষা নিয়ন্ত্রক, <br /> চ. বি.", 'ExamController');

                        printDepartmentSelectionTile("প্রধান প্রকৌশলী, <br /> চ. বি", 'ChiefEngineer');

                        printDepartmentSelectionTile("পরিচালক, পরিকল্পনা ও উন্নয়ন দপ্তর <br /> চ. বি. ", 'DirectorDPD');

                        printDepartmentSelectionTile("উপ রেজিস্ট্রার <br /> (শিক্ষক সেল) রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRTeacherCellRO');

                        printDepartmentSelectionTile("চীফ মেডিকেল অফিসার, <br /> চ. বি. ", 'ChiefMedicalOfficer');

                        printDepartmentSelectionTile("ডেপুটি রেজিস্ট্রার <br /> (একাডেমিক শাখা) রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRAcademicCellRO');

                        printDepartmentSelectionTile("ডেপুটি রেজিস্ট্রার <br /> (গৃহ ঋণ শাখা), রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRHomeLoneBranchRO');

                        printDepartmentSelectionTile("ডেপুটি রেজিস্ট্রার <br /> (গোপনীয় শাখা) রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRConfidentialBranchRO');

                        ?>
                    </div>
                    <br><br>
                    <div class="row-6" style="display:flex; flex-direction:row; justify-content:space-evenly; padding-block:30px">
                        <input type="submit" class="submit" name="submit" id="submit" value="Assign" />
                        <input type="reset" class="reset" name="reset" id="reset" value="Reset" />
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
    </body>
    <?php
    include('../html/footer.html');
    ?>

    </html>
    <?php
    function printDepartmentSelectionTile($Department, $DepartmentKey)
    {
    ?>
        <div class="department">
            <label>
                <input class="deptassignopt" name='<?= $DepartmentKey ?>' type="checkbox" value='Assigned' />
                <span>
                    <div class="img">
                        <img src="../assets/image/school.png" class="dept-icon">
                    </div>
                    <div class="box">
                        <h8><?php echo $Department; ?></h8>
                    </div>
                </span>
            </label>
        </div>
    <?php } ?>