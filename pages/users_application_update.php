<?php

include "../php/db/database_connect.php";
include "../php/db/accessUtility/process.php";
include "../php/session/session.php";
include "../php/db/accessUtility/studyleaveapplication.php";

sessionStart(0, '/', 'localhost', true, true);

if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID']) || $_SESSION['Role'] != 'Applicant') {
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
			$Progressstate = null;
			if (isset($_GET['ApplicationID'])) {
				$Progressstate = getStudyLeaveApplicationProgressState($_GET['ApplicationID'], $conn); // getProcessProgressByNocID($_POST['NocID'], $conn);
				$Progressstate = $Progressstate['ProgressState'];
			}
			// print_r($Progressstate);
			if ($Progressstate == null) {
			?>
				<div class="card-columns mx-auto d-flex justify-content-center col-12">
					<div class="applicationcard" style="width: 40rem;">
						<div class="card-body">
							<div class="col">
								<img src="../assets/image/form.png" alt="img" class="dept-icon" object-fit: contain;>
							</div>
							<div class="col">
								<h5 class="card-text">Authority hasn't seen your application.
									You will see an update after the process starts.</h5>
							</div>
						</div>
					</div>
				</div>
			<?php
			} else {
				$colors['Approved'] = "#68E186";
				$colors['InProgress'] = "#E9EE38";
				$colors['Rejected'] = "#F46464";
				$departmentColor;
			?>
				<div class="third">
					<div class='row' style="display:flex; flex-direction:row; justify-content:space-around; padding-block:30px;">
						<div class='col-3'>
							<h3>বিভাগ/কেন্দ্র/দপ্তর</h3>
						</div>
						<div class='col-6' id='div_color_snippet'>
							<ul id='ul_color_snippet'>
								<li><i class="fas fa-circle" style="color: #E9EE38;"></i>InProgress</li>
								<li><i class="fas fa-circle" style="color: #68E186;"></i>Approved</li>
								<li><i class="fas fa-circle" style="color: #F46464;"></i>Rejected</li>
							</ul>
						</div>
					</div>
					<div class="departments">
						<?php
						$departmentColor['DepartmentChairman'] = "none";
						$dept = 6;
						if ($Progressstate > 5) {
							$departmentColor['DepartmentChairman'] = $colors['InProgress'];
							if ($Progressstate > 6) {
								$departmentColor['DepartmentChairman'] = $colors['Approved'];
							}
						}
						printDepartment("Department Chairman, <br />CU", $departmentColor['DepartmentChairman'], "fas fa-user-tie fa-4x", $dept);
				$dept = 7;
						$departmentColor['Registrar'] = "none";
						if ($Progressstate > 6) {
							$departmentColor['Registrar'] = $colors['InProgress'];
							if ($Progressstate > 7) {
								$departmentColor['Registrar'] = $colors['Approved'];
							}
						}
						printDepartment("Registrar Office, <br />CU", $departmentColor['Registrar'], "fas fa-registered fa-4x", $dept);
				$dept = 8;
						$departmentColor['HigherStudy'] = "none";
						if ($Progressstate > 7) {
							$departmentColor['HigherStudy'] = $colors['InProgress'];
							if ($Progressstate > 8) {
								$departmentColor['HigherStudy'] = $colors['Approved'];
							}
						}
						printDepartment("Higher Study Branch, <br />CU", $departmentColor['HigherStudy'], "fa fa-graduation-cap fa-4x", $dept);
				$dept = 9;
						$departmentColor['HigherStdToDept'] = "none";
						if ($Progressstate > 8) {
							$departmentColor['HigherStdToDept'] = $colors['InProgress'];
							if ($Progressstate > 9) {
								$departmentColor['HigherStdToDept'] = $colors['Approved'];
							}
						}
						printDepartment("Assigned To different Department, <br />CU", $departmentColor['HigherStdToDept'], "fas fa-university fa-4x", $dept);
				$dept = 10;
						$departmentColor['Registrar'] = "none";
						if ($Progressstate > 9) {
							$departmentColor['Registrar'] = $colors['InProgress'];
							if ($Progressstate > 10) {
								$departmentColor['Registrar'] = $colors['Approved'];
							}
						}
						printDepartment("Registrar Office, <br />CU", $departmentColor['Registrar'], "fas fa-registered fa-4x", $dept);
				$dept = 11;
						$departmentColor['ViceChancellor'] = "none";
						if ($Progressstate > 10) {
							$departmentColor['ViceChancellor'] = $colors['InProgress'];
							if ($Progressstate > 11) {
								$departmentColor['ViceChancellor'] = $colors['Approved'];
							}
						}
						printDepartment("Vice Chancellor Office, <br />CU", $departmentColor['ViceChancellor'], "fas fa-user-alt fa-4x", $dept);
				$dept = 12;
						$departmentColor['Registrar'] = "none";
						if ($Progressstate > 11) {
							$departmentColor['Registrar'] = $colors['InProgress'];
							if ($Progressstate > 12) {
								$departmentColor['Registrar'] = $colors['Approved'];
							}
						}
						printDepartment("Registrar Office, <br />CU", $departmentColor['Registrar'], "fas fa-registered fa-4x", $dept);
				$dept = 13;
						$departmentColor['HigherStudy'] = "none";
						if ($Progressstate > 12) {
							$departmentColor['HigherStudy'] = $colors['InProgress'];
							if ($Progressstate > 13) {
								$departmentColor['HigherStudy'] = $colors['Approved'];
							}
						}
						printDepartment("Higher Study Branch, <br />CU", $departmentColor['HigherStudy'], "fa fa-graduation-cap fa-4x", $dept);
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
function printDepartment($Department, $color, $icon, $dept)
{
	// echo $Progressstate;
?>
	<div class="department">
		<label>
			<?php if ($dept == 9) { ?>
				<a href="users_application_updates.php?ApplicationID=<?= $_GET['ApplicationID'] ?>">
				<?php } ?>
				<span>
					<div class="img" style="background-color:<?php echo $color ?>;">
						<i class="<?= $icon ?>" style='color:rgb(24, 49, 83)'></i>
						<!-- <img src="../assets/image/school.png" class="dept-icon"> -->
					</div>
					<div class="box">
						<h8><?php echo $Department; ?></h8>
					</div>
				</span>
				<?php if ($dept == 9) { ?>
				</a>
			<?php } ?>
		</label>
	</div>
<?php } ?>