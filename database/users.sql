CREATE TABLE `Users` (
    `UserID` int NOT NULL,
    `UserName` varchar(255) NOT NULL,
    `Mobile` varchar(12) NOT NULL,
    `Email` varchar(255) NOT NULL,
    `Password` varchar(255) NOT NULL,
    `RoleIDref` int,
    `RecoveryOtp` int(11),
    PRIMARY KEY (`UserID`),
    FOREIGN KEY (`RoleIDref`) REFERENCES `UserRole`(`RoleID`)
); 

ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;