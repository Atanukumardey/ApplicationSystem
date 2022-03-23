CREATE TABLE `NocApplication`( 
    `NocID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `NocVersion` int(5),
    `ApplicationDate` date,
    `ApprovalDate` date, 
    `UserIDref` int(11), 
    `ProgressState` int(3),
    `ProcessIDref` int(3),
    FOREIGN KEY (`UserIDref`) REFERENCES `users`(`UserID`) ON DELETE CASCADE ON UPDATE RESTRICT,
    FOREIGN KEY(`ProcessIDref`) REFERENCES `Process`(`ProcessID`)
    );