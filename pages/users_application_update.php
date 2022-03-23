<?php

include "../php/db/database_connect.php";
include "../php/db/accessUtility/process.php";
include "../php/session/session.php";

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
		<link rel="stylesheet" href="../css/bootstrap5/bootstrap.min.css">
		<link rel="stylesheet" href="../css/user_home_style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
		<link rel="stylesheet" href="../css/log_reg_footer.css">
		<title>Application Progress</title>
		<link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">
	</head>

	<body class="">
		<div class="c_container" style="min-height: 100vh;">
			<?php
			include("../html/pageNavbar.php");
			//echo "<br>" . $_POST['NocID'] . "<br>";
			$ProgressInfo = getProcessProgressByNocID($_POST['NocID'], $conn);
			if ($ProgressInfo == null) {
			?>
				<div class="card-columns mx-auto d-flex justify-content-center col-12">
					<div class="applicationcard" style="width: 40rem;">
						<div class="card-body">
							<div class="col">
								<img src="../assets/image/form.png" alt="img" class="dept-icon" object-fit: contain;>
							</div>
							<div class="col">
								<h5 class="card-text">Authority hasn't seen your application.
									You will see an update after the application is
									assigned to respective departments by authority.</h5>
							</div>
						</div>
					</div>
				</div>
			<?php
			} else {
				$colors['Approved'] = "#68E186";
				$colors['InProgress'] = "#E9EE38";
				$colors['Rejected'] = "#F46464";
				$colors['Assigned'] = "#62DCF3";
				$departmentColor;
				foreach ($ProgressInfo as $key => $value) {
					//echo $key." => ".$value."<br>";
					if ($value == '6') {
						continue;
					} else if ($value == '2') {
						$departmentColor[$key] = $colors['InProgress'];
					} else if ($value == '1') {
						$departmentColor[$key] = $colors['Assigned'];
					} else if ($value == '4') {
						$departmentColor[$key] = $colors['Approved'];
					} else if ($value == '5') {
						$departmentColor[$key] = $colors['Rejected'];
					} else {
						continue;
					}
				}
			?>
				<div class="third">
					<div class='row' style="display:flex; flex-direction:row; justify-content:space-around; padding-block:30px;">
						<div class='col-3'>
							<h3>বিভাগ/কেন্দ্র/দপ্তর</h3>
						</div>
						<div class='col-6' id='div_color_snippet'>
							<ul id='ul_color_snippet'>
								<li><i class="fas fa-circle" style="color: #62DCF3;"></i>Assigned</li>
								<li><i class="fas fa-circle" style="color: #E9EE38;"></i>InProgress</li>
								<li><i class="fas fa-circle" style="color: #68E186;"></i>Approved</li>
								<li><i class="fas fa-circle" style="color: #F46464;"></i>Rejected</li>
							</ul>
						</div>
					</div>
					<div class="departments">
						<?php
						if (isset($departmentColor['DepartmentChairman'])) {
							printDepartmentTile("সভাপতি,সংশ্লিষ্ট বিভাগ, <br /> চ. বি.", $departmentColor['DepartmentChairman']);
						}
						if (isset($departmentColor['AccountsController'])) {
							printDepartmentTile("হিসাব নিয়ামক, <br /> চ. বি.", $departmentColor['AccountsController']);
						}
						if (isset($departmentColor['Librarian'])) {
							printDepartmentTile("গ্রন্থাগারিক, <br /> চ.বি.", $departmentColor['Librarian']);
						}
						if (isset($departmentColor['CollegeInspector'])) {
							printDepartmentTile("কলেজ পরিদর্শক, <br /> চ. বি.", $departmentColor['CollegeInspector']);
						}
						if (isset($departmentColor['ExamController'])) {
							printDepartmentTile("পরীক্ষা নিয়ন্ত্রক, <br /> চ. বি.", $departmentColor['ExamController']);
						}
						if (isset($departmentColor['ChiefEngineer'])) {
							printDepartmentTile("প্রধান প্রকৌশলী, <br /> চ. বি", $departmentColor['ChiefEngineer']);
						}
						if (isset($departmentColor['DirectorDPD'])) {
							printDepartmentTile("পরিচালক, পরিকল্পনা ও উন্নয়ন দপ্তর <br /> চ. বি. ", $departmentColor['DirectorDPD']);
						}
						if (isset($departmentColor['DRTeacherCellRO'])) {
							printDepartmentTile("উপ রেজিস্ট্রার <br /> (শিক্ষক সেল) রেজিস্ট্রার অফিস, <br /> চ. বি.", $departmentColor['DRTeacherCellRO']);
						}
						if (isset($departmentColor['ChiefMedicalOfficer'])) {
							printDepartmentTile("চীফ মেডিকেল অফিসার, <br /> চ. বি. ", $departmentColor['ChiefMedicalOfficer']);
						}
						if (isset($departmentColor['DRAcademicCellRO'])) {
							printDepartmentTile("ডেপুটি রেজিস্ট্রার <br /> (একাডেমিক শাখা) রেজিস্ট্রার অফিস, <br /> চ. বি.", $departmentColor['DRAcademicCellRO']);
						}
						if (isset($departmentColor['DRHomeLoneBranchRO'])) {
							printDepartmentTile("ডেপুটি রেজিস্ট্রার <br /> (গৃহ ঋণ শাখা), রেজিস্ট্রার অফিস, <br /> চ. বি.", $departmentColor['DRHomeLoneBranchRO']);
						}
						if (isset($departmentColor['DRConfidentialBranchRO'])) {
							printDepartmentTile("ডেপুটি রেজিস্ট্রার <br /> (গোপনীয় শাখা) রেজিস্ট্রার অফিস, <br /> চ. বি.", $departmentColor['DRConfidentialBranchRO']);
						}
						?>
					</div>
				</div>
			<?php } ?>
		</div>
	</body>
	<?php
	// for ($i = 0; $i < 10; $i++) {
	// 	echo "<br>";
	// }
	include('../html/footer.html');
	?>

	</html>
<?php } ?>

<?php
function printDepartmentTile($Department, $color)
{
?>
	<div class="department">
		<div class="img" style="background-color:<?php echo $color ?>;">
			<img src="../assets/image/school.png" class="dept-icon">
		</div>
		<div class="box">
			<p><?php echo $Department; ?></p>
		</div>
	</div>
<?php } ?>