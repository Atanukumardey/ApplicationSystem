<?php
$deptArray = array(
    'ApplicationDate',
    'ApprovalDate',
    'DepartmentChairman',
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
    'DRHigherStudyBranchRO'
);

global $progressStateType;
$progressStateType = array(
    'Assigned' => 1,
    'InProgress' => 2,
    'Problem' => 3,
    'Approved' => 4,
    'Rejected' => 5,
    'NotAssigned' => 6,
    'ChairToReg' => 7,
    'RegToHigherStd' => 8,
    'HigherStdToDept' => 9,
    'HigherStdToReg' => 10,
    'RegToVC' => 11,
    'VCToReg' => 12,
    'RegToHigherStd2' => 13
);
//     
