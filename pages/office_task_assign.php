<?php
include "../php/db/database_connect.php";
include "../php/db/accessUtility/process.php";
include "../php/db/accessUtility/studyleaveapplication.php";
include "../php/util/backendutil.php";
include "../php/session/session.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] == 'Applicant') {
    header('Location: ../userManagement/logout.php');
} else {
    //echo $_GET['processID']."    ".$_GET['ApplicationID']."<br>";
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
        $progressStateInfo = getProcess($_GET['processID'], $conn);
        $ApprovalState = getStudyLeaveApplicationByApplicationID($_GET['ApplicationID'], $conn);
        $ApprovalState = $ApprovalState['ProgressState'];
        global $departmentColor;
        $departmentColor = array();
        global $progressStateType;
        if (isset($_GET['showstatus'])) {
            global $progressStateInfo;
            global $colors;
            $colors = array();
            $colors['Approved'] = "#68E186";
            $colors['InProgress'] = "#E9EE38";
            $colors['Rejected'] = "#F46464";
            $colors['Assigned'] = "#62DCF3";
            foreach ($progressStateInfo as $key => $value) {
                if ($value == '2') {
                    $departmentColor[$key] = $colors['InProgress'];
                } else if ($value == '1') {
                    $departmentColor[$key] = $colors['Assigned'];
                } else if ($value == '4') {
                    $departmentColor[$key] = $colors['Approved'];
                } else if ($value == '5') {
                    $departmentColor[$key] = $colors['Rejected'];
                } else {
                    $departmentColor[$key] = "none";
                }
            }
        } else {
            foreach ($progressStateInfo as $key => $value) {
                $departmentColor[$key] = "none";
            }
        }
        ?>
        <div class="c_container">
            <div class="third">
                <div class='row' style="display:flex; flex-direction:row; justify-content:space-around; padding-block:30px;">
                    <?php if (isset($_GET['showstatus'])) { ?>
                        <div class='col-6'>
                            <h4> Select Departments For Assigning Task </h4>
                        </div>
                    <?php } else { ?>
                        <div class='col-12'>
                            <h4> Select Departments For Assigning Task </h4>
                        </div>
                    <?php
                    } ?>
                    <?php if (isset($_GET['showstatus'])) { ?>
                        <div class='col-6' id='div_color_snippet'>
                            <ul id='ul_color_snippet'>
                                <li><i class="fas fa-circle" style="color: #62DCF3;"></i>Assigned</li>
                                <li><i class="fas fa-circle" style="color: #E9EE38;"></i>InProgress</li>
                                <li><i class="fas fa-circle" style="color: #68E186;"></i>Approved</li>
                                <li><i class="fas fa-circle" style="color: #F46464;"></i>Rejected</li>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class='col-12'>
                        <h3>বিভাগ/কেন্দ্র/দপ্তর</h3>
                    </div>
                </div>
                <form action="../php/office_task_assign_to_dept.php" method="POST">
                    <input type='hidden' name='ApplicationID' value='<?= $_GET['ApplicationID'] ?>'>
                    <div class="departments">
                        <?php

                        printDepartmentSelectionTile("সভাপতি,সংশ্লিষ্ট বিভাগ, <br /> চ. বি.", 'DepartmentChairman', $departmentColor['DepartmentChairman']);

                        printDepartmentSelectionTile("হিসাব নিয়ামক, <br /> চ. বি.", 'AccountsController', $departmentColor['AccountsController']);

                        printDepartmentSelectionTile("গ্রন্থাগারিক, <br /> চ.বি.", 'Librarian', $departmentColor['Librarian']);

                        printDepartmentSelectionTile("কলেজ পরিদর্শক, <br /> চ. বি.", 'CollegeInspector', $departmentColor['CollegeInspector']);

                        printDepartmentSelectionTile("পরীক্ষা নিয়ন্ত্রক, <br /> চ. বি.", 'ExamController', $departmentColor['ExamController']);

                        printDepartmentSelectionTile("প্রধান প্রকৌশলী, <br /> চ. বি", 'ChiefEngineer', $departmentColor['ChiefEngineer']);

                        printDepartmentSelectionTile("পরিচালক, পরিকল্পনা ও উন্নয়ন দপ্তর <br /> চ. বি. ", 'DirectorDPD', $departmentColor['DirectorDPD']);

                        printDepartmentSelectionTile("উপ রেজিস্ট্রার <br /> (শিক্ষক সেল) রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRTeacherCellRO', $departmentColor['DRTeacherCellRO']);

                        printDepartmentSelectionTile("চীফ মেডিকেল অফিসার, <br /> চ. বি. ", 'ChiefMedicalOfficer', $departmentColor['ChiefMedicalOfficer']);

                        printDepartmentSelectionTile("ডেপুটি রেজিস্ট্রার <br /> (একাডেমিক শাখা) রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRAcademicCellRO', $departmentColor['DRAcademicCellRO']);

                        printDepartmentSelectionTile("ডেপুটি রেজিস্ট্রার <br /> (গৃহ ঋণ শাখা), রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRHomeLoneBranchRO', $departmentColor['DRHomeLoanBranchRO']);

                        printDepartmentSelectionTile("ডেপুটি রেজিস্ট্রার <br /> (গোপনীয় শাখা) রেজিস্ট্রার অফিস, <br /> চ. বি.", 'DRConfidentialBranchRO', $departmentColor['DRConfidentialBranchRO']);

                        ?>
                    </div>
                    <br><br>
                    <div class="row-6" style="display:flex; flex-direction:row; justify-content:space-evenly; padding-block:30px">
                        <input type="submit" class="submit" name="submit" id="submit" value=<?php if ($ApprovalState == $progressStateType['AllDeptApproved']) {
                                                                                                echo "SendToRegistrar";
                                                                                            } else {
                                                                                                echo "Assign";
                                                                                            } ?> />
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
    function printDepartmentSelectionTile($Department, $DepartmentKey, $color)
    {
    ?>
        <div class="department">
            <label>
                <input class="deptassignopt" name='<?= $DepartmentKey ?>' type="checkbox" value='Assigned' />
                <span>
                    <div class="img" style="background-color:<?php echo $color ?>;">
                        <img src="../assets/image/school.png" class="dept-icon">
                    </div>
                    <div class="box">
                        <h8><?php echo $Department; ?></h8>
                    </div>
                </span>
            </label>
        </div>
    <?php } ?>