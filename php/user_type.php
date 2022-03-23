<?php

$user_types = array(
    "internal office", "Accounts Controller", "College Inspector", "Librarian", "Exam Controller", "Chief Engineer", "Chief Medical Officer",
    "Director, Department of Planning and Development", "Deputy Registrar (Teacher Cell), Registrar's Office",
    "Deputy Registrar (Academic Cell), Registrar's Office", "Deputy Registrar (Home Loan Branch), Registrar's Office",
    "Deputy Registrar (Confidential Branch) Registrar's Office", "DepartmentChairman"
);

function checkUser($user)
{
    foreach ($GLOBALS['user_types'] as $values) {
        if ($user === $values) {
            return true;
        }
    }
    return false;
}

function checkDept($dept)
{
    if (checkUser($dept))
        return true;
    if ($dept == "Registrar")
        return true;

    return false;
}

$DBuserconstrains = array(
    '',
    'Applicant',
    'AccountsController',
    'CollegeInspector',
    'Librarian',
    'ExamController',
    'Chief Engineer',
    'ChiefMedicalOfficer',
    'DirectorDPD',
    'DRTeacherCellRO',
    'DRAcademicCellRO',
    'DRHomeLoneBranchRO',
    'DRConfidentialBranchRO',
    'Verifier',
    'Admin',
    'DepartmentChairman',
    'Registrar'
);

//print_r($DBuserconstrains[16]);
