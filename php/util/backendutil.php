<?php



global $deptNameKey;
$deptNameKey = array(
    'DepratmentChairman',
    'AccountsController',
    'Librarian',
    'CollegeInspector',
    'ExamController',
    'ChiefEngineer',
    'DirectorDPD',
    'ChiefMedicalOfficer',
    'DRConfidentialBranchRO',
    'DRTeacherCellRO',
    'DRHomeLoanBranchRO',
    'DRAcademicCellRO'
);

global $deptNameArray;
$deptNameArray = array(
    "সভাপতি,<br>কম্পিউটার সায়েন্সে এন্ড ইঞ্জিনিয়ারিং বিভাগ",
    "হিসাব রক্ষক",
    "গ্রন্থাগারিক",
    "কলেজ পরিদর্শক",
    "পরীক্ষা নিয়ন্ত্রক ",
    "প্রধান প্রকৌশলী",
    "পরিচালক, <br>পরিকল্পনা ও উন্নয়ন দপ্তর",
    "চীফ মেডিকেল অফিসার",
    "ডেপুটি রেজিস্ট্রার (গোপনীয় শাখা)<br>রেজিস্ট্রার অফিস",
    "উপ-রেজিস্ট্রার (শিক্ষক সেল)<br>রেজিস্ট্রার অফিস",
    "ডেপুটি রেজিস্ট্রার (গৃহঋণ) এষ্টেট শাখা<br>রেজিস্ট্রার অফিস",
    "ডেপুটি রেজিস্ট্রার (একাডেমিক শাখা) <br>রেজিস্ট্রার অফিস",
);

$deptArray = array(
    'ViceChancellor',
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
    'DRHomeLoanBranchRO',
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
    'RegToHigherStd2' => 13,
    'AllDeptApproved' => 14
);
//     
