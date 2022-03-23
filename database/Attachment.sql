CREATE TABLE `Attachment`(`AttachmentID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                       `ProcessIDref` int(11),
                       `Type` varchar(50) NOT NULL,
                       `Directory` varchar(255) NOT NULL,
                      FOREIGN KEY (`ProcessIDref`) REFERENCES `Process`(`ProcessID`) ON DELETE CASCADE ON UPDATE RESTRICT);