CREATE TABLE `UserRole`(
    `RoleID` INT(11) NOT NULL,
    `RoleName` VARCHAR(255) NOT NULL
); INSERT INTO `UserRole`(`RoleId`, `RoleName`)
VALUES(1, 'user'),(2, 'AccountsController'),(3, 'CollegeInspector'),(4, 'Librarian'),(5, 'ExamController'),(6, 'ChiefEngineer'),(7, 'ChiefMedicalOfficer'),(8, 'DirectorDPD'),(9, 'DRTeacherCellRO'),(10, 'DRAcademicCellRO'),(11, 'DRHomeLoanBranchRO'),(12, 'DRConfidentialBranchRO'),(13, 'Verifier'),(14, 'Admin'),(15, 'DepartmentChairman'),(16, 'Registrar'),(17, 'DRHigherStudyBranchRO'),(18, 'ViceChancellor');
ALTER TABLE
    `UserRole` ADD PRIMARY KEY(`RoleId`);
ALTER TABLE
    `UserRole` MODIFY `RoleId` INT(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;