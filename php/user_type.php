<?php

$user_types = array(
    "ViceChancellor",
    "internal office",
    "AccountsController",
    "CollegeInspector",
    "Librarian",
    "ExamController",
    "ChiefEngineer",
    "ChiefMedicalOfficer",
    "DirectorDPD",
    "DRTeacherCellRO",
    "DRAcademicCellRO",
    "DRHomeLoanBranchRO",
    "DRConfidentialBranchRO",
    "DepartmentChairman",
    "DRHigherStudyBranchRO"
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
    'ChiefEngineer',
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
