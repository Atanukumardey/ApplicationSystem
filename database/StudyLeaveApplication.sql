CREATE TABLE `StudyLeaveApplication`( 
    `ApplicationID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `ApplicationDate` date,
    `ApprovalDate` date, 
    `NameOfProgram` varchar(255),
    `University` varchar(255),
    `Department` varchar(255),
    `FinancialSource` varchar(255),
    `StartsFrom` date,
    `ProgramDuration` int(3), -- duration in year
    `LeaveStartDate` date,
    `UserIDref` int(11), 
    `ProgressState` int(3),
    `ProcessIDref` int(3),
    FOREIGN KEY (`UserIDref`) REFERENCES `users`(`UserID`) ON DELETE CASCADE ON UPDATE RESTRICT,
    FOREIGN KEY(`ProcessIDref`) REFERENCES `Process`(`ProcessID`)
    );