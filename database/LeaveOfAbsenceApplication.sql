CREATE TABLE `LeaveOfAbsenceApplication`( 
    `ApplicationID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `ApplicationDate` date,
    `ApprovalDate` date, 
    `NatureOfApplication` varchar(255),
    `From` date,
    `To` date,
    `Permission` varchar(255),
    `Ground` varchar(255),
    `UserIDref` int(11), 
    `ProgressState` int(3),
    `ProcessIDref` int(3),
    FOREIGN KEY (`UserIDref`) REFERENCES `users`(`UserID`) ON DELETE CASCADE ON UPDATE RESTRICT,
    FOREIGN KEY(`ProcessIDref`) REFERENCES `Process`(`ProcessID`)
    );