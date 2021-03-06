CREATE TABLE `PersonalInfo` (
  `InfoID` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `UserIDref` int(11) NOT NULL,
  `Designation` varchar(30) NOT NULL,
  `WorkingUnit` varchar(50) NOT NULL,
  `Permanent` varchar(10) NOT NULL,
  `NationalID` varchar(20) NOT NULL,
  `ReferenceName` varchar(50) NOT NULL,
  `Relation` varchar(10) NOT NULL,
  `Child1Name` varchar(50),
  `Child2Name` varchar(50),
  `Child1Gender` varchar(10),
  `Child2Gender` varchar(10),
  `Child1Age` int(3),
  `Child2Age` int(3),
  `RetirementDate` date,
  `ProfileIMGDirectory` varchar(255),
  `SignatureIMGDirectory` varchar(255),
   FOREIGN KEY (`UserIDref`) REFERENCES `users`(`UserID`) ON DELETE CASCADE ON UPDATE RESTRICT
);